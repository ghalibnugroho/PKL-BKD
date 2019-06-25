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
        $this->load->view('home', $data);

    }
    public function contohsurat()
    {
        $this->load->view('surat/contohsurat');
    }
}
