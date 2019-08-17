<?php
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
}
