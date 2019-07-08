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
}
