<?php

class PegawaiModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getDaftarPegawai()
    {
        $query = $this->db->query('select NIP, NAMA, PANGKAT, GOLONGAN, JABATAN, ID_BIDANG, TANGGALLAHIR, TINGKAT FROM pegawai');
        return $query->result();
    }

    public function getAllNIP(){
        $query = $this->db->select('NIP')
        ->from('pegawai')
        ->get();
    return $query->result();
    }

    function fetch_data($query)
    {
        $this->db->select("*");
        $this->db->from("pegawai")
        ->where('AKTIF', 1);
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
    public function getIdBidangPegawai($nip)
    {
        $query = $this->db->select('ID_BIDANG')
            ->from('pegawai')
            ->where('NIP', $nip)
            ->get();
        return $query->result();
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
    public function insertPegawai($data_pegawai)
    {
        $this->db->insert('pegawai', $data_pegawai);
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

    public function getNIP($nama)
    {
        $nip = array();
        //$query = $this->db->select("NIP")->from('pegawai')->where('NAMA',$nama)->get();
        foreach ($nama as $n) {
            $nip[] = $this->db->select("NIP")->from('pegawai')->where('NAMA', $n)->get()->result();
        }
        return $nip;
    }
    function getBidang()
    {
        $query = $this->db->select("ID_BIDANG, NAMA_BIDANG")
            ->from('bidang')
            ->get();

        return $query->result();
    }
    function getAdm()
    {
        $query = $this->db->select("ID_ADM")
            ->from('admin')
            ->get();

        return $query->result();
    }
    public function total_pegawai()
    {
        $query = $this->db->query('select count(*) as total_pegawai FROM pegawai');
        return $query->result();
    }
}
