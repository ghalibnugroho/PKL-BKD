<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sppdController extends CI_Controller
{

    public function contohsurat()
    {
        $this->load->view('surat/contohsurat');
    }
    public function listsppd()
    {
        $this->load->view('listsppd');
    }
    public function buatsppd()
    {
        $this->load->view('buatsppd');
    }
    public function surattugas()
    {
        $this->load->view('surattugas');
    }
}
