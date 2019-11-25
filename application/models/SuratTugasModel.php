<?php

class SuratTugasModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getIDST()
    {
        $query = $this->db->select_max('ID_ST')
            ->from('surattugas')
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
    public function getListST($user)
    {
        $query = $this->db->select("surattugas.ID_ST,DASAR,NOMOR_SURAT,NAMA")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.NAMA_BIDANG', $user)
            ->get();

        return $query->result();
    }
    public function getST($id)
    {
        $query = $this->db->select("surattugas.ID_ST,NOMOR_SURAT, DASAR,TUJUAN,TANGGAL,peserta.NIP,SEBAGAI,NAMA,PANGKAT, GOLONGAN, JABATAN")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('surattugas.ID_ST', $id)
            ->order_by('SEBAGAI', 'ASC')
            ->order_by('GOLONGAN', 'ASC')
            ->get();
        return $query->result();
    }

    public function getPeserta()
    {
        if(func_num_args()==1){
            $id = func_get_arg(0);
            $query = $this->db->select("NAMA,peserta.NIP, peserta.ID_PESERTA,sppd.ID_SPPD,SEBAGAI")
            ->from('pegawai')
            ->join('peserta', 'peserta.NIP = pegawai.NIP')
            ->join('sppd', 'sppd.ID_ST = peserta.ID_ST')
            ->where('sppd.ID_ST', $id)
            ->get();
        } else{
            $query = $this->db->select("NAMA, NIP")
            ->from('pegawai')
            ->get();
        }
        return $query->result();
    }
    public function total_st()
    {
        $query = $this->db->query('select count(*) as total_st FROM surattugas');
        return $query->result();
    }
    public function countGetListST($user)
    {
        $query = $this->db->select("count(*) as jumlah_st")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.NAMA_BIDANG', $user)
            ->get();
        return $query->result();
    }
}
