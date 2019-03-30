<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('data_model');
    }

    public function index()
    {
        $data['title'] = 'PKL_INF';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }

    public function registration()
    {
        $this->form_validation->set_rules('fullName', 'Full Name', 'required|trim'); //trim untuk menghilangkan spasi agar tdk masuk ke database
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!',
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!',
        ]); //matches untuk singkronisasi
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]'); //min_length untuk input minimal <-> matches untuk singkronisasi
        if ($this->form_validation->run() == false) {
            $data['title'] = 'PKL_INF - Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $this->data_model->regist();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! Akun anda telah terdaftar. Silahkan Login</div>');
            redirect(base_url());
        }
    }
}
