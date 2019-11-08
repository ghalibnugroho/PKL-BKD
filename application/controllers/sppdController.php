<?php
require("././fpdf/fpdf.php");
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class sppdController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SppdModel');
        $this->load->model('UserModel');
        $this->load->model('KegiatanModel');
        $this->load->model('PegawaiModel');
        $this->load->library('form_validation');
    }

    public function listsppd()
    {
        $user = $this->session->userdata('username');
        $result['list'] = $this->SppdModel->getListSPPD($user);
        $this->load->view('listsppd', $result);
    }

    public function sppd($id)
    {
        $user = $this->session->userdata('username');
        $result['kegiatan'] = $this->KegiatanModel->getKegiatan($user);
        $result['list'] = $this->SppdModel->getDataSPPD($id);
        if ($result['list'][0]->KODE != null) {
            $result['list'][0]->KODE = $this->KegiatanModel->getNamaKegiatan($result['list'][0]->KODE);
        }
        $result['instansi']= $this->SppdModel->getInstansi($id);

        $this->load->view('sppd', $result);
    }

    public function getListSPPD()
    {
        $user = $this->session->userdata('username');
        $list = $this->SppdModel->getListSPPD($user);
        foreach ($list->result() as $l) {
            $data_events[] = array(
                "no" => $l->ID_ST,
                "maksud" => $l->DASAR,
                "tanggal" => $l->TANGGAL,
                "nama" => $l->NAMA
            );
        }
        echo json_encode(array("list" => $data_events));
    }
    // public function tgl_indo($tanggal){
    //     $bulan = array (
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
    //     $pecahkan = explode('/', $tanggal);

    //     return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    // }

    function tambahInstansi()
    {
        $idsppd = $this->input->post('idsppd');
        $idst = $this->input->post('idst');
        $instansi = $this->input->post('minstansi');
        $tanggal = $this->input->post('mtanggal');
        $data = array(
            'ID_SPPD' => $idsppd,
            'INSTANSI' => $instansi,
            'TANGGAL' => $tanggal,
        );
        $this->UserModel->insertData('instansitujuan', $data);
        $this->session->set_flashdata('instansi', '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data instansi berhasil ditambah </div>');
        redirect('sppd/' . $idst.'#instansi');
    }

    function hapusInstansi()
    {
        $idinstansi = $this->input->post('idinstansi');
        $idst = $this->input->post('idst');

        $where = array('ID_INSTANSI' => $idinstansi);
        $this->UserModel->delete($where, 'instansitujuan');
        $this->session->set_flashdata('instansi' . $idpeserta, '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data rincian berhasil dihapus </div>');
        redirect('sppdController/sppd/' . $idst.'#instansi');
    }

    public function updateSPPD()
    {
        $id = $this->input->post('id');
        $kegiatan = $this->input->post('kegiatan');
        $maksud = $this->input->post('maksud');
        $alat_angkut = $this->input->post('alat_angkut');
        $tempat_berangkat = $this->input->post('tempat_berangkat');
        $tempat_tujuan = $this->input->post('tempat_tujuan');
        $tgl_berangkat = $this->input->post('tgl_berangkat');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $pengikut = $this->input->post('pengikut');
        $kategori = $this->input->post('kategori');
        $keterangan = $this->input->post('keterangan');
        $lama = date_diff(date_create($tgl_kembali), date_create($tgl_berangkat));
        $kode = $this->KegiatanModel->getKodeKegiatan($kegiatan);
        $data_insert = array(
            'ID_SPPD' => $id,
            'ALAT_ANGKUT' => $alat_angkut,
            'KODE' => $kode,
            'TMP_BERANGKAT' => $tempat_berangkat,
            'TMP_TUJUAN' => $tempat_tujuan,
            'TGL_BERANGKAT' => date('Y-m-d', strtotime($tgl_berangkat)),
            'TGL_KEMBALI' => date('Y-m-d', strtotime($tgl_kembali)),
            'LAMA' => $lama->days,
            'KETERANGAN' => $keterangan,
            'KATEGORI' => $kategori,
        );
        $where = array('ID_SPPD' => $id);
        $this->UserModel->update($where, 'sppd', $data_insert);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data berhasil diupdate </div>');
        $this->listsppd();
    }

    public function getKota()
    {
        $data = file_get_contents(base_url('assets/') . "json/kota.json");
        echo $data;
    }

    public function exportSPPD($id)
    {
        $data = $this->SppdModel->getSPPD($id);
        $kepala = $this->PegawaiModel->getPegawai_Jabatan('Kepala');
        $sekretaris = $this->PegawaiModel->getPegawai_Jabatan('Sekretaris');
        $pdf = new FPDF('P', 'mm', array(216, 330));
        $pdf->AddPage();
        $pdf->Image('././assets/img/logoHtmpth.png', 10, 5, 35, 35);

        $this->headerSurat($pdf);

        //isi surat
        $pdf->Ln(3); //keterangan nomor surat dan lembar ke
        $pdf->Cell(125);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(17, 4, 'Lembar ke', 0, 0, 'L');
        $pdf->Cell(0, 4, ':', 0, 1, 'L');
        $pdf->Cell(125);
        $pdf->Cell(17, 4, 'Kode No.', 0, 0, 'L');
        $pdf->Cell(0, 4, ':', 0, 1, 'L');
        $pdf->Cell(125);
        $pdf->Cell(17, 4, 'Nomor', 0, 0, 'L');
        $pdf->Cell(0, 4, ':', 0, 1, 'L');
        $pdf->Ln(3);

        //judul surat
        $pdf->SetFont('Times', 'BU', 12);
        $pdf->Cell(0, 5, 'SURAT PERINTAH PERJALANAN DINAS', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 4, '(SPPD)', 0, 1, 'C');
        $pdf->Ln(3);

        //mulai tabel
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(10, 8, '1.', 'LTR', 0, 'C'); //baris 1
        $pdf->Cell(80, 8, ' ' . 'Pejabat berwenang yang memberi perintah', 'TR', 0, 'L');
        $pdf->Cell(100, 8, ' ' . 'Kepala Badan Kepegawaian Daerah Kota Malang', 'TR', 1, 'L');

        $pdf->Cell(10, 6, '2.', 'LTR', 0, 'C'); //baris 2
        $pdf->Cell(80, 6, ' ' . 'a. Nama pegawai yang diperintah', 'TR', 0, 'L');
        $pdf->Cell(100, 6, ' a. ' . $data[0]->NAMA, 'TR', 1, 'L');

        $pdf->Cell(10, 6, '', 'LR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'b. N I P', 'R', 0, 'L');
        $pdf->Cell(100, 6, ' b. ' . $this->konversi_nip($data[0]->NIP), 'R', 1, 'L');

        $pdf->Cell(10, 6, '3.', 'LTR', 0, 'C'); //baris 3
        $pdf->Cell(80, 6, ' ' . 'a. Pangkat dan Golongan', 'TR', 0, 'L');
        $pdf->Cell(100, 6, ' a. ' . $data[0]->PANGKAT . ' (' . $data[0]->GOLONGAN . ')', 'TR', 1, 'L');

        $pdf->Cell(10, 6, '', 'LR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'b. Jabatan', 'R', 0, 'L');
        $pdf->Cell(100, 6, ' b. ' . $data[0]->JABATAN, 'R', 1, 'L');

        $pdf->Cell(10, 6, '', 'LR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'c. Tingkat Biaya Perjalanan Dinas', 'R', 0, 'L');
        $pdf->Cell(100, 6, ' c. ' . $data[0]->TINGKAT, 'R', 1, 'L');

        $pdf->Cell(10, 6, '4.', 'LTR', 0, 'C'); //baris 4
        $pdf->Cell(80, 6, ' ' . 'Maksud Perjalanan Dinas', 'TR', 0, 'L');
        $y = $pdf->GetY();

        if (strlen($data[0]->TUJUAN) <= 60) {
            $pdf->Cell(100, 6, ' ' . $data[0]->TUJUAN, 'TR', 1, 'L');
        } else {
            $pdf->Cell(1, 6, '', 'T', 0, 'L');
            $pdf->MultiCell(99, 6, $data[0]->TUJUAN, 'TR', 'L', false);
            $y1 = $pdf->GetY();

            $nrow_4 = (($y1 - $y) / 6) - 1; // nilai 7 adalah dari nilai default height cell, tujuannya untuk membuat baris ke 4 tabelnya wrap text

            $pdf->SetY($y);
            for ($i = 0; $i < $nrow_4; $i++) {
                $pdf->Cell(10, 6, '', 'LR', 0, 'C');
                $pdf->Cell(80, 6, '', 'R', 1, 'L');
                if ($i == $nrow_4 - 1) {
                    $pdf->Cell(10, 6, '', 'LR', 0, 'C');
                    $pdf->Cell(80, 6, '', 'R', 0, 'L');
                    $pdf->Cell(1, 6, '', '', 1, 'L');
                }
            }
        }

        $pdf->Cell(10, 6, '5.', 'LTR', 0, 'C'); //baris 5
        $pdf->Cell(80, 6, ' ' . 'Alat angkut yang dipergunakan', 'TR', 0, 'L');
        $pdf->Cell(100, 6, ' ' . $data[0]->ALAT_ANGKUT, 'TR', 1, 'L');

        $pdf->Cell(10, 6, '6.', 'LTR', 0, 'C'); //baris 6
        $pdf->Cell(80, 6, ' ' . 'a. Tempat berangkat', 'TR', 0, 'L');
        $pdf->Cell(100, 6, ' a. ' . $data[0]->TMP_BERANGKAT, 'TR', 1, 'L');

        $pdf->Cell(10, 6, '', 'LBR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'b. Tempat tujuan', 'BR', 0, 'L');
        $pdf->Cell(100, 6, ' b. ' . $data[0]->TMP_TUJUAN, 'BR', 1, 'L');

        $pdf->Cell(10, 6, '7.', 'LR', 0, 'C'); //baris 7
        $pdf->Cell(80, 6, ' ' . 'a. Lamanya perjalanan dinas', 'R', 0, 'L');
        $pdf->Cell(100, 6, ' a. ' . ($data[0]->LAMA == 0 ? 1 : $data[0]->LAMA) . ' (' . $this->terbilang($data[0]->LAMA == 0 ? 1 : $data[0]->LAMA) . ') hari', 'R', 1, 'L');

        $pdf->Cell(10, 6, '', 'LR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'b. Tanggal berangkat', 'R', 0, 'L');
        $pdf->Cell(100, 6, ' b. ' . $this->tgl_indo($data[0]->TGL_BERANGKAT), 'R', 1, 'L');

        $pdf->Cell(10, 6, '', 'LBR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'c. Tanggal harus kembali/tiba ditempat baru', 'BR', 0, 'L');
        $pdf->Cell(100, 6, ' c. ' . $this->tgl_indo($data[0]->TGL_KEMBALI), 'BR', 1, 'L');

        $pdf->Cell(10, 10, '8.', 'LBR', 0, 'C'); //baris 8
        $pdf->Cell(80, 10, ' Pengikut :            Nama', 'BR', 0, 'L');
        $pdf->Cell(50, 10, ' Tanggal Lahir', 'BR', 0, 'C');
        $pdf->Cell(50, 10, ' Keterangan', 'BR', 1, 'C');

        $count_pengikut = 0;
        foreach ($data as $value) {
            if ($count_pengikut > 0) {
                $border = $count_pengikut == count($data) - 1 ? 'BR' : 'R';
                $pdf->Cell(10, 6, $count_pengikut . '.', 'L' . $border, 0, 'C'); //isi baris 8
                $pdf->Cell(80, 6, ' ' . $value->NAMA, $border, 0, 'L');
                $pdf->Cell(50, 6, $value->TANGGALLAHIR, $border, 0, 'C');
                $pdf->Cell(50, 6, '', $border, 1, 'C');
            }
            $count_pengikut++;
        }

        $pdf->Cell(10, 6, '9.', 'LR', 0, 'C'); //baris 9
        $pdf->Cell(80, 6, ' ' . 'Pembebasan Anggaran  ', 'R', 0, 'L');
        $pdf->Cell(100, 6, '', 'R', 1, 'L');

        $pdf->Cell(10, 6, '', 'LR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'a. SKPD', 'R', 0, 'L');
        $pdf->Cell(100, 6, ' a. Badan Kepegawaian Daerah Kota Malang', 'R', 1, 'L');

        $pdf->Cell(10, 6, '', 'LBR', 0, 'C');
        $pdf->Cell(80, 6, ' ' . 'b. Mata Anggaran', 'BR', 0, 'L');
        $pdf->Cell(100, 6, ' b. ' . $data[0]->KODE, 'BR', 1, 'L');

        $pdf->Cell(10, 8, '10.', 'LBR', 0, 'C'); // baris 10
        $pdf->Cell(80, 8, ' Keterangan lain-lain', 'BR', 0, 'L');
        $pdf->Cell(100, 8, ' ' . '', 'BR', 1, 'L');

        $pdf->Ln(15);

        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(120);
        $pdf->Cell(0, 5, 'Malang', 0, 1, 'L');
        $pdf->Cell(120);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 5, 'An. WALIKOTA MALANG', 0, 1, 'L');
        $pdf->Cell(100);
        $pdf->Cell(0, 5, 'KEPALA BADAN KEPEGAWAIAN DAERAH,', 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->SetFont('Times', 'BU', 10);
        $pdf->Cell(120);
        $pdf->Cell(0, 5, $kepala[0]->NAMA, 0, 1, 'L');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(120);
        $pdf->Cell(0, 4, $kepala[0]->PANGKAT, 0, 1, 'L');
        $pdf->Cell(120);
        $pdf->Cell(0, 5, 'NIP. ' . $this->konversi_nip($kepala[0]->NIP), 0, 1, 'L');

        $pdf->Output('SPPD_' . $data[0]->NAMA . '_' . $data[0]->TGL_BERANGKAT . '.pdf', 'I');
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

    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }
}
