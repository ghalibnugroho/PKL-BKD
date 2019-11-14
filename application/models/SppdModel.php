<?php

class SppdModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataSPPD($id)
    {
        $query = $this->db->select("surattugas.ID_ST,TUJUAN, ID_SPPD, KODE, ALAT_ANGKUT, 
        TMP_BERANGKAT, TMP_TUJUAN, TGL_BERANGKAT, TGL_KEMBALI, LAMA, KETERANGAN , KATEGORI, INSTANSI")
            ->from('surattugas')
            ->join('sppd', 'sppd.ID_ST=surattugas.ID_ST')
            ->where('surattugas.ID_ST', $id)
            ->get();
        return $query->result();
    }
    public function getInstansi($id)
    {
        $query = $this->db->select("ID_INSTANSI,instansitujuan.INSTANSI,TANGGAL")
            ->from('instansitujuan')
            ->join('sppd', 'sppd.ID_SPPD=instansitujuan.ID_SPPD')
            ->where('sppd.ID_ST', $id)
            ->get();
        return $query->result();
    }

    // public function getListSPPD($user)
    // {
    //     $query = $this->db->select("surattugas.ID_ST,sppd.ID_SPPD,DASAR,INSTANSI, DATE_FORMAT(TGL_BERANGKAT,'%d-%m-%Y') as TGL_BERANGKAT,DATE_FORMAT(TGL_KEMBALI,'%d-%m-%Y')TGL_KEMBALI,NAMA, KATEGORI")
    //         ->from('surattugas')
    //         ->join('sppd', 'surattugas.ID_ST=sppd.ID_ST')
    //         ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
    //         ->join('pegawai', 'pegawai.NIP=peserta.NIP')
    //         ->where('peserta.SEBAGAI', 'Kepala')
    //         ->order_by('TGL_BERANGKAT', 'DESC')
    //         ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
    //         ->where('bidang.NAMA_BIDANG', $user)
    //         ->get();

    //     return $query->result();
    // }
    public function getListSPPD($user)
    {
        $query = $this->db->select("surattugas.ID_ST,sppd.ID_SPPD,DASAR,INSTANSI, DATE_FORMAT(TGL_BERANGKAT,'%d-%m-%Y') as TGL_BERANGKAT,DATE_FORMAT(TGL_KEMBALI,'%d-%m-%Y')TGL_KEMBALI,NAMA, KATEGORI")
            ->from('surattugas')
            ->join('sppd', 'surattugas.ID_ST=sppd.ID_ST')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->order_by('TGL_BERANGKAT', 'DESC')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.NAMA_BIDANG', $user)
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
    public function total_sppd()
    {
        $query = $this->db->query('SELECT count(*) as total_sppd FROM `sppd` where KODE & ALAT_ANGKUT & TMP_BERANGKAT & TMP_TUJUAN & TGL_BERANGKAT & TGL_KEMBALI & LAMA & KATEGORI & INSTANSI IS NOT NULL');
        return $query->result();
    }
    public function total_kategori_dinas_dalam()
    {
        $query = $this->db->query('SELECT count(*) as dinas_dalam FROM `sppd` where KATEGORI = "Dinas Dalam"');
        return $query->result();
    }
    public function total_kategori_dinas_dalam_bidang($user)
    {
        $query = $this->db->select("count(*) as dinas_dalam")
            ->from('sppd')
            ->join('surattugas', 'sppd.ID_ST=surattugas.ID_ST')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.NAMA_BIDANG', $user)
            ->where('sppd.KATEGORI', 'Dinas Dalam')
            ->get();
        return $query->result();
    }
    public function total_kategori_dinas_luar()
    {
        $query = $this->db->query('SELECT count(*) as dinas_luar FROM `sppd` where KATEGORI = "Dinas Luar"');
        return $query->result();
    }
    public function total_kategori_dinas_luar_bidang($user)
    {
        $query = $this->db->select("count(*) as dinas_luar")
            ->from('sppd')
            ->join('surattugas', 'sppd.ID_ST=surattugas.ID_ST')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.NAMA_BIDANG', $user)
            ->where('sppd.KATEGORI', 'Dinas Luar')
            ->get();
        return $query->result();
    }
    public function bulan_tahun_sppd()
    {
        $query = $this->db->query('SELECT DISTINCT date_format(TGL_BERANGKAT, "%M-%Y") as bulan_tahun FROM sppd where TGL_BERANGKAT is NOT NULL ORDER BY STR_TO_DATE( bulan_tahun, "%M-%Y" ) DESC limit 12 ');
        return $query->result_array();
    }
    public function jumlah_sppd_berangkat($bulan, $tahun)
    {
        // $query = $this->db->query('SELECT count(*) as jumlah_sppd from `sppd` where date_format(TGL_BERANGKAT, "%M") = ' + $bulan + '&& YEAR(TGL_BERANGKAT) =' + $tahun);
        $query = $this->db->select("count(*) as jumlah_sppd")
            ->from('sppd')
            ->where('date_format(TGL_BERANGKAT, "%M") =', $bulan)
            ->where('YEAR(TGL_BERANGKAT)', $tahun)
            ->get();
        return $query->result_array();
    }
    public function countGetSppd($id)
    {
        $query = $this->db->select("count(*) as jumlah_sppd")
            ->from('surattugas')
            ->join('sppd', 'surattugas.ID_ST=sppd.ID_ST')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->order_by('TGL_BERANGKAT', 'DESC')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.ID_BIDANG', $id)
            ->where('sppd.KODE IS NOT NULL')
            ->where('sppd.ALAT_ANGKUT IS NOT NULL')
            ->where('sppd.TMP_BERANGKAT IS NOT NULL')
            ->where('sppd.TGL_BERANGKAT IS NOT NULL')
            ->where('sppd.TGL_KEMBALI IS NOT NULL')
            ->where('sppd.LAMA IS NOT NULL')
            ->where('sppd.KATEGORI IS NOT NULL')
            ->where('sppd.INSTANSI IS NOT NULL')
            ->get();
        return $query->result();
    }
}
