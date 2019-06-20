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
        $data = $this->db->get_where('account_bkd', ['email' => $this->session->userdata('email')])->row_array();
        return $data;
    }
}
