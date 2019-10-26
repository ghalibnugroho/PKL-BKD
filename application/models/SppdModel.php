<?php

class SppdModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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





}
