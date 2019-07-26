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
            $result = $this->data_model->getPegawai($_GET['term']);
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
    public function insertSPPD(){
        $pemerintah = $this->input->post('pemerintah');
        $pegawai_diperintah = $this->input->post('pegawai_diperintah');
        $maksud = $this->input->post('maksud');
        $alat_angkut = $this->input->post('alat_angkut');
        $tempat_berangkat = $this->input->post('tempat_berangkat');
        $tempat_tujuan = $this->input->post('tempat_tujuan');
        $tgl_berangkat = $this->input->post('tgl_berangkat');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $pengikut = $this->input->post('pengikut');
        $instansi = $this->input->post('instansi');
        $keterangan = $this->input->post('keterangan');

        $data_insert = array(
                        'ID_SPPD'=>'90',
                        'ALAT_ANGKUT'=>$alat_angkut,
                        'TMP_BERANGKAT'=>$tempat_berangkat,
                        'TMP_TUJUAN'=>$tempat_tujuan,
                        'TGL_BERANGKAT'=>$tgl_berangkat,
                        'TGL_KEMBALI'=>$tgl_kembali,
                        'LAMA'=>'4',
                        'KETERANGAN'=>$keterangan,
                        'KATEGORI'=>'1',
                        'INSTANSI'=>$pengikut,
        );
        $this->data_model->insertSPPD($data_insert);
        $this->load->view('home');
         
         
         

    }
}
