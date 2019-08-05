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
        $result['list'] = $this->data_model->getListSPPD();
        $this->load->view('listsppd',$result);
    }
    public function listst()
    {
        $result['list'] = $this->data_model->getListST();
        $this->load->view('listst',$result);
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

    public function getListSPPD(){
        $list = $this->data_model->getListSPPD();
        foreach($list->result() as $l) {
            $data_events[] = array(
              "no" => $l->ID_ST,
              "maksud" => $l->DASAR,
              "tanggal" => $l->TANGGAL,
              "nama"=>$l->NAMA
            );
        }
        echo json_encode(array("list" => $data_events));
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
                        'ID_SPPD'=>'15',
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

    public function insertSurattugas(){
        $dasar = $this->input->post('dasar');
        $tujuan = $this->input->post('untuk');
        $tanggal = $this->input->post('tanggal');
        $pengikut = $this->input->post('pengikut');
        $diperintah = array($this->input->post('diperintah'));
        $data_surattugas = array(
            'DASAR'=>$dasar,
            'TUJUAN'=>$tujuan,
            'TANGGAL'=>date('Y-m-d',strtotime($tanggal)),
        );

        $arr_pengikut = explode(",,",$pengikut);
        foreach($arr_pengikut as $ap){
            $diperintah[]=$ap;
        }

        $ID_ST = $this->data_model->insertSurattugas($data_surattugas);
        
        
        $nip_diperintah=$this->data_model->getNIP($diperintah);
        $sebagai='Kepala';
        for ($i=0; $i < count($nip_diperintah) ; $i++) { 
            if($i>0){
                $sebagai='Pengikut';
            }
            $data_diperintah= array(
                'ID_ST'=>$ID_ST,
                'NIP'=>$nip_diperintah[$i][0]->NIP,
                'SEBAGAI'=>$sebagai,
            );
            $this->data_model->insertPeserta($data_diperintah);    
        }

        
        // $nip_pengikut = $this->data_model->getNIP($arr_pengikut);
        // print_r($arr_pengikut);
        // echo "nip pengikut";
        // print_r($nip_pengikut);
        // echo implode(" ", $nip_pengikut[0]);
        //echo $nip_pengikut->NIP;
        //echo count($nip_pengikut);
        // for ($i=0; $i < count($arr_pengikut); $i++) {
        //     $nip_pengikut = $this->data_model->getNIP(array($arr_pengikut[$i]));
        //     print_r($nip_pengikut[$i]->NIP);
        //     $data_pengikut = array(
        //         'ID_ST' => $insert_id,
        //         'NIP' => $nip_pengikut[$i]->NIP,
        //         'SEBAGAI' => 'Pengikut',
        //     );
        //     $this->data_model->insertPeserta($data_pengikut);
        // }
        // foreach($nip_pengikut as $np){
        //     $data_pengikut = array(
        //         'ID_ST' => $insert_id,
        //         'NIP' => $nip_pengikut[0][0]->NIP,
        //         'SEBAGAI' => 'Pengikut',
        //     );
        //     $this->data_model->insertPeserta($data_pengikut);
        // }
        // foreach($arr_pengikut as $ap){
        //     $data_pengikut = array(
        //         'ID_ST' => $insert_id,
        //         'NIP' => '198507072010012031',
        //         'SEBAGAI' => $ap,
        //     );
        //     $this->data_model->insertPeserta($data_pengikut);
        // }
        
        $this->listst();
    }

    public function editST(){
        $id = $this->input->post('id');
        $dasar = $this->input->post('dasar');
        $tujuan = $this->input->post('untuk');
        $tanggal = $this->input->post('tanggal');
        $pengikut = $this->input->post('pengikut');
        $diperintah = array($this->input->post('diperintah'));
        $data_surattugas = array(
            'DASAR'=>$dasar,
            'TUJUAN'=>$tujuan,
            'TANGGAL'=>date('Y-m-d',strtotime($tanggal)),
        );
        $where = array('ID_ST' => $id);
        $this->data_model->update($where,'surattugas',$data_surattugas);
        $this->data_model->delete($where, 'peserta');
        
        $arr_pengikut = explode(",,",$pengikut);
        foreach($arr_pengikut as $ap){
            $diperintah[]=$ap;
        }

        $nip_diperintah=$this->data_model->getNIP($diperintah);
        $sebagai='Kepala';
        for ($i=0; $i < count($nip_diperintah) ; $i++) { 
            if($i>0){
                $sebagai='Pengikut';
            }
            $data_diperintah= array(
                'ID_ST'=>$id,
                'NIP'=>$nip_diperintah[$i][0]->NIP,
                'SEBAGAI'=>$sebagai,
            );
            $this->data_model->insertPeserta($data_diperintah);    
        }
        $this->listst();
    }
    public function readST($id){
        //$id=$this->input->get('id');
        $where = array('ID_ST' => $id);
        $data['st'] = $this->data_model->read($where,'surattugas');
        $data['peserta'] = $this->data_model->getPeserta($id);
		$this->load->view('edit_st',$data);
    }

}
