<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function index()
    {
        $data = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        echo 'selamat datang ' . $data['name'] . ' :)';
    }
}
