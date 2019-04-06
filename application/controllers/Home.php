<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->view('templates/auth_header');
        $this->load->view('templates/auth_footer');
    }


    public function homes(){
        $this->load->model('data_model');
        $data = $this->data_model->datalogin();
        $this->load->view('dashboard',$data);
        


    }
}
