<?php

class data_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function regist()
    {
        $data = [
            // 'ID_BIDANG' => htmlspecialchars(''),
            // 'NAMA_BIDANG' => htmlspecialchars($this->input->post('fullName', true)),
            'ID_ADM' => htmlspecialchars($this->input->post('fullName', true)),
            'PASSWORD' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        ];
        $this->db->insert('admin', $data);
    }

    public function datalogin()
    {
        $data = $this->db->get_where('bidang', ['NAMA_BIDANG' => $this->session->userdata('username')])->row_array();
        return $data;
    }

    public function getDaftarPegawai()
    {
        $query = $this->db->query('select NIP, NAMA, PANGKAT, GOLONGAN, JABATAN, ID_BIDANG, TANGGALLAHIR, TINGKAT FROM pegawai');
        return $query->result();
    }

    function fetch_data($query)
    {
        $this->db->select("*");
        $this->db->from("pegawai");
        if ($query != '') {
            $this->db->like('NAMA', $query);
            $this->db->or_like('GOLONGAN', $query);
            $this->db->or_like('PANGKAT', $query);
            $this->db->or_like('JABATAN', $query);
            $this->db->or_like('TANGGALLAHIR', $query);
            $this->db->or_like('NIP', $query);
        }
        $this->db->order_by('NAMA', 'ASC');
        return $this->db->get();
    }

    public function getDaftarKegiatan()
    {
        $query = $this->db->query('select kode, nip_pptk, nama, nama_kegiatan, kegiatan.id_bidang FROM kegiatan Join pegawai ON kegiatan.NIP_PPTK = pegawai.NIP ');
        return $query->result();
    }

    function fetch_dataKegiatan($query)
    {
        $this->db->select("KODE, NIP_PPTK, NAMA, NAMA_KEGIATAN");
        $this->db->from("kegiatan");
        $this->db->join("pegawai", "kegiatan.NIP_PPTK = pegawai.NIP");
        if ($query != '') {
            $this->db->like('NAMA', $query);
            $this->db->or_like('KODE', $query);
            $this->db->or_like('NAMA_KEGIATAN', $query);
            $this->db->or_like('NIP_PPTK', $query);
        }
        $this->db->order_by('NAMA', 'ASC');
        return $this->db->get();
    }
    public function getPegawaiAll()
    {
        $query = $this->db->select("NAMA")
            ->from('pegawai')
            ->order_by('NAMA', 'ASC')
            ->get();

        //return $query->result();
        //$query2=$this->db->query("SELECT NAMA FROM pegawai");
        return $query->result();
    }

    public function getIdBidangPegawai($nip)
    {
        $query = $this->db->select('ID_BIDANG')
            ->from('pegawai')
            ->where('NIP', $nip)
            ->get();
        return $query->result();
    }

    public function getDataSPPD($id)
    {
        $query = $this->db->select("TUJUAN, ID_SPPD, KODE, ALAT_ANGKUT, 
        TMP_BERANGKAT, TMP_TUJUAN, TGL_BERANGKAT, TGL_KEMBALI, LAMA, KETERANGAN , KATEGORI, INSTANSI")
            ->from('surattugas')
            ->join('sppd', 'sppd.ID_ST=surattugas.ID_ST')
            ->where('surattugas.ID_ST', $id)
            ->get();
        return $query->result();
    }
    function getIDST()
    {
        $query = $this->db->select_max('ID_ST')
            ->from('surattugas')
            ->get();
        return $query->result();
    }

    function getRincian($id)
    {
        $query = $this->db->select('*')
            ->from('rincian')
            ->where('ID_SPPD', $id)
            ->get();
        return $query->result();
    }
    public function insertSurattugas($data_insert, $id)
    {
        $this->db->insert('surattugas', $data_insert);
        $data_sppd = array(
            'ID_ST' => $id,
        );
        $this->db->insert('sppd', $data_sppd);
    }

    public function insertPeserta($data_insert)
    {
        $this->db->insert('peserta', $data_insert);
    }
    public function insertPegawai($data_pegawai)
    {
        $this->db->insert('pegawai', $data_pegawai);
    }
    public function insertKegiatan($data_Kegiatan)
    {
        $this->db->insert('kegiatan', $data_Kegiatan);
    }
    public function getListSPPD()
    {
        $query = $this->db->select("surattugas.ID_ST,sppd.ID_SPPD,DASAR,INSTANSI, DATE_FORMAT(TGL_BERANGKAT,'%d-%m-%Y') as TGL_BERANGKAT,DATE_FORMAT(TGL_KEMBALI,'%d-%m-%Y')TGL_KEMBALI,NAMA")
            ->from('surattugas')
            ->join('sppd', 'surattugas.ID_ST=sppd.ID_ST')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->get();

        return $query->result();
    }
    public function getListST()
    {
        $query = $this->db->select("surattugas.ID_ST,DASAR,DATE_FORMAT(TANGGAL,'%d-%m-%Y') as TANGGAL,NAMA")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->get();

        return $query->result();
    }
    public function getListRincian()
    {
        $query = $this->db->select("surattugas.ID_ST,sppd.ID_SPPD,TUJUAN,NAMA")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->join('sppd', 'surattugas.ID_ST=sppd.ID_ST')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->get();

        return $query->result();
    }

    public function getST($id)
    {
        $query = $this->db->select("surattugas.ID_ST,DASAR,TUJUAN,TANGGAL,peserta.NIP,SEBAGAI,NAMA,PANGKAT, GOLONGAN, JABATAN")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('surattugas.ID_ST', $id)
            ->order_by('SEBAGAI', 'ASC')
            ->order_by('GOLONGAN', 'ASC')
            ->get();
        return $query->result();
    }

    public function getPegawai_Jabatan($jabatan)
    {
        return $this->db->select('*')->from('pegawai')->where('JABATAN', $jabatan)->get()->result();
    }

    public function getPegawai_NIP($nip)
    {
        return $this->db->select('*')->from('pegawai')->where('NIP', $nip)->get()->result();
    }

    public function getNip_PPTK($id_sppd)
    {
        $query = $this->db->select('NIP_PPTK')
            ->from('kegiatan')
            ->join('sppd', 'sppd.KODE=kegiatan.KODE')
            ->where('ID_SPPD', $id_sppd)
            ->get();

        return $query->result();
    }

    public function getSPPD($id)
    {
        $query = $this->db->select("KODE, ALAT_ANGKUT, TMP_BERANGKAT, TMP_TUJUAN, TGL_BERANGKAT, TGL_KEMBALI, KATEGORI, LAMA, DASAR, TUJUAN, SEBAGAI, peserta.NIP,NAMA,PANGKAT, GOLONGAN, JABATAN, TINGKAT, TANGGALLAHIR")
            ->from('sppd')
            ->join('surattugas', 'surattugas.ID_ST=sppd.ID_ST')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('ID_SPPD', $id)
            ->order_by('SEBAGAI', 'ASC')
            ->order_by('GOLONGAN', 'ASC')
            ->get();
        return $query->result();
    }

    public function getNIP($nama)
    {
        $nip = array();
        //$query = $this->db->select("NIP")->from('pegawai')->where('NAMA',$nama)->get();
        foreach ($nama as $n) {
            $nip[] = $this->db->select("NIP")->from('pegawai')->where('NAMA', $n)->get()->result();
        }
        return $nip;
    }
    public function getPeserta($id)
    {
        $query = $this->db->select("NAMA,peserta.NIP, peserta.ID_PESERTA,sppd.ID_SPPD,SEBAGAI")
            ->from('pegawai')
            ->join('peserta', 'peserta.NIP = pegawai.NIP')
            ->join('sppd', 'sppd.ID_ST = peserta.ID_ST')
            ->where('sppd.ID_ST', $id)
            ->get();

        return $query->result();
    }
    public function getPesertaRincian($id)
    {
        $query = $this->db->select("pegawai.NAMA,peserta.ID_PESERTA,sppd.ID_SPPD")
            ->from('pegawai')
            ->join('peserta', 'peserta.NIP = pegawai.NIP')
            ->join('sppd', 'sppd.ID_ST = peserta.ID_ST')
            ->where('sppd.ID_SPPD', $id)
            ->get();

        return $query->result();
    }

    public function update($where, $table, $data)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function read($where, $table)
    {
        return $this->db->get_where($table, $where)->result();
    }

    function insertData($table, $data_insert)
    {
        $this->db->insert($table, $data_insert);
    }
    function getKegiatan($user)
    {

        $query = $this->db->select("KODE, NAMA_KEGIATAN")
            ->from('kegiatan')
            ->join('bidang', 'kegiatan.ID_BIDANG = bidang.ID_BIDANG')
            ->where('NAMA_BIDANG', $user)
            ->get();

        return $query->result();
    }
    function getKodeKegiatan($kegiatan)
    {
        $query = $this->db->select("KODE")
            ->from('kegiatan')
            ->where('NAMA_KEGIATAN', $kegiatan)
            ->get();

        $kode = $query->result();
        return $kode[0]->KODE;
    }
    function getBidang(){
        $query = $this->db->select("ID_BIDANG, NAMA_BIDANG")
        ->from('bidang')
        ->get();
        
        return $query->result();
    }
    function getPassword($idbidang){
        $query = $this->db->select("PASSWORD")
        ->from('bidang')
        ->where('ID_BIDANG',$idbidang)
        ->get();
        $pass = $query->result();
        return $pass[0]->PASSWORD;
    }
    function getNamaKegiatan($kode){
        $query = $this->db->select("NAMA_KEGIATAN")
            ->from('kegiatan')
            ->where('KODE', $kode)
            ->get();

        $kode = $query->result();
        return $kode[0]->NAMA_KEGIATAN;
    }

    function exportDataRincian($id){
        $query= $this->db->select('*')
        ->from('rincian')
        ->join('peserta','rincian.ID_PESERTA = peserta.ID_PESERTA')
        ->join('pegawai','peserta.NIP = pegawai.NIP')
        ->where('ID_SPPD', $id)
        ->order_by('peserta.SEBAGAI ASC , rincian.ID_PESERTA ASC')
        ->order_by("JENIS = 'Transportasi'",'DESC')
        ->order_by("JENIS = 'Uang Harian'",'DESC')
        ->order_by("JENIS = 'Uang Representatif'",'DESC')
        ->order_by("JENIS = 'Penginapan'",'DESC')
        ->order_by("STATUS = 'Pergi'",'DESC')
        ->order_by("STATUS = 'Pulang'",'DESC')
        ->order_by('rincian.ID_RINCIAN ASC')
        ->get();
        
        return $query->result();
    }

    function getRekap($thn){
        $query= $this->db->select('rincian.ID_PESERTA, NAMA, pegawai.NIP, GOLONGAN, DASAR, sppd.TMP_TUJUAN as DAERAH_TUJUAN, TGL_BERANGKAT, TGL_KEMBALI, INSTANSI, LAMA, KATEGORI, JENIS, TOTAL, NO_TIKET, rincian.KETERANGAN, NO_FLIGHT, JAM, NO_TMPDUDUK, rincian.TANGGAL, rincian.TMP_BERANGKAT, rincian.TMP_TUJUAN, HARGA, STATUS')
        ->from('rincian')
        ->join('peserta','rincian.ID_PESERTA = peserta.ID_PESERTA')
        ->join('pegawai','peserta.NIP = pegawai.NIP')
        ->join('sppd', 'sppd.ID_SPPD = rincian.ID_SPPD')
        ->join('surattugas','sppd.ID_ST = surattugas.ID_ST')
        ->where('YEAR(TGL_BERANGKAT)', $thn)
        ->order_by('rincian.ID_SPPD ASC, peserta.SEBAGAI ASC , rincian.ID_PESERTA ASC')
        ->order_by("JENIS = 'Transportasi'",'DESC')
        ->order_by("JENIS = 'Uang Harian'",'DESC')
        ->order_by("JENIS = 'Uang Representatif'",'DESC')
        ->order_by("JENIS = 'Penginapan'",'DESC')
        ->order_by("STATUS = 'Pergi'",'DESC')
        ->order_by("STATUS = 'Pulang'",'DESC')
        ->order_by('rincian.ID_RINCIAN ASC')
        ->get();
        
        return $query->result();
    }
}
