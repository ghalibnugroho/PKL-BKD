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
            'ID_BIDANG' => htmlspecialchars(''),
            'NAMA_BIDANG' => htmlspecialchars($this->input->post('fullName', true)),
            'PASSWORD' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        ];
        $this->db->insert('bidang', $data);
    }
    public function datalogin()
    {
        $data = $this->db->get_where('bidang', ['NAMA_BIDANG' => $this->session->userdata('username')])->row_array();
        return $data;
    }
    public function getPegawai($keyword){
       $query=$this->db->select("NAMA")
        ->from('pegawai')
        ->like('NAMA', $keyword , 'both')
        ->order_by('NAMA', 'ASC')
        ->limit(10)
        ->get();

        //return $query->result();
        //$query2=$this->db->query("SELECT NAMA FROM pegawai");
        return $query->result();

    }
    public function getPegawaiAll(){
        $query=$this->db->select("NAMA")
         ->from('pegawai')
         ->order_by('NAMA', 'ASC')
         ->get();
 
         //return $query->result();
         //$query2=$this->db->query("SELECT NAMA FROM pegawai");
         return $query->result();
 
    }
    public function insertSPPD($data_insert){
        $this->db->insert('sppd',$data_insert);
    }

    public function insertSurattugas($data_insert){
        $this->db->insert('surattugas',$data_insert);
        $id=$this->db->insert_id();
        $data_sppd = array(
            'ID_ST'=> $id,
        );
        $this->db->insert('sppd',$data_sppd);
        return $id;
    }
    public function insertPeserta($data_insert){
        $this->db->insert('peserta',$data_insert);
    }
    public function getListSPPD(){
        $query=$this->db->select("surattugas.ID_ST,DASAR,TANGGAL,NAMA")
        ->from('surattugas')
        ->join('peserta','surattugas.ID_ST=peserta.ID_ST')
        ->join('pegawai','pegawai.NIP=peserta.NIP')
        ->where('peserta.SEBAGAI','diperintah')
        ->get();

        return $query->result();
    }
    public function getNIP($nama){
        $nip=array();
        //$query = $this->db->select("NIP")->from('pegawai')->where('NAMA',$nama)->get();
        foreach ($nama as $n ) {
            $nip[]=$this->db->select("NIP")->from('pegawai')->where('NAMA',$n)->get()->result();
        }
        return $nip;
    }
}
