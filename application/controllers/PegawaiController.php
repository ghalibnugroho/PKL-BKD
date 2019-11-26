<?php
require("././fpdf/fpdf.php");
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PegawaiController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('PegawaiModel');
        $this->load->library('form_validation');
    }
    public function daftarpegawai()
    {
        if ($this->session->userdata('priority') == 1) {
            $result['list'] = $this->PegawaiModel->getDaftarPegawai();
            $this->load->view('listpegawai', $result);
        } else {
            if ($this->session->userdata('priority') != null) {
                redirect('home');
            } else {
                redirect(base_url());
            }
        }
    }

    public function fetchDataPegawai()
    {
        $output = '';
        $query = '';
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->PegawaiModel->fetch_data($query);
        $output .=
            '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <col width="18%">
            <col width="18%">
            <col width="12%">
            <col width="5%">
            <col width="20%">
            <col width="18%">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>PANGKAT</th>
                    <th>GOLONGAN</th>
                    <th>JABATAN</th>
                    <th>ACTION</th>
                </tr>
            </thead>
        ';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $output .= '
            <tr>
            <td>' . $row->NIP . '</td>
            <td>' . $row->NAMA . '</td>
            <td>' . $row->PANGKAT . '</td>
            <td class="text-center">' . $row->GOLONGAN . '</td>
            <td>' . $row->JABATAN . '</td>
            <td><a href="" data-target="#editPegawai' . $row->NIP . '" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info btn-action"><i class="fas fa-sm fa-edit"></i> Edit </a>
            <a href="" data-target="#hapusPegawai' . $row->NIP . '" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-danger btn-action"><i class="fas fa-sm fa-trash"></i> Hapus </a></td>
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
    public function addPegawai()
    {
        // $this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'required');
        // $this->form_validation->set_rules('nip_pegawai', 'NIP Pegawai', 'required');
        // $this->form_validation->set_rules('bidang', 'Bidang Pegawai', 'required');
        // $this->form_validation->set_rules('pangkat', 'Pangkat Pegawai', 'required');
        // $this->form_validation->set_rules('golongan', 'Golongan Pegawai', 'required');
        // $this->form_validation->set_rules('jabatan_pegawai', 'Jabatan Pegawai', 'required');
        // $this->form_validation->set_rules('tanggal', 'Tanggal Lahir Pegawai', 'required');
        // $this->form_validation->set_rules('tingkat_pegawai', 'Tingkat Pegawai', 'required');
        // $no_flight = $this->input->post('no_flight');
        $nama = $this->input->post('nama_pegawai');
        $nip = $this->input->post('nip_pegawai');
        $bidang = $this->input->post('bidang');
        $pangkat = $this->input->post('pangkat');
        $golongan = $this->input->post('golongan');
        $jabatan = $this->input->post('jabatan_pegawai');
        $tanggallahir = $this->input->post('tanggal');
        $tingkat = $this->input->post('tingkat_pegawai');
        $tempBidang = 0;
        if ($bidang == "SEKRETARIAT") {
            $tempBidang = 2;
        } elseif ($bidang == "MUTASI") {
            $tempBidang = 3;
        } elseif ($bidang == "PKFP") {
            $tempBidang = 4;
        } elseif ($bidang == "PKP") {
            $tempBidang = 5;
        }
        $data_insert = array(
            'NIP' => $nip,
            'ID_BIDANG' => $tempBidang,
            'NAMA' => $nama,
            'PANGKAT' => $pangkat,
            'GOLONGAN' => $golongan,
            'JABATAN' => $jabatan,
            'TANGGALLAHIR' => $tanggallahir,
            'TINGKAT' => $tingkat,
        );
        $this->PegawaiModel->insertPegawai($data_insert);
        $this->session->set_flashdata('tambahPegawai', '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Tambah Pegawai Berhasil!</div>');
        $this->daftarpegawai();
    }
    public function editPegawai()
    {
        $nama = $this->input->post('nama_pegawai');
        $niphidden = $this->input->post('niphidden');
        $nip = $this->input->post('nip_pegawai');
        $bidang = $this->input->post('bidang1');
        $pangkat = $this->input->post('pangkat');
        $golongan = $this->input->post('golongan');
        $jabatan = $this->input->post('jabatan_pegawai');
        $tanggallahir = $this->input->post('tanggal');
        $tingkat = $this->input->post('tingkat_pegawai');
        $data_update = array(
            'NIP' => $nip,
            'ID_BIDANG' => $bidang,
            'NAMA' => $nama,
            'PANGKAT' => $pangkat,
            'GOLONGAN' => $golongan,
            'JABATAN' => $jabatan,
            'TANGGALLAHIR' => $tanggallahir,
            'TINGKAT' => $tingkat,
        );
        $where = array('NIP' => $niphidden);
        $this->UserModel->update($where, 'pegawai', $data_update);
        $this->session->set_flashdata('updatePegawai', '<div class="alert alert-success" role="alert">
        Data Pegawai Berhasil di Update!</div>');
        $this->daftarpegawai();
    }

    public function hapusPegawai($nip)
    {
        $where = array('NIP' => $nip);
        $data = array('AKTIF'=> 0 );
        $this->UserModel->update($where, 'pegawai',$data);
        $this->session->set_flashdata('hapusPegawai', '<div class="alert alert-success" role="alert">
        Pegawai berhasil dihapus </div>');
        $this->daftarpegawai();
    }
}
