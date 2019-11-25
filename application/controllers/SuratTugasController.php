<?php
require("././fpdf/fpdf.php");
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SuratTugasController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('SuratTugasModel');
        $this->load->model('PegawaiModel');
        $this->load->library('form_validation');
    }
    public function listst()
    {
        $user = $this->session->userdata('username');
        $result['list'] = $this->SuratTugasModel->getListST($user);
        $this->load->view('listst', $result);
    }
    public function surattugas()
    {
        $data['data'] = $this->PegawaiModel->getPegawaiAll();
        $this->load->view('surattugas', $data);
    }
    public function insertSurattugas()
    {
        $user = $this->session->userdata('username');
        $idbidang = $this->UserModel->getIdBidang($user);
        $nosurat = $this->input->post('nosurat');
        $dasar = $this->input->post('dasar');
        $tujuan = $this->input->post('untuk');
        $tanggal = $this->input->post('tanggal');
        $pengikut = $this->input->post('pengikut');
        $diperintah = array($this->input->post('diperintah'));
        $id = $this->SuratTugasModel->getIDST()[0]->ID_ST + 1;
        $data_surattugas = array(
            'ID_ST' => $id,
            'ID_BIDANG'=>$idbidang,
            'NOMOR_SURAT'=>$nosurat,
            'DASAR' => $dasar,
            'TUJUAN' => $tujuan,
            'TANGGAL' => date('Y-m-d', strtotime($tanggal)),
        );

        $arr_pengikut = explode(",,", $pengikut);
        foreach ($arr_pengikut as $ap) {
            $diperintah[] = $ap;
        }

        $this->SuratTugasModel->insertSurattugas($data_surattugas, $id);


        $nip_diperintah = $this->PegawaiModel->getNIP($diperintah);
        $sebagai = 'Kepala';
        for ($i = 0; $i < count($nip_diperintah); $i++) {
            if ($i > 0) {
                $sebagai = 'Pengikut';
            }
            $data_diperintah = array(
                'ID_ST' => $id,
                'NIP' => $nip_diperintah[$i][0]->NIP,
                'SEBAGAI' => $sebagai,
            );
            $this->SuratTugasModel->insertPeserta($data_diperintah);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data berhasil dimasukkan </div>');
        redirect('list-st');
    }
    function konversi_nip($nip)
    {
        $nip = trim($nip, " ");
        $panjang = strlen($nip);
        $batas = " ";

        if ($panjang == 18) {
            $sub[] = substr($nip, 0, 8); // tanggal lahir
            $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
            $sub[] = substr($nip, 14, 1); // jenis kelamin
            $sub[] = substr($nip, 3, 3); // nomor urut

            return $sub[0] . $batas . $sub[1] . $batas . $sub[2] . $batas . $sub[3];
        } elseif ($panjang == 15) {
            $sub[] = substr($nip, 0, 8); // tanggal lahir
            $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
            $sub[] = substr($nip, 14, 1); // jenis kelamin

            return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
        } elseif ($panjang == 9) {
            $sub = str_split($nip, 3);

            return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
        } else {
            return $nip;
        }
    }
    function tgl_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
    }
    public function editST()
    {
        $id = $this->input->post('id');
        $nosurat = $this->input->post('nosurat');
        $dasar = $this->input->post('dasar');
        $tujuan = $this->input->post('untuk');
        $tanggal = $this->input->post('tanggal');
        $pengikut = $this->input->post('pengikut');
        $diperintah = array($this->input->post('diperintah'));
        $data_surattugas = array(
            'NOMOR_SURAT'=>$nosurat,
            'DASAR' => $dasar,
            'TUJUAN' => $tujuan,
            'TANGGAL' => date('Y-m-d', strtotime($tanggal)),
        );
        $where = array('ID_ST' => $id);
        $this->UserModel->update($where, 'surattugas', $data_surattugas);
        $pesertalama = $this->SuratTugasModel->getPeserta($id);

        
        if($pengikut != ""){
            $arr_pengikut = explode(",,", $pengikut);
            foreach ($arr_pengikut as $ap) {
            $diperintah[] = $ap;
        }}

        $nip_diperintah = $this->PegawaiModel->getNIP($diperintah);

        //hapus peserta yang dikurangi
        for ($i = 0; $i < count($pesertalama); $i++) { }
        foreach ($pesertalama as $pl) {
            $check_delete = true;
            foreach ($nip_diperintah as $pb) {
                if($pb)
                if ($pl->NIP == $pb[0]->NIP) {
                    $check_delete = false;
                }
            }
            if ($check_delete) {
                $wherePeserta = array('ID_PESERTA' => $pl->ID_PESERTA);
                $this->UserModel->delete($wherePeserta, 'peserta');
            }
        }
        //update dan tambah peserta
        $sebagai = 'Kepala';
        for ($i = 0; $i < count($nip_diperintah); $i++) {
            $check_insert = true;
            if ($i > 0) {
                $sebagai = 'Pengikut';
            }

            foreach ($pesertalama as $pl) {
                if ($pl->NIP == $nip_diperintah[$i][0]->NIP) {
                    $check_insert = false;
                    $wherePeserta = array('ID_PESERTA' => $pl->ID_PESERTA);
                    $dataUpdate = array('SEBAGAI' => $sebagai);
                    $this->UserModel->update($wherePeserta, 'peserta', $dataUpdate);
                }
            }

            if ($check_insert) {
                $data_diperintah = array(
                    'ID_ST' => $id,
                    'NIP' => $nip_diperintah[$i][0]->NIP,
                    'SEBAGAI' => $sebagai,
                );
                $this->SuratTugasModel->insertPeserta($data_diperintah);
            }
        }


        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data berhasil diupdate </div>');
        redirect('list-st');
    }
    public function readST($id)
    {
        //$id=$this->input->get('id');
        $where = array('ID_ST' => $id);
        $data['st'] = $this->UserModel->read($where, 'surattugas');
        $data['all'] = $this->SuratTugasModel->getPeserta();
        $data['peserta'] = $this->SuratTugasModel->getPeserta($id);
        $this->load->view('edit_st', $data);
    }

    public function deleteST($id)
    {
        $where = array('ID_ST' => $id);
        $this->UserModel->delete($where, 'surattugas');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Surat tugas berhasil dihapus </div>');
        $this->listst();
    }
    public function exportST($id)
    {
        $data = $this->SuratTugasModel->getST($id);
        $kepala = $this->PegawaiModel->getPegawai_Jabatan('Kepala');
        $pdf = new FPDF('P', 'mm', array(216, 330));
        $pdf->AddPage();
        $pdf->Image('././assets/img/logoHtmpth.png', 10, 5, 35, 35);

        $this->headerSurat($pdf);

        //isi surat
        $pdf->SetFont('Times', 'BU', '18');
        $pdf->Cell(0, 15, 'SURAT PERINTAH TUGAS', 0, 1, 'C');
        $pdf->SetFont('Times', '', '12');
        $pdf->Cell(0, 5, 'Nomor : '.$data[0]->NOMOR_SURAT, 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->Cell(5);
        $pdf->Cell(30, 7, 'Dasar                : ', 0, 0, 'L');
        $pdf->MultiCell(150, 7, $data[0]->DASAR, 0, 'L', false);
        $pdf->SetFont('Times', 'B', '12');
        $pdf->Cell(0, 20, 'MEMERINTAHKAN:', 0, 1, 'C');
        $pdf->SetFont('Times', '', '12');

        //perulangan pemanggilan peserta
        $i = 0;
        foreach ($data as $value) {
            $i++;
            $pdf->Cell(5);
            $pdf->Cell(30, 7, $i == 1 ? 'Kepada             : ' : '', 0, 0, 'L');
            $pdf->Cell(10, 7, $i . '.', 0, 0, 'L');
            $pdf->Cell(35, 7, 'Nama', 0, 0, 'L');
            $pdf->Cell(0, 7, ':  ' . $value->NAMA, 0, 1, 'L');

            $pdf->Cell(5);
            $pdf->Cell(30, 7, '', 0, 0, 'L');
            $pdf->Cell(10, 7, '', 0, 0, 'L');
            $pdf->Cell(35, 7, 'NIP', 0, 0, 'L');
            $pdf->Cell(0, 7, ':  ' . $this->konversi_nip($value->NIP), 0, 1, 'L');

            $pdf->Cell(5);
            $pdf->Cell(30, 7, '', 0, 0, 'L');
            $pdf->Cell(10, 7, '', 0, 0, 'L');
            $pdf->Cell(35, 7, 'Pangkat/Gol', 0, 0, 'L');
            $pdf->Cell(0, 7, ':  ' . $value->PANGKAT . ' / ' . $value->GOLONGAN, 0, 1, 'L');

            $pdf->Cell(5);
            $pdf->Cell(30, 7, '', 0, 0, 'L');
            $pdf->Cell(10, 7, '', 0, 0, 'L');
            $pdf->Cell(35, 7, 'Jabatan', 0, 0, 'L');
            $pdf->Cell(3, 7, ': ', 0, 0, 'L');
            $pdf->MultiCell(0, 7, $value->JABATAN, 0, 'L', false);
        }

        $pdf->Cell(5);
        $pdf->Cell(30, 7, 'Untuk               : ', 0, 0, 'L');
        $pdf->MultiCell(150, 7, $data[0]->TUJUAN, 0, 'L', false);

        $pdf->Ln(12);

        //baris ttd
        $pdf->Cell(120);
        $pdf->Cell(0, 7, 'Dikeluarkan di Malang', 0, 1, 'L');
        $pdf->Cell(120);
        $pdf->Cell(0, 7, 'Pada tanggal ' . $this->tgl_indo($data[0]->TANGGAL), 0, 1, 'L');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(100);
        $pdf->Cell(0, 10, 'KEPALA BADAN KEPEGAWAIAN DAERAH,', 0, 1, 'C');
        $pdf->Ln(12);
        $pdf->SetFont('Times', 'BU', 12);
        $pdf->Cell(120);
        $pdf->Cell(0, 5, $kepala[0]->NAMA, 0, 1, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(120);
        $pdf->Cell(0, 5, $kepala[0]->PANGKAT, 0, 1, 'L');
        $pdf->Cell(120);
        $pdf->Cell(0, 7, 'NIP. ' . $this->konversi_nip($kepala[0]->NIP), 0, 1, 'L');

        $pdf->Output('ST_' . $data[0]->NAMA . '_' . $data[0]->TANGGAL . '.pdf', 'I');
    }
    public function headerSurat($pdf)
    {
        //header surat
        $pdf->Cell(10);
        $pdf->SetFont('Times', 'B', '16');
        $pdf->Cell(0, 7, 'PEMERINTAH KOTA MALANG', 0, 1, 'C');
        $pdf->Cell(10);
        $pdf->SetFont('Times', 'B', '21');
        $pdf->Cell(0, 7, 'BADAN KEPEGAWAIAN DAERAH', 0, 1, 'C');
        $pdf->Cell(10);
        $pdf->SetFont('Times', 'B', '13');
        $pdf->Cell(0, 7, 'Jalan Tugu No.1 Telp (0341) 328829 - 353837', 0, 1, 'C');
        $pdf->Cell(10);
        $pdf->SetFont('');
        $pdf->Cell(0, 5, 'MALANG', 0, 1, 'C');
        $pdf->Cell(150);
        $pdf->Cell(0, 5, 'Kode Pos 65119', 0, 1, 'C');

        //garis surat
        $pdf->SetLineWidth(1);
        $pdf->Line(15, 43, 200, 43);
        $pdf->SetLineWidth(0);
        $pdf->Line(15, 44, 200, 44);
    }
    public function getPegawaiAll()
    {
        $result = $this->PegawaiModel->getPegawaiAll();

        foreach ($result as $row)
            $arr_result[] = $row->NAMA;
        header('Content-Type: application/json');
        echo json_encode(['suggestions' => $arr_result]);
    }
    // function konversi_nip($nip)
    // {
    //     $nip = trim($nip, " ");
    //     $panjang = strlen($nip);
    //     $batas = " ";

    //     if ($panjang == 18) {
    //         $sub[] = substr($nip, 0, 8); // tanggal lahir
    //         $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
    //         $sub[] = substr($nip, 14, 1); // jenis kelamin
    //         $sub[] = substr($nip, 3, 3); // nomor urut

    //         return $sub[0] . $batas . $sub[1] . $batas . $sub[2] . $batas . $sub[3];
    //     } elseif ($panjang == 15) {
    //         $sub[] = substr($nip, 0, 8); // tanggal lahir
    //         $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
    //         $sub[] = substr($nip, 14, 1); // jenis kelamin

    //         return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
    //     } elseif ($panjang == 9) {
    //         $sub = str_split($nip, 3);

    //         return $sub[0] . $batas . $sub[1] . $batas . $sub[2];
    //     } else {
    //         return $nip;
    //     }
    // }
    // function tgl_indo($tanggal)
    // {
    //     $bulan = array(
    //         1 =>   'Januari',
    //         'Februari',
    //         'Maret',
    //         'April',
    //         'Mei',
    //         'Juni',
    //         'Juli',
    //         'Agustus',
    //         'September',
    //         'Oktober',
    //         'November',
    //         'Desember'
    //     );
    //     $pecahkan = explode('-', $tanggal);

    //     return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
    // }
}
