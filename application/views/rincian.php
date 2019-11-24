<?php
require_once 'templates/session.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php $this->load->view("templates/auth_header")?>
<body id="page-top">
  <div id="wrapper">
    <?php $this->load->view("templates/auth_sidebar")?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php $this->load->view("templates/auth_topbar")?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- DataTales Peserta -->
          <?php foreach ($peserta as $p) {
            
          ?>
          <div class="card shadow mb-4" id="peserta<?php echo $p->ID_PESERTA ?>">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo $p->NAMA?></h6>
                </div>
                <div class="card-body">
                    <!-- Transportasi Card -->
                    <?=$this->session->flashdata('transportasi'.$p->ID_PESERTA);?>
                    <div class="card mb-4">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                        Transportasi
                            <a href="" data-target="#transportasi<?php echo $p->ID_PESERTA?>" data-toggle="modal" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                <i class="fas fa-sm fa-plus"></i>
                                </span>
                                <span class="text">Tambah Transportasi</span>
                            </a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <col width="10%">
                            <col width="20%">
                            <col width="20%">
                            <col width="10%">
                            <col width="20%">
                            <col width="20%">
                            <thead>
                                <tr>
                                <th>No Tiket</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Pukul</th>
                                <th>Tanggal</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php $count = 0;
                              foreach ($list as $li) {
                                if (($li->JENIS == 'Transportasi')&& ($li->ID_PESERTA == $p->ID_PESERTA) && ($li->NO_TIKET)) {
                                  echo "                                
                                  <tr>
                                  <td>".$li->NO_TIKET."</td>
                                  <td>".$li->TMP_BERANGKAT."</td>
                                  <td>".$li->TMP_TUJUAN."</td>
                                  <td>".$li->JAM."</td>
                                  <td>".$li->TANGGAL."</td>";
                                  ?>
                                  <td>
                                    <a href="" data-target="#editTransportasi<?php echo $li->ID_RINCIAN?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info"><i class="fas fa-sm fa-edit"></i> Edit</a>
                                    <a href="" data-target="#hapus<?php echo $li->ID_RINCIAN?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-danger"><i class="fas fa-sm fa-trash"></i> Hapus</a>
                                  </td>
                                  </tr>
                                  <?php
                                }else{
                                  $count++;
                                }
                              }
                              if($count == count($list)){
                                echo " <tr><td colspan=\"6\"><div align =\"center\">Tidak ada data</div></td></tr>";
                              }
                              ?>

                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- Rincian Card -->
                    <?=$this->session->flashdata('rincian'.$p->ID_PESERTA);?>
                    <div class="card mb-4">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                        Rincian
                            <a href="" data-target="#rincian<?php echo $p->ID_PESERTA?>" data-toggle="modal" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                <i class="fas fa-sm fa-plus"></i>
                                </span>
                                <span class="text">Tambah Rincian</span>
                            </a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <col width="20%">
                            <col width="10%">
                            <col width="15%">
                            <col width="10%">
                            <col width="25%">
                            <col width="20%">
                            <thead>
                                <tr>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Kwitansi</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $count2=0;
                                foreach ($list as $li) {
                                  if ((!$li->NO_TIKET) && ($li->ID_PESERTA == $p->ID_PESERTA)) {
                                    $bukti = $li->BUKTI_PEMBAYARAN ? "Ada":"Tidak ada";
                                    echo "
                                    <tr>
                                      <td>".$li->JENIS."</td>
                                      <td>".$li->JUMLAH."</td>
                                      <td>".$li->HARGA."</td>
                                      <td>".$bukti."</td>
                                      <td>".$li->KETERANGAN."</td>";
                                      ?>
                                      <td>
                                    <a href="" data-target="#editRincian<?php echo $li->ID_RINCIAN?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info"><i class="fas fa-sm fa-edit"></i> Edit</a>
                                    <a href="" data-target="#hapus<?php echo $li->ID_RINCIAN?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-danger"><i class="fas fa-sm fa-trash"></i> Hapus</a>
                                  </td>
                                  </tr>
                                 
                                  <?php
                                  }else{
                                    $count2++;
                                  }
                                }
                                if($count2 == count($list)){
                                  echo " <tr><td colspan=\"6\"><div align =\"center\">Tidak ada data</div></td></tr>";
                                }
                              ?>
                                
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
          </div>
          <div class="card "></div>
          <?php } ?>

        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
      <?php $this->load->view("templates/auth_footer")?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">

          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?=base_url('auth/logout');?>">Logout</a>
        </div>
      </div>
    </div>
  </div>



</body>
  <?php 
    foreach ($peserta as $p) {
      ?>
      <!-- Transportasi Modal-->
      <div class="modal fade " id="transportasi<?php echo $p->ID_PESERTA?>" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-body">
            <div class="tab-pane active" id="tab_1">  
                      <form method="POST" role="form" action="<?php echo site_url('RincianController/tambahTransportasi');?>">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-8">
                          <input type="hidden" name="idsppd" value="<?php echo $p->ID_SPPD; ?>">
                          <input type="hidden" name="idpeserta" value="<?php echo $p->ID_PESERTA; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-8">
                            <label>Nomor Penerbangan</label>
                            <input type="text" name="no_flight" class=" form-control sc-input-required" placeholder="">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6">
                            <label>Nomor Tiket</label>
                            <input type="text" name="no_tiket" class=" form-control sc-input-required" placeholder="">
                          </div>
                          <div class="col-sm-6">
                            <label>Nomor Tempat Duduk</label>
                            <input type="text" name="no_duduk" class=" form-control sc-input-required" placeholder="">
                          </div>
                        </div>
                      </div>
                      <div class="form-group input-group">
                        <div class="row">
                          <div class="col-sm-5">
                            <label>Tanggal</label>
                            <input type="text" name="tanggal" class="input-tanggal form-control sc-input-required">
                          </div>
                          <div class="col-sm-5">
                            <label>Pukul</label>
                            <input type="time" name="pukul" class="form-control sc-input-required" placeholder="">
                          </div>
                        </div>
                      </div>
                      <div class="form-group input-group">
                        <div class="row">
                          <div class="col-sm-12">
                            <label>Harga</label>
                            <input type="number" min="1" step="any" name="harga" class="form-control sc-input-required" placeholder="Rp.">
                          </div>
                        </div>
                      </div>
                      <div class="form-group input-group">
                        <div class="row">
                          <div class="col-sm-6">
                            <label>Asal</label>
                            <input type="text" id="asal" name="asal" class="asal form-control sc-input-required">
                            <div id="show"></div>
                          </div>
                          <div class="col-sm-6">
                            <label>Tujuan</label>
                            <input type="text" id="tujuan" name="tujuan" class="tujuan form-control sc-input-required">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6">
                            <input type="checkbox" name="bukti" class="sc-input-required" value="1">
                            <label>Bukti Pembayaran</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group input-group">
                        <div class="row">
                          <div class="col-sm-12">
                            <label>Status</label>
                            <select name="status" class="form-control sc-input-required">
                              <option> Pergi </option>
                              <option> Pulang </option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Keterangan &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Simpan" class="btn btn-primary">
                      </div>
                      </form>
                    </div>
              </button>
            </div>
          </div>
        </div>
      </div>

          <!-- Rincian Modal-->
      <div class="modal fade " id="rincian<?php echo $p->ID_PESERTA?>" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
            <div class="tab-pane active" id="tab_1">  
                      <form method="POST" role="form" action="<?php echo site_url('RincianController/tambahRincian');?>">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-8">
                          <input type="hidden" name="idsppd" value="<?php echo $p->ID_SPPD; ?>">
                          <input type="hidden" name="idpeserta" value="<?php echo $p->ID_PESERTA; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-8">
                            <label>Jenis</label>
                            <select class="form-control sc-input-required" name="jenis">
                              <option> -- </option>
                              <option>Uang Harian</option>
                              <option>Uang Representatif</option>
                              <option>Penginapan</option>
                              <option>Transportasi</option>
                              <option>Lain-lain</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group input-group">
                        <div class="row">
                          <div class="col-sm-5">
                            <label>Jumlah</label>
                            <input type="number" min="1" max ="99" required step="any" name="jumlah" class=" form-control sc-input-required" placeholder="0">
                          </div>
                          <div class="col-sm-5">
                            <label>Harga per item</label>  
                            <span class="input-group-addon">
                            </span>
                            <input type="number" min="1" step="any" required name="harga" class="form-control sc-input-required" placeholder="Rp.">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="checkbox" name="bukti" class="checkbox" value=1>
                        <label>Bukti Pembayaran</label>
                        
                      </div>
                      <div class="form-group">
                        <label>Keterangan &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Simpan" class="btn btn-primary">
                      </div>
                      </form>
                    </div>
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <?php
    }
  ?>
  <?php
    foreach ($list as $li) {
      if ($li->NO_TIKET!=NULL) {
          ?>
        <!-- Edit Transportasi Modal-->
        <div class="modal fade " id="editTransportasi<?php echo $li->ID_RINCIAN?>" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-body">
              <div class="tab-pane active" id="tab_1">  
                        <form method="POST" role="form" action="<?php echo site_url('RincianController/editTransportasi');?>">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-8">
                            <input type="hidden" name="idrincian" value="<?php echo $li->ID_RINCIAN; ?>">
                            <input type="hidden" name="idsppd" value="<?php echo $li->ID_SPPD; ?>">
                            <input type="hidden" name="idpeserta" value="<?php echo $li->ID_PESERTA; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-8">
                              <label>Nomor Penerbangan</label>
                              <input type="text" name="no_flight" class=" form-control sc-input-required" value="<?php echo $li->NO_FLIGHT;?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-6">
                              <label>Nomor Tiket</label>
                              <input type="text" name="no_tiket" class=" form-control sc-input-required" value="<?php echo $li->NO_TIKET; ?>">
                            </div>
                            <div class="col-sm-6">
                              <label>Nomor Tempat Duduk</label>
                              <input type="text" name="no_duduk" class=" form-control sc-input-required" placeholder="" value="<?php echo $li->NO_TMPDUDUK; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group input-group">
                          <div class="row">
                            <div class="col-sm-5">
                              <label>Tanggal</label>
                              <input type="text" name="tanggal" class="input-tanggal form-control sc-input-required" value="<?php echo $li->TANGGAL; ?>">
                            </div>
                            <div class="col-sm-5">
                              <label>Pukul</label>
                              <input type="time" name="pukul" class="form-control sc-input-required" placeholder="" value="<?php echo $li->JAM; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group input-group">
                          <div class="row">
                            <div class="col-sm-12">
                              <label>Harga</label>
                              <input type="number" min="1" step="any" name="harga" class="form-control sc-input-required" placeholder="Rp." value="<?php echo $li->HARGA; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group input-group">
                          <div class="row">
                            <div class="col-sm-6">
                              <label>Asal</label>
                              <input type="text" id="asal" name="asal" class="asal form-control sc-input-required" value="<?php echo $li->TMP_BERANGKAT; ?>">
                              <div id="show"></div>
                            </div>
                            <div class="col-sm-6">
                              <label>Tujuan</label>
                              <input type="text" id="tujuan" name="tujuan" class="tujuan form-control sc-input-required" value="<?php echo $li->TMP_TUJUAN; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-6">
                              <input type="checkbox" name="bukti" class="sc-input-required" value="1"<?php echo ($li->BUKTI_PEMBAYARAN == 1) ? 'checked' : '' ;?>>
                              <label>Bukti Pembayaran</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group input-group">
                          <div class="row">
                            <div class="col-sm-12">
                              <label>Status</label>
                              <select name="status" class="form-control sc-input-required" value="<?php echo $li->STATUS; ?>">
                                <option <?php echo $li->STATUS=="Pergi"?"selected":"" ?>> Pergi </option>
                                <option <?php echo $li->STATUS=="Pulang"?"selected":"" ?>> Pulang </option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Keterangan &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                          <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" value="<?php echo $li->KETERANGAN; ?>">
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                          <input type="submit" value="Simpan" class="btn btn-primary">
                        </div>
                        </form>
                      </div>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Hapus Transportasi Modal-->
        <div class="modal fade" id="hapus<?php echo $li->ID_RINCIAN;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data transportasi?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">Anda akan menghapus transportasi dengan nomor tiket <?php echo $li->NO_TIKET;?>.</div>
              <div class="modal-footer">
              <form method="post" action="<?php echo site_url('RincianController/hapusTransportasi');?>">
                  <input type="hidden" name="idrincian" value="<?php echo $li->ID_RINCIAN; ?>">
                  <input type="hidden" name="idsppd" value="<?php echo $li->ID_SPPD; ?>">
                  <input type="hidden" name="idpeserta" value="<?php echo $li->ID_PESERTA; ?>">
                  
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                  <input type="submit" value="Hapus" class="btn btn-danger">
                </form>
              </div>
            </div>
          </div>
        </div> 
        <?php
      } else {
        ?>
        <!-- Edit Rincian Modal-->
        <div class="modal fade " id="editRincian<?php echo $li->ID_RINCIAN?>" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
              <div class="tab-pane active" id="tab_1">  
                        <form method="POST" role="form" action="<?php echo site_url('RincianController/editRincian');?>">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-8">
                            <input type="hidden" name="idrincian" value="<?php echo $li->ID_RINCIAN; ?>">
                            <input type="hidden" name="idsppd" value="<?php echo $li->ID_SPPD; ?>">
                            <input type="hidden" name="idpeserta" value="<?php echo $li->ID_PESERTA; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-5">
                              <label>Jenis</label>
                              <select class="form-control sc-input-required" name="jenis">
                                <option <?php echo $li->JENIS=='Uang Harian'?'selected':'';?> >Uang Harian</option>
                                <option <?php echo $li->JENIS=='Uang Representatif'?'selected':'';?>>Uang Representatif</option>
                                <option <?php echo $li->JENIS=='Penginapan'?'selected':'';?>>Penginapan</option>
                                <option <?php echo $li->JENIS=='Transportasi'?'selected':'';?>>Transportasi</option>
                                <option <?php echo $li->JENIS=='Lainlain'?'selected':'';?>>Lain-lain</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group input-group">
                          <div class="row">
                            <div class="col-sm-5">
                              <label>Jumlah</label>
                              <input type="number" id="jumlah" min="1" max ="99" step="any" name="jumlah" class=" form-control sc-input-required" placeholder="0" value="<?php echo $li->JUMLAH;?>">
                            </div>
                            <div class="col-sm-5">
                              <label>Harga per item</label>  
                              <span class="input-group-addon">
                              </span>
                              <input type="number" min="1" id="harga" step="any" name="harga" class="form-control sc-input-required" placeholder="Rp." value="<?php echo $li->HARGA;?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <input type="checkbox" name="bukti" id="bukti" class="checkbox" value="1"<?php echo $retVal = ($li->BUKTI_PEMBAYARAN == 1) ? 'checked' : '' ;?>>
                          <label>Bukti Pembayaran</label>
                          
                        </div>
                        <div class="form-group">
                          <label>Keterangan &nbsp;&nbsp;<small id="keterangan" style="opacity:.7"><i>(optional - nama hotel, bbm, tol, dll)</i></small></label>
                          <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" value="<?php echo $li->KETERANGAN?>">
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" id="cancel" type="button" data-dismiss="modal">Cancel</button>
                          <input type="submit" value="Simpan" class="btn btn-primary">
                        </div>  
                        </form>
                      </div>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Hapus Rincian Modal--> 
        <div class="modal fade" id="hapus<?php echo $li->ID_RINCIAN;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus rincian?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">Anda akan menghapus data rincian <?php echo $li->JENIS?>.</div>
              <div class="modal-footer">
                <form method="post" action="<?php echo site_url('RincianController/hapusRincian');?>">
                  <input type="hidden" name="idrincian" value="<?php echo $li->ID_RINCIAN; ?>">
                  <input type="hidden" name="idsppd" value="<?php echo $li->ID_SPPD; ?>">
                  <input type="hidden" name="idpeserta" value="<?php echo $li->ID_PESERTA; ?>">

                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                  <input type="submit" value="Hapus" class="btn btn-danger">
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
    
      }
    }
  ?>
<script>
    $(document).ready(
    function() {
      $(function() {
        $(".input-tanggal").datepicker({
          showButtonPanel: true,
          //minDate: new Date(),
          showTime: true
        });
      });
    });
  var src = ["Kab. Simeulue","Kab. Aceh Singkil","Kab. Aceh Selatan","Kab. Aceh Tenggara","Kab. Aceh Timur","Kab. Aceh Tengah","Kab. Aceh Barat","Kab. Aceh Besar","Kab. Pidie","Kab. Bireuen","Kab. Aceh Utara","Kab. Aceh Barat Daya","Kab. Gayo Lues","Kab. Aceh Tamiang","Kab. Nagan Raya","Kab. Aceh Jaya","Kab. Bener Meriah","Kab. Pidie Jaya","Kota Banda Aceh","Kota Sabang","Kota Langsa","Kota Lhokseumawe","Kota Subulussalam","Kab. Nias","Kab. Mandailing Natal","Kab. Tapanuli Selatan","Kab. Tapanuli Tengah","Kab. Tapanuli Utara","Kab. Toba Samosir","Kab. Labuhan Batu","Kab. Asahan","Kab. Simalungun","Kab. Dairi","Kab. Karo","Kab. Deli Serdang","Kab. Langkat","Kab. Nias Selatan","Kab. Humbang Hasundutan","Kab. Pakpak Bharat","Kab. Samosir","Kab. Serdang Bedagai","Kab. Batu Bara","Kab. Padang Lawas Utara","Kab. Padang Lawas","Kab. Labuhan Batu Selatan","Kab. Labuhan Batu Utara","Kab. Nias Utara","Kab. Nias Barat","Kota Sibolga","Kota Tanjung Balai","Kota Pematang Siantar","Kota Tebing Tinggi","Kota Medan","Kota Binjai","Kota Padangsidimpuan","Kota Gunungsitoli","Kab. Kepulauan Mentawai","Kab. Pesisir Selatan","Kab. Solok","Kab. Sijunjung","Kab. Tanah Datar","Kab. Padang Pariaman","Kab. Agam","Kab. Lima Puluh Kota","Kab. Pasaman","Kab. Solok Selatan","Kab. Dharmasraya","Kab. Pasaman Barat","Kota Padang","Kota Solok","Kota Sawah Lunto","Kota Padang Panjang","Kota Bukittinggi","Kota Payakumbuh","Kota Pariaman","Kab. Kuantan Singingi","Kab. Indragiri Hulu","Kab. Indragiri Hilir","Kab. Pelalawan","Kab. S I A K","Kab. Kampar","Kab. Rokan Hulu","Kab. Bengkalis","Kab. Rokan Hilir","Kab. Kepulauan Meranti","Kota Pekanbaru","Kota D U M A I","Kab. Kerinci","Kab. Merangin","Kab. Sarolangun","Kab. Batang Hari","Kab. Muaro Jambi","Kab. Tanjung Jabung Timur","Kab. Tanjung Jabung Barat","Kab. Tebo","Kab. Bungo","Kota Jambi","Kota Sungai Penuh","Kab. Ogan Komering Ulu","Kab. Ogan Komering Ilir","Kab. Muara Enim","Kab. Lahat","Kab. Musi Rawas","Kab. Musi Banyuasin","Kab. Banyu Asin","Kab. Ogan Komering Ulu Selatan","Kab. Ogan Komering Ulu Timur","Kab. Ogan Ilir","Kab. Empat Lawang","Kota Palembang","Kota Prabumulih","Kota Pagar Alam","Kota Lubuklinggau","Kab. Bengkulu Selatan","Kab. Rejang Lebong","Kab. Bengkulu Utara","Kab. Kaur","Kab. Seluma","Kab. Mukomuko","Kab. Lebong","Kab. Kepahiang","Kab. Bengkulu Tengah","Kota Bengkulu","Kab. Lampung Barat","Kab. Tanggamus","Kab. Lampung Selatan","Kab. Lampung Timur","Kab. Lampung Tengah","Kab. Lampung Utara","Kab. Way Kanan","Kab. Tulangbawang","Kab. Pesawaran","Kab. Pringsewu","Kab. Mesuji","Kab. Tulang Bawang Barat","Kab. Pesisir Barat","Kota Bandar Lampung","Kota Metro","Kab. Bangka","Kab. Belitung","Kab. Bangka Barat","Kab. Bangka Tengah","Kab. Bangka Selatan","Kab. Belitung Timur","Kota Pangkal Pinang","Kab. Karimun","Kab. Bintan","Kab. Natuna","Kab. Lingga","Kab. Kepulauan Anambas","Kota B A T A M","Kota Tanjung Pinang","Kab. Kepulauan Seribu","Kota Jakarta Selatan","Kota Jakarta Timur","Kota Jakarta Pusat","Kota Jakarta Barat","Kota Jakarta Utara","Kab. Bogor","Kab. Sukabumi","Kab. Cianjur","Kab. Bandung","Kab. Garut","Kab. Tasikmalaya","Kab. Ciamis","Kab. Kuningan","Kab. Cirebon","Kab. Majalengka","Kab. Sumedang","Kab. Indramayu","Kab. Subang","Kab. Purwakarta","Kab. Karawang","Kab. Bekasi","Kab. Bandung Barat","Kab. Pangandaran","Kota Bogor","Kota Sukabumi","Kota Bandung","Kota Cirebon","Kota Bekasi","Kota Depok","Kota Cimahi","Kota Tasikmalaya","Kota Banjar","Kab. Cilacap","Kab. Banyumas","Kab. Purbalingga","Kab. Banjarnegara","Kab. Kebumen","Kab. Purworejo","Kab. Wonosobo","Kab. Magelang","Kab. Boyolali","Kab. Klaten","Kab. Sukoharjo","Kab. Wonogiri","Kab. Karanganyar","Kab. Sragen","Kab. Grobogan","Kab. Blora","Kab. Rembang","Kab. Pati","Kab. Kudus","Kab. Jepara","Kab. Demak","Kab. Semarang","Kab. Temanggung","Kab. Kendal","Kab. Batang","Kab. Pekalongan","Kab. Pemalang","Kab. Tegal","Kab. Brebes","Kota Magelang","Kota Surakarta","Kota Salatiga","Kota Semarang","Kota Pekalongan","Kota Tegal","Kab. Kulon Progo","Kab. Bantul","Kab. Gunung Kidul","Kab. Sleman","Kota Yogyakarta","Kab. Pacitan","Kab. Ponorogo","Kab. Trenggalek","Kab. Tulungagung","Kab. Blitar","Kab. Kediri","Kab. Malang","Kab. Lumajang","Kab. Jember","Kab. Banyuwangi","Kab. Bondowoso","Kab. Situbondo","Kab. Probolinggo","Kab. Pasuruan","Kab. Sidoarjo","Kab. Mojokerto","Kab. Jombang","Kab. Nganjuk","Kab. Madiun","Kab. Magetan","Kab. Ngawi","Kab. Bojonegoro","Kab. Tuban","Kab. Lamongan","Kab. Gresik","Kab. Bangkalan","Kab. Sampang","Kab. Pamekasan","Kab. Sumenep","Kota Kediri","Kota Blitar","Kota Malang","Kota Probolinggo","Kota Pasuruan","Kota Mojokerto","Kota Madiun","Kota Surabaya","Kota Batu","Kab. Pandeglang","Kab. Lebak","Kab. Tangerang","Kab. Serang","Kota Tangerang","Kota Cilegon","Kota Serang","Kota Tangerang Selatan","Kab. Jembrana","Kab. Tabanan","Kab. Badung","Kab. Gianyar","Kab. Klungkung","Kab. Bangli","Kab. Karang Asem","Kab. Buleleng","Kota Denpasar","Kab. Lombok Barat","Kab. Lombok Tengah","Kab. Lombok Timur","Kab. Sumbawa","Kab. Dompu","Kab. Bima","Kab. Sumbawa Barat","Kab. Lombok Utara","Kota Mataram","Kota Bima","Kab. Sumba Barat","Kab. Sumba Timur","Kab. Kupang","Kab. Timor Tengah Selatan","Kab. Timor Tengah Utara","Kab. Belu","Kab. Alor","Kab. Lembata","Kab. Flores Timur","Kab. Sikka","Kab. Ende","Kab. Ngada","Kab. Manggarai","Kab. Rote Ndao","Kab. Manggarai Barat","Kab. Sumba Tengah","Kab. Sumba Barat Daya","Kab. Nagekeo","Kab. Manggarai Timur","Kab. Sabu Raijua","Kota Kupang","Kab. Sambas","Kab. Bengkayang","Kab. Landak","Kab. Pontianak","Kab. Sanggau","Kab. Ketapang","Kab. Sintang","Kab. Kapuas Hulu","Kab. Sekadau","Kab. Melawi","Kab. Kayong Utara","Kab. Kubu Raya","Kota Pontianak","Kota Singkawang","Kab. Kotawaringin Barat","Kab. Kotawaringin Timur","Kab. Kapuas","Kab. Barito Selatan","Kab. Barito Utara","Kab. Sukamara","Kab. Lamandau","Kab. Seruyan","Kab. Katingan","Kab. Pulang Pisau","Kab. Gunung Mas","Kab. Barito Timur","Kab. Murung Raya","Kota Palangka Raya","Kab. Tanah Laut","Kab. Kota Baru","Kab. Banjar","Kab. Barito Kuala","Kab. Tapin","Kab. Hulu Sungai Selatan","Kab. Hulu Sungai Tengah","Kab. Hulu Sungai Utara","Kab. Tabalong","Kab. Tanah Bumbu","Kab. Balangan","Kota Banjarmasin","Kota Banjar Baru","Kab. Paser","Kab. Kutai Barat","Kab. Kutai Kartanegara","Kab. Kutai Timur","Kab. Berau","Kab. Penajam Paser Utara","Kota Balikpapan","Kota Samarinda","Kota Bontang","Kab. Malinau","Kab. Bulungan","Kab. Tana Tidung","Kab. Nunukan","Kota Tarakan","Kab. Bolaang Mongondow","Kab. Minahasa","Kab. Kepulauan Sangihe","Kab. Kepulauan Talaud","Kab. Minahasa Selatan","Kab. Minahasa Utara","Kab. Bolaang Mongondow Utara","Kab. Siau Tagulandang Biaro","Kab. Minahasa Tenggara","Kab. Bolaang Mongondow Selatan","Kab. Bolaang Mongondow Timur","Kota Manado","Kota Bitung","Kota Tomohon","Kota Kotamobagu","Kab. Banggai Kepulauan","Kab. Banggai","Kab. Morowali","Kab. Poso","Kab. Donggala","Kab. Toli-toli","Kab. Buol","Kab. Parigi Moutong","Kab. Tojo Una-una","Kab. Sigi","Kota Palu","Kab. Kepulauan Selayar","Kab. Bulukumba","Kab. Bantaeng","Kab. Jeneponto","Kab. Takalar","Kab. Gowa","Kab. Sinjai","Kab. Maros","Kab. Pangkajene Dan Kepulauan","Kab. Barru","Kab. Bone","Kab. Soppeng","Kab. Wajo","Kab. Sidenreng Rappang","Kab. Pinrang","Kab. Enrekang","Kab. Luwu","Kab. Tana Toraja","Kab. Luwu Utara","Kab. Luwu Timur","Kab. Toraja Utara","Kota Makassar","Kota Parepare","Kota Palopo","Kab. Buton","Kab. Muna","Kab. Konawe","Kab. Kolaka","Kab. Konawe Selatan","Kab. Bombana","Kab. Wakatobi","Kab. Kolaka Utara","Kab. Buton Utara","Kab. Konawe Utara","Kota Kendari","Kota Baubau","Kab. Boalemo","Kab. Gorontalo","Kab. Pohuwato","Kab. Bone Bolango","Kab. Gorontalo Utara","Kota Gorontalo","Kab. Majene","Kab. Polewali Mandar","Kab. Mamasa","Kab. Mamuju","Kab. Mamuju Utara","Kab. Maluku Tenggara Barat","Kab. Maluku Tenggara","Kab. Maluku Tengah","Kab. Buru","Kab. Kepulauan Aru","Kab. Seram Bagian Barat","Kab. Seram Bagian Timur","Kab. Maluku Barat Daya","Kab. Buru Selatan","Kota Ambon","Kota Tual","Kab. Halmahera Barat","Kab. Halmahera Tengah","Kab. Kepulauan Sula","Kab. Halmahera Selatan","Kab. Halmahera Utara","Kab. Halmahera Timur","Kab. Pulau Morotai","Kota Ternate","Kota Tidore Kepulauan","Kab. Fakfak","Kab. Kaimana","Kab. Teluk Wondama","Kab. Teluk Bintuni","Kab. Manokwari","Kab. Sorong Selatan","Kab. Sorong","Kab. Raja Ampat","Kab. Tambrauw","Kab. Maybrat","Kota Sorong","Kab. Merauke","Kab. Jayawijaya","Kab. Jayapura","Kab. Nabire","Kab. Kepulauan Yapen","Kab. Biak Numfor","Kab. Paniai","Kab. Puncak Jaya","Kab. Mimika","Kab. Boven Digoel","Kab. Mappi","Kab. Asmat","Kab. Yahukimo","Kab. Pegunungan Bintang","Kab. Tolikara","Kab. Sarmi","Kab. Keerom","Kab. Waropen","Kab. Supiori","Kab. Mamberamo Raya","Kab. Nduga","Kab. Lanny Jaya","Kab. Mamberamo Tengah","Kab. Yalimo","Kab. Puncak","Kab. Dogiyai","Kab. Intan Jaya","Kab. Deiyai","Kota Jayapura"]
      
  $(".asal").autocomplete({ 
    source: function(request, response) {
        var results = $.ui.autocomplete.filter(src, request.term);
        
        response(results.slice(0, 10));
    }
  });
  $(".tujuan").autocomplete({ 
    source: function(request, response) {
        var results = $.ui.autocomplete.filter(src, request.term);
        
        response(results.slice(0, 10));
    }
  });

    if(window.location.hash) {
    var hash = window.location.hash;

    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 1500, 'swing');
  }
  var timeout = 4000; // in miliseconds (3*1000)

  $('.alert').delay(timeout).fadeOut(500);
</script>
</html>
