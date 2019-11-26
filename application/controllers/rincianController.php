<?php
require("././fpdf/fpdf.php");
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RincianController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('RincianModel');
        $this->load->model('SppdModel');
        $this->load->model('PegawaiModel');
        $this->load->library('form_validation');
    }
    function listrincian()
    {
        $user = $this->session->userdata('username');
        $result['list'] = $this->RincianModel->getListRincian($user);
        $this->load->view('listrincian', $result);
    }
    function rincian($id)
    {
        $result['peserta'] = $this->RincianModel->getPesertaRincian($id);
        $result['list'] = $this->RincianModel->getRincian($id);
        $this->load->view('rincian', $result);
    }
    public function tambahTransportasi()
    {
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $no_tiket = $this->input->post('no_tiket');
        $no_flight = $this->input->post('no_flight');
        $no_duduk = $this->input->post('no_duduk');
        $tanggal = $this->input->post('tanggal');
        $pukul = $this->input->post('pukul');
        $harga = $this->input->post('harga');
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');
        $bukti = $this->input->post('bukti');
        $status = $this->input->post('status');
        $keterangan = $this->input->post('keterangan');

        $data = array(
            'ID_SPPD' => $idsppd,
            'ID_PESERTA' => $idpeserta,
            'JENIS' => 'Transportasi',
            'JUMLAH' => 1,
            'HARGA' => $harga,
            'TOTAL' => $harga,
            'KETERANGAN' => $keterangan,
            'NO_TIKET' => $no_tiket,
            'NO_FLIGHT' => $no_flight,
            'JAM' => $pukul,
            'NO_TMPDUDUK' => $no_duduk,
            'TANGGAL' => date('Y-m-d', strtotime($tanggal)),
            'TMP_BERANGKAT' => $asal,
            'TMP_TUJUAN' => $tujuan,
            'STATUS' => $status,
            'BUKTI_PEMBAYARAN' => $bukti,
        );
        $this->UserModel->insertData('rincian', $data);
        $this->session->set_flashdata('transportasi' . $idpeserta, '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data berhasil diupdate </div>');
        redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
    }
    function tambahRincian()
    {
        $this->form_validation->set_rules('jumlah', 'jumlah', 'required');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $jenis = $this->input->post('jenis');
        $jumlah = $this->input->post('jumlah');
        $harga = $this->input->post('harga');
        $bukti = $this->input->post('bukti') ? 1 : 0;
        $total = $jumlah * $harga;
        $keterangan = $this->input->post('keterangan');
        $uhcheck = false;

        $data = array(
            'ID_SPPD' => $idsppd,
            'ID_PESERTA' => $idpeserta,
            'JENIS' => $jenis,
            'JUMLAH' => $jumlah,
            'HARGA' => $harga,
            'TOTAL' => $total,
            'KETERANGAN' => $keterangan,
            'BUKTI_PEMBAYARAN' => $bukti,
        );
        if($jenis == "Uang Harian"){
            $result = $this->RincianModel->getRincian($idsppd);
            foreach ($result as $res) {
                if($res->ID_PESERTA == $idpeserta && $res->JENIS == "Uang Harian"){
                    $uhcheck = true;
                    break;
                }
            }
        }
        if($uhcheck){
            $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-danger" role="alert">
            <b>Gagal! </b>Anda hanya dapat memasukkan satu data Uang Harian pada tiap peserta perjalanan dinas </div>');
            redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
        }else{
            $this->UserModel->insertData('rincian', $data);
            $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-success" role="alert">
            <b>Sukses! </b>Data berhasil diupdate </div>');
            redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
        }
    }

    function editTransportasi()
    {
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $no_tiket = $this->input->post('no_tiket');
        $no_flight = $this->input->post('no_flight');
        $no_duduk = $this->input->post('no_duduk');
        $tanggal = $this->input->post('tanggal');
        $pukul = $this->input->post('pukul');
        $harga = $this->input->post('harga');
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');
        $bukti = $this->input->post('bukti');
        $status = $this->input->post('status');
        $keterangan = $this->input->post('keterangan');

        $data = array(
            'ID_SPPD' => $idsppd,
            'ID_PESERTA' => $idpeserta,
            'JENIS' => 'Transportasi',
            'JUMLAH' => 1,
            'HARGA' => $harga,
            'TOTAL' => $harga,
            'KETERANGAN' => $keterangan,
            'NO_TIKET' => $no_tiket,
            'NO_FLIGHT' => $no_flight,
            'JAM' => $pukul,
            'NO_TMPDUDUK' => $no_duduk,
            'TANGGAL' => date('Y-m-d', strtotime($tanggal)),
            'TMP_BERANGKAT' => $asal,
            'TMP_TUJUAN' => $tujuan,
            'STATUS' => $status,
            'BUKTI_PEMBAYARAN' => $bukti,
        );
        $where = array('ID_RINCIAN' => $idrincian);
        $this->UserModel->update($where, 'rincian', $data);
        $this->session->set_flashdata('transportasi' . $idpeserta, '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data berhasil diupdate </div>');
        redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
    }
    function editRincian()
    {
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $jenis = $this->input->post('jenis');
        $jumlah = $this->input->post('jumlah');
        $harga = $this->input->post('harga');
        $bukti = $this->input->post('bukti');
        $total = $jumlah * $harga;
        $keterangan = $this->input->post('keterangan');
        $uhcheck = false;
        $data = array(
            'ID_SPPD' => $idsppd,
            'ID_PESERTA' => $idpeserta,
            'JENIS' => $jenis,
            'JUMLAH' => $jumlah,
            'HARGA' => $harga,
            'TOTAL' => $total,
            'KETERANGAN' => $keterangan,
            'BUKTI_PEMBAYARAN' => $bukti,
        );
        if($jenis == "Uang Harian"){
            $result = $this->RincianModel->getRincian($idsppd);
            foreach ($result as $res) {
                if($res->ID_PESERTA == $idpeserta && $res->JENIS == "Uang Harian"){
                    $uhcheck = true;
                    break;
                }
            }
        }
        if($uhcheck){
            $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-danger" role="alert">
            <b>Gagal! </b>Anda hanya dapat memasukkan satu data Uang Harian pada tiap peserta perjalanan dinas  </div>');
            redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
        }else{
            $where = array('ID_RINCIAN' => $idrincian);
            $this->UserModel->update($where, 'rincian', $data);
            $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-success" role="alert">
            <b>Sukses! </b>Data berhasil diupdate </div>');
            redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
        }

    }
    function hapusRincian()
    {
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');

        $where = array('ID_RINCIAN' => $idrincian);
        $this->UserModel->delete($where, 'rincian');
        $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data rincian berhasil dihapus </div>');
        redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
    }
    function hapusTransportasi()
    {
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');

        $where = array('ID_RINCIAN' => $idrincian);
        $this->UserModel->delete($where, 'rincian');
        $this->session->set_flashdata('transportasi' . $idpeserta, '<div class="alert alert-success" role="alert">
        <b>Sukses! </b>Data transportasi berhasil dihapus </div>');
        redirect('RincianController/rincian/' . $idsppd . '#peserta' . $idpeserta);
    }

    function exportRincianPeserta($id)
    {
        $data = $this->RincianModel->exportDataRincian($id);
        $bendahara = $this->PegawaiModel->getPegawai_Jabatan('Bendahara');
        $kepala = $this->PegawaiModel->getPegawai_Jabatan('Kepala');
        $sppd = $this->SppdModel->getSPPD($id);

        $reader = IOFactory::createReader('Xls');
        $spreadsheet = $reader->load('template/rincian_temp.xls');
        $currentContentRow = 9;
        $spreadsheet->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('A1', "RINCIAN BIAYA PERJALANAN DINAS " . $sppd[0]->KATEGORI);

        $spreadsheet->getActiveSheet()->setCellValue('A2', $sppd[0]->DASAR);

        //ttd kepala
        $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 32), $kepala[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 33), $kepala[0]->PANGKAT);
        $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 34), 'NIP. ' . $this->konversi_nip($kepala[0]->NIP));

        //ttd bendahara
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow + 16), $bendahara[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow + 17), 'NIP. ' . $this->konversi_nip($bendahara[0]->NIP));
        $clonedWorksheet = clone $spreadsheet->getSheetByName('Sheet1');

        $temp_spreadsheet = new Spreadsheet();
        $temp_spreadsheet->addSheet($clonedWorksheet, 0);

        $count = 1;  // untuk menyimpan nomor pada tiap table rincian
        $cur = 0;  // untuk membedakan baris pertama adalah jenis transportasi jika dirincian ada transportasi
        $pst = ""; // menyimpan kode peserta ditiap pergantian kode peserta
        $n_org = 0; // menyimpan jumlah org ditiap pergantian peserta
        $trp = 0; // sebagai boolean apakah ada jenis transportasi atau tidak
        $i = 0; //  sebagai indeks array-sheet objek
        foreach ($data as $value) {
            $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
            if ($pst != $value->ID_PESERTA) {
                $spreadsheet->getActiveSheet()->removeRow($currentContentRow, 1);
                $pst = $value->ID_PESERTA;
                $n_org++;
                $terbilang = 0;
                if ($n_org == 1) {
                    $spreadsheet->setActiveSheetIndex(0);
                    $spreadsheet->getActiveSheet()->setTitle('rincian ' . $value->NIP);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 16), $value->NAMA);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 17), 'NIP. ' . $this->konversi_nip($value->NIP));
                } else {
                    $arr_sheet[] = clone $temp_spreadsheet->getSheet(0);
                    $currentContentRow = 9;
                    $arr_sheet[$i]->setTitle('rincian ' . $value->NIP);
                    $arr_sheet[$i]->setCellValue('K' . ($currentContentRow + 16), $value->NAMA);
                    $arr_sheet[$i]->setCellValue('K' . ($currentContentRow + 17), 'NIP. ' . $this->konversi_nip($value->NIP));
                    $spreadsheet->addSheet($arr_sheet[$i], $n_org - 1);
                    $spreadsheet->setActiveSheetIndex($n_org - 1);
                    $count = 1;
                    $cur = 0;
                    $trp = 0;
                    $i++;
                }
                $height_row = ceil(strlen($sppd[0]->DASAR) / 95) * 15;
                $spreadsheet->getActiveSheet()->getRowDimension(2)->setRowHeight($height_row);
            }
            if ($value->JENIS == 'Transportasi') {
                if ($cur == 0) {
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $currentContentRow, $count);
                    $count++;
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $currentContentRow, $value->JENIS);
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
                    $currentContentRow++;
                    $cur++;
                    $trp = 1;
                }
                $spreadsheet->getActiveSheet()->setCellValue('B' . $currentContentRow, $value->TMP_BERANGKAT . ' - ' . $value->TMP_TUJUAN);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $currentContentRow, '1');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $currentContentRow, 'org');
                $spreadsheet->getActiveSheet()->setCellValue('F' . $currentContentRow, 'x');
                $spreadsheet->getActiveSheet()->setCellValue('G' . $currentContentRow, $value->JUMLAH);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $currentContentRow, 'kali');
                $spreadsheet->getActiveSheet()->setCellValue('I' . $currentContentRow, 'x');
                $spreadsheet->getActiveSheet()->setCellValue('J' . $currentContentRow, $value->HARGA);
                $spreadsheet->getActiveSheet()->setCellValue('K' . $currentContentRow, '=' . $value->TOTAL);
                if (!$value->NO_TIKET) {
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $currentContentRow, $value->KETERANGAN . ' ' . $value->TMP_BERANGKAT . ' ' . $value->TMP_TUJUAN);
                } else {
                    $spreadsheet->getActiveSheet()->setCellValue('L' . $currentContentRow, $value->KETERANGAN);
                }
                $currentContentRow++;
                $terbilang += $value->TOTAL;
            } else {
                if ($trp == 1) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow, 1);
                    $currentContentRow++;
                }
                $spreadsheet->getActiveSheet()->setCellValue('A' . $currentContentRow, $count);
                $count++;

                if ($value->JENIS == 'Penginapan') {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentContentRow, 'mlm');
                } else if ($value->JENIS == 'Uang Harian' || $value->JENIS == 'Uang Representatif') {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentContentRow, 'hari');
                } else {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentContentRow, 'kali');
                }

                $spreadsheet->getActiveSheet()->setCellValue('B' . $currentContentRow, $value->JENIS);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $currentContentRow, '1');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $currentContentRow, 'org');
                $spreadsheet->getActiveSheet()->setCellValue('F' . $currentContentRow, 'x');
                $spreadsheet->getActiveSheet()->setCellValue('G' . $currentContentRow, $value->JUMLAH);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $currentContentRow, 'x');
                $spreadsheet->getActiveSheet()->setCellValue('J' . $currentContentRow, $value->HARGA);
                $spreadsheet->getActiveSheet()->setCellValue('K' . $currentContentRow, '=' . $value->JUMLAH * $value->HARGA);
                $spreadsheet->getActiveSheet()->setCellValue('L' . $currentContentRow, $value->KETERANGAN);
                $currentContentRow++;
                $terbilang += $value->TOTAL;
            }
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow + 3), 'Terbilang : ' . $this->terbilang($terbilang) . ' rupiah');
        }

        header('Content-Type: application/vnd.openxmlformat-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="rincian.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');
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
    function exportKwitansi($id)
    {
        $data = $this->RincianModel->exportDataRincian($id);
        $bendahara = $this->PegawaiModel->getPegawai_Jabatan('Bendahara');
        $nip_pptk = $this->PegawaiModel->getNiP_PPTK($id);
        $pptk = $this->PegawaiModel->getPegawai_NIP($nip_pptk[0]->NIP_PPTK);
        $sppd = $this->SppdModel->getSPPD($id);
        $total=0;
        $pst = "";
        $count_pst=0;

        $reader = IOFactory::createReader('Xls');

        $spreadsheet = $reader->load('template/kwitansi_temp.xls');

        foreach($data as $value){
            $total += $value->TOTAL;
            if($pst!=$value->ID_PESERTA){
                $count_pst++;
            }
        }

        $terbilang = $this->terbilang($total);

        $spreadsheet->getActiveSheet()->setCellValue('F7',$terbilang);

        $spreadsheet->getActiveSheet()->setCellValue('F10',$sppd[0]->TUJUAN);

        $spreadsheet->getActiveSheet()->setCellValue('E15',$total);
        
        $spreadsheet->getActiveSheet()->setCellValue('I15',$count_pst>1?"untuk diberikan kepada yang berhak":" ");
        
        $spreadsheet->getActiveSheet()->setCellValue('I19',$data[0]->NAMA);

        $spreadsheet->getActiveSheet()->setCellValue('A141',$data[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('A142',$data[0]->PANGKAT);
        $spreadsheet->getActiveSheet()->setCellValue('A143',"NIP. ".$this->konversi_nip($data[0]->NIP));

        $spreadsheet->getActiveSheet()->setCellValue('E141',$pptk[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('E142',$pptk[0]->PANGKAT);
        $spreadsheet->getActiveSheet()->setCellValue('E143',"NIP. ".$this->konversi_nip($pptk[0]->NIP));

        $spreadsheet->getActiveSheet()->setCellValue('I141',$bendahara[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('I142',$bendahara[0]->PANGKAT);
        $spreadsheet->getActiveSheet()->setCellValue('I143',"NIP. ".$this->konversi_nip($bendahara[0]->NIP));




        header('Content-Type: application/vnd.openxmlformat-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="kwitansi.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');

    }

    function exportRincianNominatif($id)
    {
        $data = $this->RincianModel->exportDataRincian($id);
        $bendahara = $this->PegawaiModel->getPegawai_Jabatan('Bendahara');
        $nip_pptk = $this->PegawaiModel->getNiP_PPTK($id);
        $pptk = $this->PegawaiModel->getPegawai_NIP($nip_pptk[0]->NIP_PPTK);
        $sppd = $this->SppdModel->getSPPD($id);

        $reader = IOFactory::createReader('Xlsx');

        $spreadsheet = $reader->load('template/nominatif_temp.xlsx');

        $spreadsheet->getActiveSheet()->setCellValue('A1', "DAFTAR NOMINATIF PERJALANAN DINAS " . $sppd[0]->KATEGORI);
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $height_row = ceil(strlen($sppd[0]->DASAR) / 200) * 12;
        $spreadsheet->getActiveSheet()->getRowDimension(2)->setRowHeight($height_row);

        $spreadsheet->getActiveSheet()->setCellValue('A2', $sppd[0]->DASAR);

        $tanggal_berangkat = explode(' ', $this->tgl_indo($sppd[0]->TGL_BERANGKAT));
        $tanggal_kembali = explode(' ', $this->tgl_indo($sppd[0]->TGL_KEMBALI));
        if ($tanggal_berangkat[1] == $tanggal_kembali[1] && $tanggal_berangkat[0] != $tanggal_kembali[0]) {
            $tanggal_pelaksanaan = 'TANGGAL ' . $tanggal_berangkat[0] . ' s.d. ' . $tanggal_kembali[0] . ' ' . $tanggal_kembali[1] . ' ' . $tanggal_kembali[2];
        } else if ($tanggal_berangkat[1] == $tanggal_kembali[1] && $tanggal_berangkat[0] == $tanggal_kembali[0]) {
            $tanggal_pelaksanaan = 'TANGGAL ' . $this->tgl_indo($sppd[0]->TGL_BERANGKAT);
        } else {
            $tanggal_pelaksanaan = 'TANGGAL ' . $tanggal_berangkat[0] . ' ' . $tanggal_berangkat[1] . ' s.d. ' . $tanggal_kembali[0] . ' ' . $tanggal_kembali[1] . ' ' . $tanggal_kembali[2];
        }

        $spreadsheet->getActiveSheet()->setCellValue('A3', $tanggal_pelaksanaan);

        $currentContentRow = $row_first = $row_last = 9;

        $spreadsheet->getActiveSheet()->setCellValue('K19', $bendahara[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('K20', 'NIP. ' . $this->konversi_nip($bendahara[0]->NIP));

        $spreadsheet->getActiveSheet()->setCellValue('B19', $pptk[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('B20', 'NIP. ' . $this->konversi_nip($pptk[0]->NIP));

        $spreadsheet->getActiveSheet()->setCellValue('F27', $data[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('F28', $data[0]->PANGKAT);
        $spreadsheet->getActiveSheet()->setCellValue('F29', 'NIP. ' . $this->konversi_nip($data[0]->NIP));


        $pst = '';
        $count = 0;
        $row_border = array();
        $nama_lain = '';
        $row_last = 0;
        $spreadsheet->getActiveSheet()->setTitle('Nominatif');

        foreach ($data as $value) {
            if ($pst != $value->ID_PESERTA) {
                $count++;
                if ($count > 1) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 2);
                    $currentContentRow += 2;
                }

                $pst = $value->ID_PESERTA;
                $row_per = $row_first = $currentContentRow;
                $row_lain = $currentContentRow - 1;
                $sum_pergi = $sum_pulang = 0;

                $spreadsheet->getActiveSheet()->setCellValue('A' . $row_per, $count);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row_per, $value->NAMA);

                $spreadsheet->getActiveSheet()->setCellValue('C' . ($row_per - 1), 'A. Berangkat');
                $spreadsheet->getActiveSheet()->setCellValue('K' . ($row_per - 1), 'berangkat');
                $spreadsheet->getActiveSheet()->setCellValue('C' . $row_per, 'Kendaraan ' . $sppd[0]->ALAT_ANGKUT);

                $spreadsheet->getActiveSheet()->setCellValue('D' . $currentContentRow, '-');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $currentContentRow, '-');
                $spreadsheet->getActiveSheet()->setCellValue('F' . $currentContentRow, '-');
                $spreadsheet->getActiveSheet()->setCellValue('G' . $currentContentRow, '-');
                $spreadsheet->getActiveSheet()->setCellValue('K' . $currentContentRow, '0');
                $spreadsheet->getActiveSheet()->setCellValue('M' . $currentContentRow, '0');
                $spreadsheet->getActiveSheet()->setCellValue('P' . $currentContentRow, '0');

                $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
                $currentContentRow++;
                $spreadsheet->getActiveSheet()->setCellValue('C' . $currentContentRow, 'B. Kembali');
                $spreadsheet->getActiveSheet()->setCellValue('K' . $currentContentRow, 'kembali');
                $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
                $currentContentRow++;
                $spreadsheet->getActiveSheet()->setCellValue('C' . ($currentContentRow), 'Kendaraan ' . $sppd[0]->ALAT_ANGKUT);
                $spreadsheet->getActiveSheet()->setCellValue('D' . ($currentContentRow), '-');
                $spreadsheet->getActiveSheet()->setCellValue('E' . ($currentContentRow), '-');
                $spreadsheet->getActiveSheet()->setCellValue('F' . ($currentContentRow), '-');
                $spreadsheet->getActiveSheet()->setCellValue('G' . ($currentContentRow), '-');
                $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow), '0');

                $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
                $currentContentRow++;

                $sum_pergi = $sum_pulang = 0;
                $sum_penginapan = 0;
                $row_border[] = $row_per - 1;
                $nama_lain = '';
            }

            if ($value->STATUS && $value->NO_TIKET) {
                if ($value->STATUS == 'Pergi') {
                    if ($sum_pergi > 0) {
                        $spreadsheet->getActiveSheet()->insertNewRowBefore($row_per + 1);
                        $currentContentRow++;
                        $row_per++;
                    }
                    $sum_pergi++;
                } else {
                    if ($sum_pulang > 0) {
                        $row_per++;
                        $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
                        $currentContentRow++;
                    } else {
                        $row_per += 2;
                    }
                    $sum_pulang++;
                }

                $spreadsheet->getActiveSheet()->setCellValue('D' . $row_per, 'ada');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row_per, $value->NO_TIKET);
                $spreadsheet->getActiveSheet()->setCellValue('F' . $row_per, $value->KETERANGAN);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $row_per, '-');
                $spreadsheet->getActiveSheet()->setCellValue('K' . $row_per, $value->TOTAL);
            } else if ($value->JENIS == 'Uang Harian') {
                $spreadsheet->getActiveSheet()->setCellValue('H' . ($row_first - 1), 'Harian');
                $spreadsheet->getActiveSheet()->setCellValue('H' . $row_first, '1orgx' . $value->JUMLAH . 'hrx' . number_format($value->HARGA, 0, ".", "."));
                $spreadsheet->getActiveSheet()->setCellValue('I' . $row_first, '=');
                $spreadsheet->getActiveSheet()->setCellValue('J' . $row_first, $value->TOTAL);
            } else if ($value->JENIS == 'Uang Representatif') {
                $spreadsheet->getActiveSheet()->setCellValue('H' . ($row_first + 1), 'Representatif');
                $spreadsheet->getActiveSheet()->setCellValue('H' . ($row_first + 2), '1orgx' . $value->JUMLAH . 'hrx' . number_format($value->HARGA, 0, ".", "."));
                $spreadsheet->getActiveSheet()->setCellValue('I' . ($row_first + 2), '=');
                $spreadsheet->getActiveSheet()->setCellValue('J' . ($row_first + 2), $value->TOTAL);
            } else if ($value->JENIS == 'Penginapan') {
                $spreadsheet->getActiveSheet()->setCellValue('N' . ($row_first + $sum_penginapan), $value->JUMLAH . 'mlmx' . number_format($value->HARGA, 0, ".", "."));
                $spreadsheet->getActiveSheet()->setCellValue('O' . ($row_first + $sum_penginapan), '=');
                $spreadsheet->getActiveSheet()->setCellValue('P' . ($row_first + $sum_penginapan), $value->TOTAL);

                $sum_penginapan++;
            } else {
                if ($nama_lain != $value->KETERANGAN) {
                    $row_lain++;
                    $nama_lain = $value->KETERANGAN;
                    $spreadsheet->getActiveSheet()->setCellValue('L' . $row_lain, $nama_lain);
                    $spreadsheet->getActiveSheet()->setCellValue('M' . $row_lain, $value->TOTAL);

                    $total = $value->TOTAL;
                    $row_last = $row_last < $row_lain ? $row_lain : $row_last;
                } else {
                    $total += $value->TOTAL;
                    $spreadsheet->getActiveSheet()->setCellValue('M' . $row_lain, $total);
                }
            }
            $row_last = $currentContentRow;
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($row_first + 1), $value->JABATAN);
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($row_first + 2), 'NIP. ' . $this->konversi_nip($value->NIP));
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($row_first + 3), '');
            $spreadsheet->getActiveSheet()->setCellValue('Q' . $row_first, '=SUM(J' . $row_first . ':J' . $row_last . ')+SUM(K' . $row_first . ':K' . $row_last . ')+SUM(M' . $row_first . ':M' . $row_last . ')+SUM(P' . $row_first . ':P' . $row_last . ')');
        }


        for ($i = 0; $i < $count; $i++) {
            $spreadsheet->getActiveSheet()->getStyle('A' . $row_border[$i] . ':Q' . $row_border[$i])->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            if ($i == $count - 1) {
                $spreadsheet->getActiveSheet()->removeRow($currentContentRow + 1);
            }
        }

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle('Daftar Terima');
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);


        for ($i = 1; $i <= 3; $i++) {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $i . ':G' . $i);
        }

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A1:C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('A1', "DAFTAR TERIMA PERJALANAN DINAS" . $sppd[0]->KATEGORI);

        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
        $height_row = ceil(strlen($sppd[0]->DASAR) / 175) * 12;
        $spreadsheet->getActiveSheet()->getRowDimension(2)->setRowHeight($height_row);


        $spreadsheet->getActiveSheet()->setCellValue('A2', $sppd[0]->DASAR);

        $tanggal_berangkat = explode(' ', $this->tgl_indo($sppd[0]->TGL_BERANGKAT));
        $tanggal_kembali = explode(' ', $this->tgl_indo($sppd[0]->TGL_KEMBALI));
        if ($tanggal_berangkat[1] == $tanggal_kembali[1] && $tanggal_berangkat[0] != $tanggal_kembali[0]) {
            $tanggal_pelaksanaan = 'TANGGAL ' . $tanggal_berangkat[0] . ' s.d. ' . $tanggal_kembali[0] . ' ' . $tanggal_kembali[1] . ' ' . $tanggal_kembali[2];
        } else if ($tanggal_berangkat[1] == $tanggal_kembali[1] && $tanggal_berangkat[0] == $tanggal_kembali[0]) {
            $tanggal_pelaksanaan = 'TANGGAL ' . $this->tgl_indo($sppd[0]->TGL_BERANGKAT);
        } else {
            $tanggal_pelaksanaan = 'TANGGAL ' . $tanggal_berangkat[0] . ' ' . $tanggal_berangkat[1] . ' s.d. ' . $tanggal_kembali[0] . ' ' . $tanggal_kembali[1] . ' ' . $tanggal_kembali[2];
        }

        $spreadsheet->getActiveSheet()->setCellValue('A3', $tanggal_pelaksanaan);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(18);

        $spreadsheet->getActiveSheet()->setCellValue('A5', 'NO.')->mergeCells('A5:A7')->getStyle('A5:A7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('B5', 'NAMA/NIP')->mergeCells('B5:B7')->getStyle('B5:B7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('C5', 'JABATAN/GOLONGAN')->mergeCells('C5:C7')->getStyle('C5:C7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('D5', 'PERINCIAN BIAYA')->mergeCells('D5:E5')->getStyle('D5:E5')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('D6', 'URAIAN')->mergeCells('D6:D7')->getStyle('D6:D7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('E6', 'JUMLAH')->mergeCells('E6:E7')->getStyle('E6:E7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('F5', 'JUMLAH YANG DITERIMA')->mergeCells('F5:F7')->getStyle('F5:F7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->setCellValue('G5', 'TANDA-TANGAN')->mergeCells('G5:G7')->getStyle('G5:G7')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadsheet->getActiveSheet()->getStyle('A5:G7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A5:G7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A6:G10')->getBorders()->getVertical()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('A6:G10')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('D11:G11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('A11:G11')->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A11')->getFont()->setBold(1);
        $spreadsheet->getActiveSheet()->getStyle('A11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('A8:A10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('B8:D10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('G8:G10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('E8:F10')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

        $spreadsheet->getActiveSheet()->setCellValue('B14', 'Pejabat Pelaksana Teknis Kegiatan,')
            ->setCellValue('F13', 'Malang,')
            ->setCellValue('F14', 'Bendahara Pengeluaran,')
            ->setCellValue('D19', 'Mengetahui,')
            ->setCellValue('D20', 'Pengguna Anggaran,')
            ->setCellValue('B18', $pptk[0]->NAMA)
            ->setCellValue('B19', 'NIP. ' . $this->konversi_nip($pptk[0]->NIP))
            ->setCellValue('F18', $bendahara[0]->NAMA)
            ->setCellValue('F19', 'NIP. ' . $this->konversi_nip($bendahara[0]->NIP))
            ->setCellValue('D24', $data[0]->NAMA)
            ->setCellValue('D25', $data[0]->PANGKAT)
            ->setCellValue('D26', 'NIP. ' . $this->konversi_nip($data[0]->NIP));

        $spreadsheet->getActiveSheet()->getStyle('B18:F18')
            ->getFont()
            ->setBold(1)
            ->setUnderline(1);

        $spreadsheet->getActiveSheet()->getStyle('D24')
            ->getFont()
            ->setBold(1)
            ->setUnderline(1);


        $count = 0;
        $pst2 = '';
        $row_first = $currentContentRow2 = 9;
        $uH = false;
        $jumlah_uraian = 0;
        $jenis = '';
        $ket = '';
        $penginapan = $tr = false;
        $row_pg = $currentContentRow2;
        $row_dt = array();
        foreach ($data as $value) {
            if ($pst2 != $value->ID_PESERTA) {
                $uH = false;
                $count++;
                if ($count > 1) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow2 + 1, 3);
                    $currentContentRow2 += 3;
                }
                $pst2 = $value->ID_PESERTA;
                $row_per = $currentContentRow2;
                $row_dt[] = $row_per - 1;
                $total_temp = 0;
                $tr = false;
                $lain = false;
                $penginapan = false;
            }

            if ($jenis != $value->JENIS) {
                $jumlah_uraian++;
            } else {
                if ($ket != $value->KETERANGAN) {
                    $jumlah_uraian++;
                }
            }
            $total_temp = $jenis != $value->JENIS ? 0 : $total_temp;
            $jenis = $jenis != $value->JENIS ? $value->JENIS : $jenis;


            if ($value->JENIS == 'Transportasi' && $value->NO_TIKET) {
                $row = $currentContentRow2;
                $total_temp += $value->TOTAL;
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, 'Transportasi');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $total_temp);
                $tr = true;
                $row_pg = $row + 1;
            } else if ($value->JENIS == 'Uang Harian') {
                if ($tr) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($row_per, 1);
                    $currentContentRow2++;
                }
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row_per, $value->JENIS);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row_per, $value->TOTAL);
                $uH = true;

                if ($jumlah_uraian == 1) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($row_per + 1, 1);
                    $currentContentRow2++;
                }


                $row_pg = $currentContentRow2 - 1;
            } else if ($value->JENIS == 'Uang Representatif') {
                $row = $uH ? ($row_per + 1) : $row_per;
                if ($jumlah_uraian > 1) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($row, 1);
                    $currentContentRow2++;
                }
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $value->JENIS);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $value->TOTAL);
                $row_pg = $currentContentRow2 - 1;
            } else if ($value->JENIS == 'Penginapan') {
                if (!$penginapan) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($row_pg, 1);
                    $currentContentRow2++;
                }
                if ((!$tr && $lain)) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($row_pg + 1, 1);
                    $currentContentRow2++;
                    $row_pg++;
                }

                $total_temp += $value->TOTAL;
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row_pg, $value->JENIS);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row_pg, $total_temp);
                $penginapan = true;
            } else {
                if ($ket != $value->KETERANGAN) {
                    if ($jumlah_uraian > 1) {
                        $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow2 + 1, 1);
                        $currentContentRow2++;
                    }
                    $total_temp = $value->TOTAL;
                } else {
                    $total_temp += $value->TOTAL;
                }

                $spreadsheet->getActiveSheet()->setCellValue('D' . $currentContentRow2, $value->KETERANGAN);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $currentContentRow2, $total_temp);

                $ket = $value->KETERANGAN;
                $lain = true;
            }

            $spreadsheet->getActiveSheet()->setCellValue('A' . $row_per, $count);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $row_per, $value->NAMA)->setCellValue('B' . ($row_per + 1), 'NIP. ' . $this->konversi_nip($value->NIP));
            $spreadsheet->getActiveSheet()->setCellValue('C' . $row_per, $value->PANGKAT . ' (' . $value->GOLONGAN . ')');
            $spreadsheet->getActiveSheet()->setCellValue('F' . $row_per, '=sum(E' . $row_per . ':E' . $currentContentRow2 . ')');
            $spreadsheet->getActiveSheet()->setCellValue('G' . $row_per, $count);

            if ($tr || $lain) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row_per + 1), '')->setCellValue('A' . ($row_per + 2), '')->setCellValue('A' . ($row_per + 3), '');
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row_per + 2), '')->setCellValue('B' . ($row_per + 3), '');
                $spreadsheet->getActiveSheet()->setCellValue('C' . ($row_per + 1), '')->setCellValue('C' . ($row_per + 2), '')->setCellValue('C' . ($row_per + 3), '');
                $spreadsheet->getActiveSheet()->setCellValue('F' . ($row_per + 1), '')->setCellValue('F' . ($row_per + 2), '')->setCellValue('F' . ($row_per + 3), '');
                $spreadsheet->getActiveSheet()->setCellValue('G' . ($row_per + 1), '')->setCellValue('G' . ($row_per + 2), '')->setCellValue('G' . ($row_per + 3), '');
            }
        }

        $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow2 + 2), 'JUMLAH TOTAL:')->mergeCells('A' . ($currentContentRow2 + 2) . ':C' . ($currentContentRow2 + 2))->getStyle('A' . ($currentContentRow2 + 2) . ':C' . ($currentContentRow2 + 2))->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->setCellValue('F' . ($currentContentRow2 + 2), '=sum(E' . $row_first . ':E' . $currentContentRow2 . ')')->getStyle('F' . ($currentContentRow2 + 2))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

        for ($i = 0; $i < count($row_dt); $i++) {
            $spreadsheet->getActiveSheet()->getStyle('A' . $row_dt[$i] . ':G' . $row_dt[$i])->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        $spreadsheet_pernyataan = new Spreadsheet();
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $spreadsheet->getActiveSheet()->setTitle('Pernyataan');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(3);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(13);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(9);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);

        $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'DAFTAR PENGELUARAN RIIL')->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('C4', 'Yang bertanda tangan di bawah ini :');
        $spreadsheet->getActiveSheet()->setCellValue('A6', 'Nama');
        $spreadsheet->getActiveSheet()->setCellValue('C6', ': ' . $data[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('A7', 'NIP');
        $spreadsheet->getActiveSheet()->setCellValue('C7', ': ' . $this->konversi_nip($data[0]->NIP));
        $spreadsheet->getActiveSheet()->setCellValue('A8', 'Jabatan');
        $spreadsheet->getActiveSheet()->setCellValue('C8', ': ' . $data[0]->JABATAN);
        $spreadsheet->getActiveSheet()->setCellValue('A10', 'Berdasarkan Surat Perintah Tugas Nomor: '.$sppd[0]->NOMOR_SURAT.' '. $tanggal_berangkat[2] . ' dengan ini kami menyatakan
        ');
        $spreadsheet->getActiveSheet()->setCellValue('A11', 'dengan sesungguhnya bahwa : ');
        $spreadsheet->getActiveSheet()->setCellValue('A13', '1.');
        $spreadsheet->getActiveSheet()->setCellValue('B13', 'Biaya Transportasi pegawai dan/atau biaya penginapan di bawah ini yang tidak dapat diperoleh')->setCellValue('B14', 'bukti-bukti pengeluarannya, meliputi :');
        $spreadsheet->getActiveSheet()->setCellValue('B16', 'No.')->setCellValue('C16', 'Uraian')->setCellValue('F16', 'Jumlah')->getStyle('B16:F16')->getFont()->setBold(1);
        $spreadsheet->getActiveSheet()->getStyle('B16:F16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->mergeCells('C16:E16');
        $spreadsheet->getActiveSheet()->getStyle('B16:F16')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('B17:B19')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('C17:E19')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('F17:F19')->getBorders()->getOutLine()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('F17:F19')->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
        $spreadsheet->getActiveSheet()->mergeCells('C20:E20');
        $spreadsheet->getActiveSheet()->getStyle('B20:F20')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadsheet->getActiveSheet()->getStyle('C20')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->setCellValue('C20', 'Jumlah');

        $spreadsheet->getActiveSheet()->setCellValue('A22', '2.');
        $spreadsheet->getActiveSheet()->setCellValue('B22', 'Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan ')->setCellValue('B23', 'perjalanan dinas dimaksud dan apabila di kemudian hari terdapat kelebihan atas pembayaran ')->setCellValue('B24', 'kami bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara.');
        $spreadsheet->getActiveSheet()->setCellValue('B27', 'Demikian pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana')->setCellValue('B28', 'mestinya.');

        $spreadsheet->getActiveSheet()->setCellValue('A31', 'Mengetahui/Menyetujui')
            ->setCellValue('A32', 'Pejabat Pelaksana Teknis Kegiatan,')
            ->setCellValue('F31', 'Malang,')
            ->setCellValue('F32', 'Pegawai Negeri yang')
            ->setCellValue('F33', 'melakukan perjalanan dinas,')
            ->setCellValue('A38', $pptk[0]->NAMA)
            ->setCellValue('A39', $pptk[0]->PANGKAT)
            ->setCellValue('A40', 'NIP. ' . $this->konversi_nip($pptk[0]->NIP))
            ->setCellValue('F38', $data[0]->NAMA)
            ->setCellValue('F39', $data[0]->PANGKAT)
            ->setCellValue('F40', 'NIP. ' . $this->konversi_nip($data[0]->NIP))
            ->getStyle('A38:F38')
            ->getFont()
            ->setBold(1)
            ->setUnderline(1);

        $row_per = $currentContentRow3 = 18;
        $count = 0;
        foreach ($data as $value) {
            if (!$value->BUKTI_PEMBAYARAN) {
                $count++;
                $spreadsheet->getActiveSheet()->setCellValue('B' . $currentContentRow3, $count)
                    ->setCellValue('F' . $currentContentRow3, $value->TOTAL);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $currentContentRow3, $value->KETERANGAN . ' ' . $value->TMP_BERANGKAT . ' - ' . $value->TMP_TUJUAN);
                $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow3 + 1, 1);
                $currentContentRow3++;
            }
        }

        $spreadsheet->getActiveSheet()->removeRow($currentContentRow3, 1);
        $currentContentRow3--;

        $spreadsheet->getActiveSheet()->setCellValue('F' . ($currentContentRow3 + 2), '=sum(F' . $row_per . ':F' . $currentContentRow3 . ')')->getStyle('F' . ($currentContentRow3 + 2))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');
        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformat-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="nominatif.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');
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
    public function rekapkeuangan()
    {
        $result['list'] = $this->RincianModel->getTahunRekap();
        $tahun= $this->RincianModel->getMinYear();
        $result['tanggal']=substr($tahun[0]->TANGGAL,0,4);
        $this->load->view('rekapkeuangan', $result);
    }
    function exportRekap($tahun)
    {
        $data = $this->RincianModel->getRekap($tahun);
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load('template/rekaps_temp.xlsx');
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setCellValue('A2', ' Badan Kepegawaian Daerah Kota Malang TA ' . $tahun);
        $spreadsheet->setActiveSheetIndex(2);
        $spreadsheet->getActiveSheet()->setCellValue('A2', ' Badan Kepegawaian Daerah Kota Malang TA ' . $tahun);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

        $count = $count_luar = $count_dalam = 0;
        $pst = '';
        $currentRowL = $currentRowD = 8;
        foreach ($data as $value) {
            if ($pst != $value->ID_PESERTA) {
                $pst = $value->ID_PESERTA;
                $ins = $this->SppdModel->getInstansi($value->ID_SPPD);
                $instansi = "";
                $count_ins = 1;
                foreach($ins as $temp_ins){
                    if($count_ins != 1){
                        $instansi .= ", ";
                    }
                    $instansi .= $temp_ins->INSTANSI;
                    $count_ins++;
                }
                if ($value->KATEGORI == 'Dinas Luar') {
                    $spreadsheet->setActiveSheetIndex(1);
                    $count_luar++;
                    if ($count_luar > 1) {
                        $spreadsheet->getActiveSheet()->insertNewRowBefore($currentRowL + 1, 1);
                        $currentRowL++;
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $currentRowL, $count_luar);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $currentRowL, $value->NAMA);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $currentRowL, $value->NIP);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $currentRowL, $value->DASAR);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $currentRowL, $value->GOLONGAN);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $currentRowL, $value->DAERAH_TUJUAN);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentRowL, $instansi);
                    $tgl_b = $value->TGL_BERANGKAT;
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $currentRowL, substr($tgl_b, 8, 2) . '/' . substr($tgl_b, 5, 2) . '/' . substr($tgl_b, 0, 4));
                    $tgl_k = $value->TGL_KEMBALI;
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $currentRowL, substr($tgl_k, 8, 2) . '/' . substr($tgl_k, 5, 2) . '/' . substr($tgl_k, 0, 4));
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $currentRowL, $value->LAMA);

                    $spreadsheet->getActiveSheet()->setCellValue('S' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('T' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('U' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('V' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('W' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('X' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('Y' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('Z' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AA' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AB' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AC' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AD' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AE' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AF' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AG' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AH' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AI' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AJ' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AK' . $currentRowL, 'null');
                    $spreadsheet->getActiveSheet()->setCellValue('AL' . $currentRowL, 'null');
                    $row = $currentRowL;
                } else {
                    $spreadsheet->setActiveSheetIndex(2);
                    $count_dalam++;
                    if ($count_dalam > 1) {
                        $spreadsheet->getActiveSheet()->insertNewRowBefore($currentRowD + 1, 1);
                        $currentRowD++;
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $currentRowD, $count_dalam);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $currentRowD, $value->NAMA);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $currentRowD, $value->NIP);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $currentRowD, $value->DASAR);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentRowD, $value->GOLONGAN);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $currentRowD, $value->DAERAH_TUJUAN);
                    $tgl_b = $value->TGL_BERANGKAT;
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $currentRowD, substr($tgl_b, 8, 2) . '/' . substr($tgl_b, 5, 2) . '/' . substr($tgl_b, 0, 4));
                    $tgl_k = $value->TGL_KEMBALI;
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $currentRowD, substr($tgl_k, 8, 2) . '/' . substr($tgl_k, 5, 2) . '/' . substr($tgl_k, 0, 4));
                    $spreadsheet->getActiveSheet()->setCellValue('L' . $currentRowD, $instansi);
                    $spreadsheet->getActiveSheet()->setCellValue('M' . $currentRowD, $value->LAMA);
                    $row = $currentRowD;
                }
                $spreadsheet->getActiveSheet()->setCellValue('N' . $row, 'null');
                $spreadsheet->getActiveSheet()->setCellValue('O' . $row, 'null');
                $spreadsheet->getActiveSheet()->setCellValue('P' . $row, 'null');
                $spreadsheet->getActiveSheet()->setCellValue('Q' . $row, 'null');
                $spreadsheet->getActiveSheet()->setCellValue('R' . $row, 'null');


                $transportasi = 0;
                $penginapan = 0;
                $lain2 = 0;
            }

            if ($value->KATEGORI == 'Dinas Luar') {
                if ($value->JENIS == 'Uang Harian') {
                    $spreadsheet->getActiveSheet()->setCellValue('O' . $currentRowL, $value->TOTAL);
                } else if ($value->JENIS == 'Transportasi' && $value->NO_TIKET) {
                    $transportasi += $value->TOTAL;

                    $spreadsheet->getActiveSheet()->setCellValue('P' . $currentRowL, $transportasi);

                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'U' : 'AD') . $currentRowL, $value->KETERANGAN);
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'V' : 'AE') . $currentRowL, $value->NO_TIKET);
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'W' : 'AF') . $currentRowL, $value->NO_FLIGHT);
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'X' : 'AG') . $currentRowL, $value->JAM);
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'Y' : 'AH') . $currentRowL, $value->NO_TMPDUDUK);
                    $tgl = $value->TANGGAL;
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'Z' : 'AI') . $currentRowL, substr($tgl, 8, 2) . '/' . substr($tgl, 5, 2) . '/' . substr($tgl, 0, 4));
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'AA' : 'AJ') . $currentRowL, $value->TMP_BERANGKAT);
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'AB' : 'AK') . $currentRowL, $value->TMP_TUJUAN);
                    $spreadsheet->getActiveSheet()->setCellValue(($value->STATUS == 'Pergi' ? 'AC' : 'AL') . $currentRowL, $value->TOTAL);
                } else if ($value->JENIS == 'Penginapan') {
                    $penginapan += $value->TOTAL;
                    $spreadsheet->getActiveSheet()->setCellValue('Q' . $currentRowL, $penginapan);
                    $spreadsheet->getActiveSheet()->setCellValue('T' . $currentRowL, $value->KETERANGAN);
                } else if ($value->JENIS == 'Uang Representatif') {
                    $spreadsheet->getActiveSheet()->setCellValue('R' . $currentRowL, $value->TOTAL);
                } else {
                    $lain2 += $value->TOTAL;
                    $spreadsheet->getActiveSheet()->setCellValue('S' . $currentRowL, $lain2);
                }

                $spreadsheet->getActiveSheet()->setCellValue('N' . $currentRowL, '=SUM(O' . $currentRowL . ':S' . $currentRowL . ')');
            } else {
                if ($value->JENIS == 'Uang Harian') {
                    $spreadsheet->getActiveSheet()->setCellValue('N' . $currentRowD, $value->HARGA);
                    $spreadsheet->getActiveSheet()->setCellValue('O' . $currentRowD, $value->TOTAL);
                } else if ($value->JENIS == 'Transportasi') {
                    $transportasi += $value->TOTAL;
                    $spreadsheet->getActiveSheet()->setCellValue('P' . $currentRowD, $transportasi);
                } else {
                    $lain2 += $value->TOTAL;
                    $spreadsheet->getActiveSheet()->setCellValue('Q' . $currentRowD, $lain2);
                }

                $spreadsheet->getActiveSheet()->setCellValue('R' . $currentRowD, '=SUM(O' . $currentRowD . ':Q' . $currentRowD . ')');
            }
        }

        header('Content-Type: application/vnd.openxmlformat-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="rekap_perjadin_' . $tahun . '.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');
    }
}