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
            'name' => htmlspecialchars($this->input->post('fullName', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 1,
            'date_created' => time(),
        ];
        $this->db->insert('account_bkd', $data);
    }
    public function datalogin()
    {
        $data = $this->db->get_where('bidang', ['username' => $this->session->userdata('username')])->row_array();
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
         ->limit(10)
         ->get();
 
         //return $query->result();
         //$query2=$this->db->query("SELECT NAMA FROM pegawai");
         return $query->result();
 
     }
}
