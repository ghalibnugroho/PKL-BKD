<?php

class KegiatanModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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
    public function insertKegiatan($data_Kegiatan)
    {
        $this->db->insert('kegiatan', $data_Kegiatan);
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

    function getNamaKegiatan($kode)
    {
        $query = $this->db->select("NAMA_KEGIATAN")
            ->from('kegiatan')
            ->where('KODE', $kode)
            ->get();

        $kode = $query->result();
        return $kode[0]->NAMA_KEGIATAN;
    }
    function total_kegiatan()
    {
        $query = $this->db->query("select count(*) as total_kegiatan from kegiatan");
        return $query->result();
    }
}
