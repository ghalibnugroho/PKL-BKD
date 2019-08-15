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
    public function getPegawai($keyword)
    {
        $query = $this->db->select("NAMA")
            ->from('pegawai')
            ->like('NAMA', $keyword, 'both')
            ->order_by('NAMA', 'ASC')
            ->limit(10)
            ->get();

        //return $query->result();
        //$query2=$this->db->query("SELECT NAMA FROM pegawai");
        return $query->result();
    }
    public function getDaftarPegawai()
    {
        $query = $this->db->query('select NIP, NAMA, PANGKAT, GOLONGAN, JABATAN, TANGGALLAHIR FROM pegawai');
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
    public function getDataSPPD($id){
        $query = $this->db->select("TUJUAN, ID_SPPD, KODE, ALAT_ANGKUT, 
        TMP_BERANGKAT, TMP_TUJUAN, TGL_BERANGKAT, TGL_KEMBALI, LAMA, KETERANGAN , KATEGORI, INSTANSI")
        ->from('surattugas')
        ->join('sppd','sppd.ID_ST=surattugas.ID_ST')
        ->where('surattugas.ID_ST',$id)
        ->get();
        return $query->result();
    }


    public function insertSurattugas($data_insert)
    {
        $this->db->insert('surattugas', $data_insert);
        $id = $this->db->insert_id();
        $data_sppd = array(
            'ID_ST' => $id,
        );
        $this->db->insert('sppd', $data_sppd);
        return $id;
    }
    public function insertPeserta($data_insert)
    {
        $this->db->insert('peserta', $data_insert);
    }
    public function getListSPPD()
    {
        $query = $this->db->select("surattugas.ID_ST,DASAR,INSTANSI, TGL_BERANGKAT,TGL_KEMBALI,NAMA")
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
        $query = $this->db->select("surattugas.ID_ST,DASAR,TANGGAL,NAMA")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
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
        $query = $this->db->select("NAMA")
            ->from('pegawai')
            ->join('peserta', 'peserta.NIP = pegawai.NIP')
            ->where('peserta.ID_ST', $id)
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

    function getKegiatan($user){

        $query = $this->db->select("KODE, NAMA_KEGIATAN")
        ->from('kegiatan')
        ->join('bidang','kegiatan.ID_BIDANG = bidang.ID_BIDANG')
        ->where('NAMA_BIDANG',$user)
        ->get();

        return $query->result();
    }
    function getKodeKegiatan($kegiatan){
        $query = $this->db->select("KODE")
        ->from('kegiatan')
        ->where('NAMA_KEGIATAN',$kegiatan)
        ->get();
        
        $kode = $query->result();
        return $kode[0]->KODE;
    }
    function getNamaKegiatan($kode){
        $query = $this->db->select("NAMA_KEGIATAN")
        ->from('kegiatan')
        ->where('KODE',$kode)
        ->get();
        
        $kode = $query->result();
        return $kode[0]->NAMA_KEGIATAN;
    }
}
