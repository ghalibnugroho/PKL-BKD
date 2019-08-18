<?php
require("././fpdf/fpdf.php");

defined('BASEPATH') or exit('No direct script access allowed');

class sppdController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
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
            <td><a href="#" class="d-none d-sm-inline-block btn btn-sm btn-info"><i class="fas fa-sm fa-edit"></i> Edit </a>
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
    function listrincian(){
        $result['list'] = $this->data_model->getListRincian();
        $this->load->view('listrincian', $result);
    }
    function rincian($id){
        $result['peserta'] = $this->data_model->getPeserta($id);
        $result['list'] = $this->data_model->getRincian($id);
        $this->load->view('rincian',$result);
    }
    public function sppd($id)
    {
        $user = $this->session->userdata('username');
        $result['kegiatan'] = $this->data_model->getKegiatan($user); 
        $result['list'] = $this->data_model->getDataSPPD($id);
        if ($result['list'][0]->KODE != null) {
            $result['list'][0]->KODE = $this->data_model->getNamaKegiatan($result['list'][0]->KODE);
        }
        $this->load->view('sppd',$result);
    }
    public function surattugas()
    {
        $this->load->view('surattugas');
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

    public function getPegawai()
    {
        if (isset($_GET['term'])) {
            $result = $this->data_model->getPegawai($_GET['term']);
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = $row->NAMA;
                echo json_encode($arr_result);
            }
        }
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

    public function addPegawai(){
        
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
        $lama = date_diff(date_create($tgl_kembali),date_create($tgl_berangkat));
        $kode = $this->data_model->getKodeKegiatan($kegiatan);
        $data_insert = array(
            'ID_SPPD' => $id,
            'ALAT_ANGKUT' => $alat_angkut,
            'KODE'=> $kode,
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
        $this->data_model->update($where,'sppd',$data_insert);
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
        $id = $this->data_model->getIDST()[0]->ID_ST+1;
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

        $this->data_model->insertSurattugas($data_surattugas,$id);


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
        $this->data_model->delete($where,'surattugas');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Surat tugas berhasil dihapus </div>');
		$this->listst();
    }

    public function getKota(){
        $data = file_get_contents(base_url('assets/')."json/kota.json");
        echo $data;
    }
    public function tambahTransportasi(){
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
        $this->session->set_flashdata('transportasi'.$idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/'.$idsppd);
    }
    function tambahRincian(){
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $jenis = $this->input->post('jenis');
        $jumlah = $this->input->post('jumlah');
        $harga = $this->input->post('harga');
        $bukti = $this->input->post('bukti');
        $total = $jumlah*$harga;
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
        $this->session->set_flashdata('rincian'.$idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/'.$idsppd);
    }
    function editTransportasi(){
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
        $this->data_model->update($where,'rincian',$data);
        $this->session->set_flashdata('transportasi'.$idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/'.$idsppd);
    }
    function editRincian(){
        $idrincian = $this->input->post('idrincian');
        $idsppd = $this->input->post('idsppd');
        $idpeserta = $this->input->post('idpeserta');
        $jenis = $this->input->post('jenis');
        $jumlah = $this->input->post('jumlah');
        $harga = $this->input->post('harga');
        $bukti = $this->input->post('bukti');
        $total = $jumlah*$harga;
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
        $this->data_model->update($where,'rincian',$data);
        $this->session->set_flashdata('rincian'.$idpeserta, '<div class="alert alert-success" role="alert">
        Data berhasil diupdate </div>');
        redirect('sppdController/rincian/'.$idsppd);
    }

    public function exportST($id)
    {   
        $data = $this->data_model->getST($id);
        $kepala = $this->data_model->getPegawai_Jabatan('Kepala');
        $pdf = new FPDF('P','mm',array(216,330));
        $pdf->AddPage();
        $pdf->Image('././assets/img/logoHtmpth.png',10,5,35,35);

        //header surat
        $pdf->Cell(10);
        $pdf->SetFont('Times','B','16');
        $pdf->Cell(0,7,'PEMERINTAH KOTA MALANG',0,1,'C');
        $pdf->Cell(10);
        $pdf->SetFont('Times','B','21');
        $pdf->Cell(0,7,'BADAN KEPEGAWAIAN DAERAH',0,1,'C');
        $pdf->Cell(10);
        $pdf->SetFont('Times','B','13');
        $pdf->Cell(0,7,'Jalan Tugu No.1 Telp (0341) 328829 - 353837',0,1,'C');
        $pdf->Cell(10);
        $pdf->SetFont('');
        $pdf->Cell(0,5,'MALANG',0,1,'C');
        $pdf->Cell(150);
        $pdf->Cell(0,5,'Kode Pos 65119',0,1,'C');    

        //garis surat
        $pdf->SetLineWidth(1);
        $pdf->Line(15,43,200,43);
        $pdf->SetLineWidth(0);
        $pdf->Line(15,44,200,44);

        //isi surat
        $pdf->SetFont('Times','BU','18');
        $pdf->Cell(0,15,'SURAT PERINTAH TUGAS',0,1,'C');
        $pdf->SetFont('Times','','12');
        $pdf->Cell(0,5,'Nomor : 800/      /35.73.403/2019',0,1,'C');
        $pdf->Ln(10);
        $pdf->Cell(5);
        $pdf->Cell(30,7,'Dasar                : ',0,0,'L');
        $pdf->MultiCell(150,7,$data[0]->DASAR,0,'L',false);
        $pdf->SetFont('Times','B','12');
        $pdf->Cell(0,20,'MEMERINTAHKAN:',0,1,'C');
        $pdf->SetFont('Times','','12');

        //perulangan pemanggilan peserta
        $i=0;
        foreach($data as $value){
            $i++;
            $pdf->Cell(5);
            $pdf->Cell(30,7,$i==1?'Kepada             : ':'',0,0,'L');
            $pdf->Cell(10,7,$i.'.',0,0,'L');
            $pdf->Cell(35,7,'Nama',0,0,'L');
            $pdf->Cell(0,7,':  '.$value->NAMA,0,1,'L');

            $pdf->Cell(5);            
            $pdf->Cell(30,7,'',0,0,'L');
            $pdf->Cell(10,7,'',0,0,'L');
            $pdf->Cell(35,7,'NIP',0,0,'L');
            $pdf->Cell(0,7,':  '.$this->konversi_nip($value->NIP),0,1,'L');

            $pdf->Cell(5);
            $pdf->Cell(30,7,'',0,0,'L');
            $pdf->Cell(10,7,'',0,0,'L');
            $pdf->Cell(35,7,'Pangkat/Gol',0,0,'L');
            $pdf->Cell(0,7,':  '.$value->PANGKAT.' / '.$value->GOLONGAN,0,1,'L');

            $pdf->Cell(5);
            $pdf->Cell(30,7,'',0,0,'L');
            $pdf->Cell(10,7,'',0,0,'L');
            $pdf->Cell(35,7,'Jabatan',0,0,'L');
            $pdf->Cell(0,7,':  '.$value->JABATAN,0,1,'L');
        }

        $pdf->Cell(5);
        $pdf->Cell(30,7,'Untuk               : ',0,0,'L');
        $pdf->MultiCell(150,7,$data[0]->TUJUAN,0,'L',false);  

        $pdf->Ln(12);

        //baris ttd
        $pdf->Cell(120);
        $pdf->Cell(0,7,'Dikeluarkan di Malang',0,1,'L');
        $pdf->Cell(120);
        $pdf->Cell(0,7,'Pada tanggal '.$this->tgl_indo($data[0]->TANGGAL),0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(100);
        $pdf->Cell(0,10,'KEPALA BADAN KEPEGAWAIAN DAERAH,',0,1,'C');
        $pdf->Ln(12);
        $pdf->SetFont('Times','BU',12);
        $pdf->Cell(120);
        $pdf->Cell(0,5,$kepala[0]->NAMA,0,1,'L');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(120);
        $pdf->Cell(0,5,$kepala[0]->PANGKAT,0,1,'L');
        $pdf->Cell(120);
        $pdf->Cell(0,7,'NIP. '.$this->konversi_nip($kepala[0]->NIP),0,1,'L');

        $pdf->Output('ST_'.$data[0]->NAMA.'_'.$data[0]->TANGGAL.'.pdf','I');
    }

    function tgl_indo($tanggal){
        $bulan = array (
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
        
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    function konversi_nip($nip) {
    $nip = trim($nip," ");
    $panjang = strlen($nip);
    $batas = " ";
     
        if($panjang == 18) {
            $sub[] = substr($nip, 0, 8); // tanggal lahir
            $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
            $sub[] = substr($nip, 14, 1); // jenis kelamin
            $sub[] = substr($nip, 3, 3); // nomor urut
             
            return $sub[0].$batas.$sub[1].$batas.$sub[2].$batas.$sub[3];
        } elseif($panjang == 15) {
            $sub[] = substr($nip, 0, 8); // tanggal lahir
            $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
            $sub[] = substr($nip, 14, 1); // jenis kelamin
             
            return $sub[0].$batas.$sub[1].$batas.$sub[2];
        } elseif($panjang == 9) {
            $sub = str_split($nip,3);
             
            return $sub[0].$batas.$sub[1].$batas.$sub[2];
        } else {
            return $nip;
        }
    }


}
