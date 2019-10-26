<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('UserModel');
        $this->load->model('PegawaiModel');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required'); //trim untuk menghilangkan spasi agar tdk masuk ke database
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'PKL_BKD';
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('bidang', ['NAMA_BIDANG' => $username])->row_array(); //var_dump() & die; paket untuk check nilai variable
        $admin = $this->db->get_where('admin', ['ID_ADM' => $username])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya active
            if (password_verify($password, $user['PASSWORD'])) {
                $data = [
                    'username' => $user['NAMA_BIDANG'],
                    'priority' => 2
                ];
                $this->session->set_userdata($data);
                redirect(base_url('home')); // home -> halaman utama user
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password!</div>');
                redirect(base_url());
            }
        } else if ($admin) {
            if (password_verify($password, $admin['PASSWORD'])) {
                $data = [
                    'username' => $admin['ID_ADM'],
                    'priority' => 1
                ];
                $this->session->set_userdata($data);
                redirect(base_url('home')); // home -> halaman utama user
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password!</div>');
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Your Username is not registered!</div>');
            redirect(base_url());
        }
    }

    public function home()
    {

        $data = $this->UserModel->datalogin();
        $this->load->view('home', $data);
    }
    public function registration()
    {
        $this->form_validation->set_rules('fullName', 'Full Name', 'required|trim'); //trim untuk menghilangkan spasi agar tdk masuk ke database
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!',
        ]); //matches untuk singkronisasi
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]'); //min_length untuk input minimal <-> matches untuk singkronisasi
        if ($this->form_validation->run() == false) {
            $data['title'] = 'PKL_BKD - Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            // $this->load->view('templates/auth_footer');
        } else {
            $this->UserModel->regist();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! Akun anda telah terdaftar. Silahkan Login</div>');
            redirect(base_url());
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been logged out! :)</div>');
        redirect(base_url());
    }
    public function ubahPassword()
    {
        $result['list'] = $this->PegawaiModel->getBidang();
        $this->load->view('ubah_password', $result);
    }
    public function setpassword()
    {

        $idbidang = $this->input->post('idbidang');
        $passlama = $this->input->post('passlama');
        $passbaru = $this->input->post('passbaru1');
        $passbaru2 = $this->input->post('passbaru2');

        if ($passbaru == $passbaru2) {
            if (password_verify($passlama, $this->UserModel->getPassword($idbidang))) {
                $where = array('ID_BIDANG' => $idbidang);
                $data_insert = array(
                    'PASSWORD' => password_hash($passbaru, PASSWORD_DEFAULT)
                );
                $this->UserModel->update($where, 'bidang', $data_insert);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><b>Sukses! </b>Password berhasil diubah </div>');
                redirect('sppdController/ubahPassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><b>Password Lama anda salah!</b> ketik password lama anda dengan benar </div>');
                $this->ubahPassword();
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><b>Password anda tidak match </b> cocokkan kedua password baru anda </div>');
            redirect('sppdController/ubahPassword');
        }
    }
}
