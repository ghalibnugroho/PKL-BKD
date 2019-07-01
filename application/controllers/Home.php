<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('data_model');
        $data = $this->data_model->datalogin();
        if (!empty($this->session->userdata('email'))) {
            $this->load->view('home', $data);
        } else {
            redirect(base_url());
        }

    }
    public function contohsurat()
    {
        $this->load->view('surat/contohsurat');
    }
}
