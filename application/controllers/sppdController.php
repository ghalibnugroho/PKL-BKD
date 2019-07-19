<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sppdController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
    }
    public function contohsurat()
    {
        $this->load->view('surat/contohsurat');
    }
    public function listsppd()
    {
        $this->load->view('listsppd');
    }
    public function sppd()
    {
        $this->load->view('sppd');

    }
    public function surattugas()
    {
        $this->load->view('surattugas');
    }
    public function rincianbiaya()
    {
        $this->load->view('rincianbiaya');
    }

    public function getPegawai(){
        if (isset($_GET['term'])) {
            $result = $this->data_model->getPegawaiAll();
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->NAMA;
                echo json_encode($arr_result);
            }
        }
    }
    public function getPegawaiAll(){
            $result = $this->data_model->getPegawaiAll();
            
            foreach ($result as $row)
                $arr_result[] = $row->NAMA;
            header('Content-Type: application/json');
            echo json_encode(['suggestions'=>$arr_result]);
            
    }
}
