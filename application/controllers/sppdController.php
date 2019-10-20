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
        $this->load->model('data_model');
        $this->load->library('form_validation');
    }
    public function daftarpegawai()
    {
        $result['list'] = $this->data_model->getDaftarPegawai();
        $this->load->view('listpegawai', $result);
    }
    public function fetchDataPegawai()
    {
        $output = '';
        $query = '';
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->data_model->fetch_data($query);
        $output .=
            '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <col width="15%">
            <col width="18%">
            <col width="12%">
            <col width="8%">
            <col width="17%">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>PANGKAT</th>
                    <th>GOLONGAN</th>
                    <th>JABATAN</th>
                    <th>TANGGAL LAHIR</th>
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
            <td>' . $row->GOLONGAN . '</td>
            <td>' . $row->JABATAN . '</td>
            <td>' . $row->TANGGALLAHIR . '</td>
            <td><a href="" data-target="#editPegawai' . $row->NIP . '" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info"><i class="fas fa-sm fa-edit"></i> Edit </a>
            <a href="" data-target="#hapusPegawai' . $row->NIP . '" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-danger"><i class="fas fa-sm fa-trash"></i> Hapus </a></td>
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

    public function listsppd()
    {
        $result['list'] = $this->data_model->getListSPPD();
        $this->load->view('listsppd', $result);
    }
    public function listst()
    {
        $result['list'] = $this->data_model->getListST();
        $this->load->view('listst', $result);
    }
    function listrincian()
    {
        $result['list'] = $this->data_model->getListRincian();
        $this->load->view('listrincian', $result);
    }
    function rincian($id)
    {
        $result['peserta'] = $this->data_model->getPesertaRincian($id);
        $result['list'] = $this->data_model->getRincian($id);
        $this->load->view('rincian', $result);
    }
    public function sppd($id)
    {
        $user = $this->session->userdata('username');
        $result['kegiatan'] = $this->data_model->getKegiatan($user);
        $result['list'] = $this->data_model->getDataSPPD($id);
        if ($result['list'][0]->KODE != null) {
            $result['list'][0]->KODE = $this->data_model->getNamaKegiatan($result['list'][0]->KODE);
        }
        $this->load->view('sppd', $result);
    }
    public function surattugas()
    {
        $data['data'] = $this->data_model->getPegawaiAll();
        $this->load->view('surattugas', $data);
    }
    public function rincianbiaya()
    {
        $this->load->view('rincian');
    }
    public function rekapkeuangan()
    {
        $result['list'] = $this->data_model->getListST();
        $this->load->view('rekapkeuangan', $resuls);
    }

    public function getPegawaiAll()
    {
        $result = $this->data_model->getPegawaiAll();

        foreach ($result as $row)
            $arr_result[] = $row->NAMA;
        header('Content-Type: application/json');
        echo json_encode(['suggestions' => $arr_result]);
    }

    public function getListSPPD()
    {
        $list = $this->data_model->getListSPPD();
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
        $this->data_model->insertPegawai($data_insert);
        $this->session->set_flashdata('tambahPegawai', '<div class="alert alert-success" role="alert">
        Tambah Pegawai Berhasil!</div>');
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
        // $this->db->where('NIP', $niphidden);
        // $this->db->update('pegawai', $data_update);
        $where = array('NIP' => $niphidden);
        $this->data_model->update($where, 'pegawai', $data_update);
        // $where = array('NAMA' => $nama);
        // $nip1 = array('NIP' => $nip);
        // $this->data_model->update($where, 'pegawai', $nip1);
        $this->session->set_flashdata('updatePegawai', '<div class="alert alert-success" role="alert">
        Data Pegawai Berhasil di Update!</div>');
        $this->daftarpegawai();
    }

    public function hapusPegawai($nip)
    {
        $where = array('NIP' => $nip);
        $this->data_model->delete($where, 'pegawai');
        $this->session->set_flashdata('hapusPegawai', '<div class="alert alert-danger" role="alert">
        Pegawai berhasil dihapus </div>');
        $this->daftarpegawai();
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
        $instansi = $this->input->post('instansi');
        $keterangan = $this->input->post('keterangan');
        $lama = date_diff(date_create($tgl_kembali), date_create($tgl_berangkat));
        $kode = $this->data_model->getKodeKegiatan($kegiatan);
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
            'INSTANSI' => $instansi,
        );
        $where = array('ID_SPPD' => $id);
        $this->data_model->update($where, 'sppd', $data_insert);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        $this->listsppd();
    }

    public function insertSurattugas()
    {
        $dasar = $this->input->post('dasar');
        $tujuan = $this->input->post('untuk');
        $tanggal = $this->input->post('tanggal');
        $pengikut = $this->input->post('pengikut');
        $diperintah = array($this->input->post('diperintah'));
        $id = $this->data_model->getIDST()[0]->ID_ST + 1;
        $data_surattugas = array(
            'ID_ST' => $id,
            'DASAR' => $dasar,
            'TUJUAN' => $tujuan,
            'TANGGAL' => date('Y-m-d', strtotime($tanggal)),
        );

        $arr_pengikut = explode(",,", $pengikut);
        foreach ($arr_pengikut as $ap) {
            $diperintah[] = $ap;
        }

        $this->data_model->insertSurattugas($data_surattugas, $id);


        $nip_diperintah = $this->data_model->getNIP($diperintah);
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
            $this->data_model->insertPeserta($data_diperintah);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data berhasil dimasukkan </div>');
        $this->listst();
    }

    public function editST()
    {
        $id = $this->input->post('id');
        $dasar = $this->input->post('dasar');
        $tujuan = $this->input->post('untuk');
        $tanggal = $this->input->post('tanggal');
        $pengikut = $this->input->post('pengikut');
        $diperintah = array($this->input->post('diperintah'));
        $data_surattugas = array(
            'DASAR' => $dasar,
            'TUJUAN' => $tujuan,
            'TANGGAL' => date('Y-m-d', strtotime($tanggal)),
        );
        $where = array('ID_ST' => $id);
        $this->data_model->update($where, 'surattugas', $data_surattugas);
        $this->data_model->delete($where, 'peserta');

        $arr_pengikut = explode(",,", $pengikut);
        foreach ($arr_pengikut as $ap) {
            $diperintah[] = $ap;
        }

        $nip_diperintah = $this->data_model->getNIP($diperintah);
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
            $this->data_model->insertPeserta($data_diperintah);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        $this->listst();
    }
    public function readST($id)
    {
        //$id=$this->input->get('id');
        $where = array('ID_ST' => $id);
        $data['st'] = $this->data_model->read($where, 'surattugas');
        $data['peserta'] = $this->data_model->getPeserta($id);
        $this->load->view('edit_st', $data);
    }

    public function deleteST($id)
    {
        $where = array('ID_ST' => $id);
        $this->data_model->delete($where, 'surattugas');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Surat tugas berhasil dihapus </div>');
        $this->listst();
    }

    public function getKota()
    {
        $data = file_get_contents(base_url('assets/') . "json/kota.json");
        echo $data;
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
        $this->data_model->insertData('rincian', $data);
        $this->session->set_flashdata('transportasi' . $idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/' . $idsppd);
    }
    function tambahRincian()
    {
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $jenis = $this->input->post('jenis');
        $jumlah = $this->input->post('jumlah');
        $harga = $this->input->post('harga');
        $bukti = $this->input->post('bukti');
        $total = $jumlah * $harga;
        $keterangan = $this->input->post('keterangan');

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
        $this->data_model->insertData('rincian', $data);
        $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/' . $idsppd);
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
        $this->data_model->update($where, 'rincian', $data);
        $this->session->set_flashdata('transportasi' . $idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/' . $idsppd);
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
        $where = array('ID_RINCIAN' => $idrincian);
        $this->data_model->update($where, 'rincian', $data);
        $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/' . $idsppd);
    }

    public function exportST($id)
    {
        $data = $this->data_model->getST($id);
        $kepala = $this->data_model->getPegawai_Jabatan('Kepala');
        $pdf = new FPDF('P', 'mm', array(216, 330));
        $pdf->AddPage();
        $pdf->Image('././assets/img/logoHtmpth.png', 10, 5, 35, 35);

        $this->headerSurat($pdf);

        //isi surat
        $pdf->SetFont('Times', 'BU', '18');
        $pdf->Cell(0, 15, 'SURAT PERINTAH TUGAS', 0, 1, 'C');
        $pdf->SetFont('Times', '', '12');
        $pdf->Cell(0, 5, 'Nomor : 800/      /35.73.403/2019', 0, 1, 'C');
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
            $pdf->Cell(0, 7, ':  ' . $value->JABATAN, 0, 1, 'L');
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

    public function exportSPPD($id)
    {
        $data = $this->data_model->getSPPD($id);
        $kepala = $this->data_model->getPegawai_Jabatan('Kepala');
        $sekretaris = $this->data_model->getPegawai_Jabatan('Sekretaris');
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


    function hapusRincian()
    {
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');

        $where = array('ID_RINCIAN' => $idrincian);
        $this->data_model->delete($where, 'rincian');
        $this->session->set_flashdata('rincian' . $idpeserta, '<div class="alert alert-danger" role="alert">
        Data rincian berhasil dihapus </div>');
        redirect('sppdController/rincian/' . $idsppd);
    }
    function hapusTransportasi()
    {
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');

        $where = array('ID_RINCIAN' => $idrincian);
        $this->data_model->delete($where, 'rincian');
        $this->session->set_flashdata('transportasi' . $idpeserta, '<div class="alert alert-danger" role="alert">
        Data transportasi berhasil dihapus </div>');
        redirect('sppdController/rincian/' . $idsppd);
    }

    function exportRincianPeserta($id)
    {
        $data = $this->data_model->exportDataRincian($id);
        $bendahara = $this->data_model->getPegawai_Jabatan('Bendahara');
        $kepala = $this->data_model->getPegawai_Jabatan('Kepala');
        $sppd = $this->data_model->getSPPD($id);

        $reader = IOFactory::createReader('Xls');
        $spreadsheet = $reader->load('template/rincian_temp.xls');
        $currentContentRow = 9;
        $spreadsheet->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('A1', "RINCIAN BIAYA PERJALANAN DINAS " . $sppd[0]->KATEGORI);
        $spreadsheet->getActiveSheet()->setCellValue('A2', $sppd[0]->DASAR);

        //ttd Bendahara
        $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 31), $kepala[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 33), $kepala[0]->NIP);

        //ttd Kepala
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow + 15), $bendahara[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow + 16), $bendahara[0]->NIP);
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
                if ($n_org == 1) {
                    $spreadsheet->setActiveSheetIndex(0);
                    $spreadsheet->getActiveSheet()->setTitle('rincian ' . $value->NIP);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 15), $value->NAMA);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 16), $value->NIP);
                } else {
                    $arr_sheet[] = clone $temp_spreadsheet->getSheet(0);
                    $currentContentRow = 9;
                    $arr_sheet[$i]->setTitle('rincian ' . $value->NIP);
                    $arr_sheet[$i]->setCellValue('K' . ($currentContentRow + 15), $value->NAMA);
                    $arr_sheet[$i]->setCellValue('K' . ($currentContentRow + 16), $value->NIP);
                    $spreadsheet->addSheet($arr_sheet[$i], $n_org - 1);
                    $spreadsheet->setActiveSheetIndex($n_org - 1);
                    $count = 1;
                    $cur = 0;
                    $trp = 0;
                    $i++;
                }
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
                $spreadsheet->getActiveSheet()->setCellValue('K' . $currentContentRow, '=' . $value->JUMLAH * $value->HARGA);
                if (!$value->NO_TIKET) {
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $currentContentRow, $value->KETERANGAN . ' ' . $value->TMP_BERANGKAT . ' ' . $value->TMP_KEMBALI);
                } else {
                    $spreadsheet->getActiveSheet()->setCellValue('L' . $currentContentRow, $value->KETERANGAN);
                }
                $currentContentRow++;
            } else {
                if ($trp == 1) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow, 1);
                    $currentContentRow++;
                }
                $spreadsheet->getActiveSheet()->setCellValue('A' . $currentContentRow, $count);
                $count++;

                if ($value->JENIS == 'Penginapan') {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentContentRow, 'mlm');
                } else {
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $currentContentRow, 'hari');
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
            }
            $spreadsheet->getActiveSheet()->setCellValue('K' . ($currentContentRow + 1), '=SUM(K9:K' . $currentContentRow . ')');
            $terbilang = $spreadsheet->getActiveSheet()->getCell('K' . ($currentContentRow + 1))->getCalculatedValue();
            $spreadsheet->getActiveSheet()->setCellValue('A' . ($currentContentRow + 2), 'Terbilang :' . $this->terbilang($terbilang) . ' rupiah');
        }

        header('Content-Type: application/vnd.openxmlformat-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="rincian.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');
    }

    function exportRincianNominatif($id)
    {
        $data = $this->data_model->exportDataRincian($id);
        $bendahara = $this->data_model->getPegawai_Jabatan('Bendahara');
        $nip_pptk = $this->data_model->getNiP_PPTK($id);
        $pptk = $this->data_model->getPegawai_NIP($nip_pptk[0]->NIP_PPTK);
        $sppd = $this->data_model->getSPPD($id);

        $reader = IOFactory::createReader('Xlsx');

        $spreadsheet = $reader->load('template/nominatif_temp.xlsx');

        $spreadsheet->getActiveSheet()->setCellValue('A1', "DAFTAR NOMINATIF PERJALANAN DINAS" . $sppd[0]->KATEGORI);
        $spreadsheet->getActiveSheet()->setCellValue('A2', $sppd[0]->DASAR);

        $tanggal_berangkat = explode(' ', $this->tgl_indo($sppd[0]->TGL_BERANGKAT));
        $tanggal_kembali = explode(' ', $this->tgl_indo($sppd[0]->TGL_BERANGKAT));
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
        $spreadsheet->getActiveSheet()->setCellValue('K20', $bendahara[0]->NIP);

        $spreadsheet->getActiveSheet()->setCellValue('B19', $pptk[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('B20', $pptk[0]->NIP);

        $spreadsheet->getActiveSheet()->setCellValue('F27', $data[0]->NAMA);
        $spreadsheet->getActiveSheet()->setCellValue('F28', $data[0]->PANGKAT);
        $spreadsheet->getActiveSheet()->setCellValue('F29', $data[0]->NIP);


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
                $spreadsheet->getActiveSheet()->setCellValue('C' . $row_per, 'Kendaraan ' . 'NANI???');

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
                $spreadsheet->getActiveSheet()->setCellValue('C' . ($currentContentRow), 'Kendaraan ' . 'NANI???');
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
            $spreadsheet->getActiveSheet()->setCellValue('B' . ($row_first + 2), $value->NIP);
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

        for ($i = 1; $i <= 3; $i++) {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $i . ':G' . $i);
        }

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A1:C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('A1', "DAFTAR TERIMA PERJALANAN DINAS" . $sppd[0]->KATEGORI);
        $spreadsheet->getActiveSheet()->setCellValue('A2', $sppd[0]->DASAR);

        $tanggal_berangkat = explode(' ', $this->tgl_indo($sppd[0]->TGL_BERANGKAT));
        $tanggal_kembali = explode(' ', $this->tgl_indo($sppd[0]->TGL_BERANGKAT));
        if ($tanggal_berangkat[1] == $tanggal_kembali[1] && $tanggal_berangkat[0] != $tanggal_kembali[0]) {
            $tanggal_pelaksanaan = 'TANGGAL ' . $tanggal_berangkat[0] . ' s.d. ' . $tanggal_kembali[0] . ' ' . $tanggal_kembali[1] . ' ' . $tanggal_kembali[2];
        } else if ($tanggal_berangkat[1] == $tanggal_kembali[1] && $tanggal_berangkat[0] == $tanggal_kembali[0]) {
            $tanggal_pelaksanaan = 'TANGGAL ' . $this->tgl_indo($sppd[0]->TGL_BERANGKAT);
        } else {
            $tanggal_pelaksanaan = 'TANGGAL ' . $tanggal_berangkat[0] . ' ' . $tanggal_berangkat[1] . ' s.d. ' . $tanggal_kembali[0] . ' ' . $tanggal_kembali[1] . ' ' . $tanggal_kembali[2];
        }

        $spreadsheet->getActiveSheet()->setCellValue('A3', $tanggal_pelaksanaan);


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(26);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(21);
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
            ->setCellValue('B19', $pptk[0]->NIP)
            ->setCellValue('F18', $bendahara[0]->NAMA)
            ->setCellValue('F19', $bendahara[0]->NIP)
            ->setCellValue('D24', $data[0]->NAMA)
            ->setCellValue('D25', $data[0]->PANGKAT)
            ->setCellValue('D26', $data[0]->NIP);

        $count = 0;
        $pst2 = '';
        $row_first = $currentContentRow2 = 9;
        $uH = false;
        $jumlah_uraian = 0;
        $jenis = '';
        $ket = '';
        $penginapan = $tr = false;
        $row_pg = 0;
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
                if (!$tr) {
                    $spreadsheet->getActiveSheet()->insertNewRowBefore($row + 1, 1);
                    $currentContentRow2++;
                }
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $value->JENIS);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $value->TOTAL);
                $row_pg = $currentContentRow2 - 1;
            } else if ($value->JENIS == 'Penginapan') {
                if ($row_pg != 0) {
                    if (!$penginapan) {
                        $spreadsheet->getActiveSheet()->insertNewRowBefore($row_pg, 1);
                        $currentContentRow2++;
                    }
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
            $spreadsheet->getActiveSheet()->setCellValue('B' . $row_per, $value->NAMA)->setCellValue('B' . ($row_per + 1), 'NIP. ' . $value->NIP);
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
        $spreadsheet->getActiveSheet()->setCellValue('C7', ': ' . $data[0]->NIP);
        $spreadsheet->getActiveSheet()->setCellValue('A8', 'Jabatan');
        $spreadsheet->getActiveSheet()->setCellValue('C8', ': ' . $data[0]->JABATAN);
        $spreadsheet->getActiveSheet()->setCellValue('A10', 'Berdasarkan Surat Perintah Tugas Nomor: 800/' . '    ' . '/35.73.403/' . $tanggal_berangkat[2] . ' dengan ini kami menyatakan
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
            ->setCellValue('G31', 'Malang,')
            ->setCellValue('G32', 'Pegawai Negeri yang')
            ->setCellValue('G33', 'melakukan perjalanan dinas,')
            ->setCellValue('A38', $pptk[0]->NAMA)
            ->setCellValue('A39', $pptk[0]->PANGKAT)
            ->setCellValue('A40', $pptk[0]->NIP)
            ->setCellValue('G38', $data[0]->NAMA)
            ->setCellValue('G39', $data[0]->PANGKAT)
            ->setCellValue('G40', $data[0]->NIP)
            ->getStyle('A38:G38')
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
}
