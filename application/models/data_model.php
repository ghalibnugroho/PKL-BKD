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
}
