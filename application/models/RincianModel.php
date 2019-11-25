<?php

class RincianModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function getRincian($id)
    {
        $query = $this->db->select('*')
            ->from('rincian')
            ->where('ID_SPPD', $id)
            ->get();
        return $query->result();
    }
    function exportDataRincian($id)
    {
        $query = $this->db->select('*')
            ->from('rincian')
            ->join('peserta', 'rincian.ID_PESERTA = peserta.ID_PESERTA')
            ->join('pegawai', 'peserta.NIP = pegawai.NIP')
            ->where('ID_SPPD', $id)
            ->order_by('peserta.SEBAGAI ASC , rincian.ID_PESERTA ASC')
            ->order_by("JENIS = 'Transportasi'", 'DESC')
            ->order_by("JENIS = 'Uang Harian'", 'DESC')
            ->order_by("JENIS = 'Uang Representatif'", 'DESC')
            ->order_by("JENIS = 'Penginapan'", 'DESC')
            ->order_by("STATUS = 'Pergi'", 'DESC')
            ->order_by("STATUS = 'Pulang'", 'DESC')
            ->order_by('rincian.ID_RINCIAN ASC')
            ->get();

        return $query->result();
    }

    function getRekap($thn)
    {
        $query = $this->db->select('rincian.ID_PESERTA, NAMA, pegawai.NIP, GOLONGAN, DASAR, sppd.ID_SPPD, sppd.TMP_TUJUAN as DAERAH_TUJUAN, TGL_BERANGKAT, TGL_KEMBALI, LAMA, KATEGORI, JENIS, TOTAL, NO_TIKET, rincian.KETERANGAN, NO_FLIGHT, JAM, NO_TMPDUDUK, rincian.TANGGAL, rincian.TMP_BERANGKAT, rincian.TMP_TUJUAN, HARGA, STATUS')
            ->from('rincian')
            ->join('peserta', 'rincian.ID_PESERTA = peserta.ID_PESERTA')
            ->join('pegawai', 'peserta.NIP = pegawai.NIP')
            ->join('sppd', 'sppd.ID_SPPD = rincian.ID_SPPD')
            ->join('surattugas', 'sppd.ID_ST = surattugas.ID_ST')
            ->where('YEAR(TGL_BERANGKAT)', $thn)
            ->order_by('rincian.ID_SPPD ASC, peserta.SEBAGAI ASC , rincian.ID_PESERTA ASC')
            ->order_by("JENIS = 'Transportasi'", 'DESC')
            ->order_by("JENIS = 'Uang Harian'", 'DESC')
            ->order_by("JENIS = 'Uang Representatif'", 'DESC')
            ->order_by("JENIS = 'Penginapan'", 'DESC')
            ->order_by("STATUS = 'Pergi'", 'DESC')
            ->order_by("STATUS = 'Pulang'", 'DESC')
            ->order_by('rincian.ID_RINCIAN ASC')
            ->get();

        return $query->result();
    }

    function getTahunRekap()
    {
        $query = $this->db->select('DISTINCT YEAR(TGL_BERANGKAT) as tanggal')
            ->from('rincian')
            ->join('peserta', 'rincian.ID_PESERTA = peserta.ID_PESERTA')
            ->join('pegawai', 'peserta.NIP = pegawai.NIP')
            ->join('sppd', 'sppd.ID_SPPD = rincian.ID_SPPD')
            ->join('surattugas', 'sppd.ID_ST = surattugas.ID_ST')
            ->order_by('rincian.ID_SPPD ASC, peserta.SEBAGAI ASC , rincian.ID_PESERTA ASC')
            ->order_by("JENIS = 'Transportasi'", 'DESC')
            ->order_by("JENIS = 'Uang Harian'", 'DESC')
            ->order_by("JENIS = 'Uang Representatif'", 'DESC')
            ->order_by("JENIS = 'Penginapan'", 'DESC')
            ->order_by("STATUS = 'Pergi'", 'DESC')
            ->order_by("STATUS = 'Pulang'", 'DESC')
            ->order_by('rincian.ID_RINCIAN ASC')
            ->get();

        return $query->result();
    }
    
    public function getListRincian($user)
    {
        $query = $this->db->select("surattugas.ID_ST,sppd.ID_SPPD,TUJUAN,NAMA,sppd.KODE")
            ->from('surattugas')
            ->join('peserta', 'surattugas.ID_ST=peserta.ID_ST')
            ->join('pegawai', 'pegawai.NIP=peserta.NIP')
            ->join('sppd', 'surattugas.ID_ST=sppd.ID_ST')
            ->where('peserta.SEBAGAI', 'Kepala')
            ->join('bidang', 'bidang.ID_BIDANG=surattugas.ID_BIDANG')
            ->where('bidang.NAMA_BIDANG', $user)
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
    public function getMinYear(){
        $query = $this->db->select("TANGGAL")
        ->from('surattugas')
        ->order_by('TANGGAL ASC')
        ->limit(1)
        ->get();

    return $query->result();
    }
}