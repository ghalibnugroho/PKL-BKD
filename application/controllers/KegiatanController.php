<?php
require("././fpdf/fpdf.php");
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KegiatanController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('KegiatanModel');
        $this->load->model('PegawaiModel');
        $this->load->library('form_validation');
    }
    public function daftarkegiatan()
    {
        $result['list'] = $this->KegiatanModel->getDaftarKegiatan();
        $result['NIP'] = $this->PegawaiModel->getAllNIP();
        $this->load->view('listkegiatan', $result);
    }

    public function fetchDataKegiatan()
    {
        $output = '';
        $query = '';
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->KegiatanModel->fetch_dataKegiatan($query);
        $output .=
            '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <col width="5%">
            <col width="5%">
            <col width="10%">
            <col width="5%">
            <col width="13%">
            <thead>
                <tr>
                    <th>KODE KEGIATAN</th>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>NAMA KEGIATAN</th>
                    <th>Action</th>
                </tr>
            </thead>
        ';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $KODE_TEMP = str_replace(".", "", $row->KODE);
                $output .= '
            <tr>
            <td>' . $row->KODE . '</td>
            <td>' . $row->NIP_PPTK . '</td>
            <td>' . $row->NAMA . '</td>
            <td>' . $row->NAMA_KEGIATAN . '</td>
            <td><a href="" data-target="#editKegiatan' . $KODE_TEMP . '" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info btn-action"><i class="fas fa-sm fa-edit"></i> Edit </a>
            <a href="" data-target="#hapusKegiatan' . $KODE_TEMP . '" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-danger btn-action"><i class="fas fa-sm fa-trash"></i> Hapus </a></td>
            </tr>
            ';
            }
        } else {
            $output .= '<tr>
            <td colspan="5">No Data Found</td>
            </tr>';
        }
        $output .= '</table>';
        echo $output;
    }
    public function addKegiatan()
    {
        $kode = $this->input->post('kode_kegiatan');
        $namaKegiatan = $this->input->post('nama_kegiatan');
        $nip = $this->input->post('nip_pegawai');
        $bidang = $this->input->post('bidang');

        $data_insert = array(
            'KODE' => $kode,
            'ID_BIDANG' => $bidang,
            'NIP_PPTK' => $nip,
            'NAMA_KEGIATAN' => $namaKegiatan
        );
        $this->KegiatanModel->insertKegiatan($data_insert);
        $this->session->set_flashdata('tambahKegiatan', '<div class="alert alert-success" role="alert">
        Tambah Kegiatan Berhasil!</div>');
        redirect('daftar-kegiatan');
    }

    public function editKegiatan()
    {
        $kode = $this->input->post('kode_kegiatan');
        $kode_hidden = $this->input->post('kode_hidden');
        $nip = $this->input->post('nip_pegawai');
        $namaKegiatan = $this->input->post('nama_kegiatan');
        $bidang = $this->input->post('bidang');

        $data_update = array(
            'KODE' => $kode,
            'ID_BIDANG' => $bidang,
            'NIP_PPTK' => $nip,
            'NAMA_KEGIATAN' => $namaKegiatan
        );
        $where = array('KODE' => $kode_hidden);
        $this->UserModel->update($where, 'kegiatan', $data_update);
        $this->session->set_flashdata('updateKegiatan', '<div class="alert alert-success" role="alert">
        Data Kegiatan Berhasil di Update!</div>');
        redirect('daftar-kegiatan');
    }

    public function hapusKegiatan($kode)
    {
        $where = array('KODE' => $kode);
        $this->UserModel->delete($where, 'kegiatan');
        $this->session->set_flashdata('hapusKegiatan', '<div class="alert alert-danger" role="alert">
        Kegiatan berhasil dihapus </div>');
        redirect('daftar-kegiatan');
    }
}
