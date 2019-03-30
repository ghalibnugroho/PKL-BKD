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
            'name' => $this->input->post('fullName'),
            'email' => $this->input->post('email'),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 1,
            'date_created' => time(),
        ];
        $this->db->insert('user', $data);
    }
}
