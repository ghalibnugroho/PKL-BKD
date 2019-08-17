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
          <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Bregaster</h6>
                </div>
                <div class="card-body">
                    <!-- Default Card Example -->
                    <div class="card mb-4">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                        Transportasi
                            <a href="<?php echo site_url('surat-tugas') ?>" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                <i class="fas fa-sm fa-plus"></i>
                                </span>
                                <span class="text">Tambah Transportasi</span>
                            </a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <col width="15%">
                            <col width="25%">
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                            <thead>
                                <tr>
                                <th>No Tiket</th>
                                <th>Jenis Angkutan</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Waktu Berangkat</th>
                                <th>Waktu Sampai Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A638H</td>
                                    <td>Pesawat Jet</td>
                                    <td>Malang</td>
                                    <td>Jayapura</td>
                                    <td>20 Agustus 2019</td>
                                    <td>19 Agustus 2019</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <!-- Default Card Example -->
                    <div class="card mb-4">
                        <div class="card-header d-sm-flex align-items-center justify-content-between">
                        Penginapan
                            <a href="#" data-target="#penginapan" data-toggle="modal" class="btn btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                <i class="fas fa-sm fa-plus"></i>
                                </span>
                                <span class="text">Tambah Penginapan</span>
                            </a>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <col width="15%">
                            <col width="25%">
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                            <col width="15%">
                            <thead>
                                <tr>
                                <th>No Tiket</th>
                                <th>Jenis Angkutan</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Waktu Berangkat</th>
                                <th>Waktu Sampai Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A638H</td>
                                    <td>Pesawat Jet</td>
                                    <td>Malang</td>
                                    <td>Jayapura</td>
                                    <td>20 Agustus 2019</td>
                                    <td>19 Agustus 2019</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
          <div class="card "></div>
          <!-- DataTales Peserta -->
          <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Bregaster</h6>
                </div>
                <div class="card-body">
                <div class="tab-pane active full-height" id="tab_1">
                  <form method="POST" role="form" action="<?php echo site_url('sppdController/insertSPPD'); ?>">

                        <div class="form-group">
                            <label>Transportasi</label>
                            <input type="text" name="pegawai_diperintah"
                            class="form-control sc-input-required sc-select pegawai_diperintah" >

                        </div>
                        <div class="form-group">
                            <label>Penginapan</label>
                            <textarea rows="2" cols="130" name="maksud"
                            class="form-control  sc-input-required"></textarea>
                        </div>
                        <input type="submit" value="Simpan" class="btn btn-primary">
                  </form>
                </div>
          </div>
        </div>
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

  <!-- Penginapan Modal-->
  <div class="modal fade" id="penginapan" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <div class="tab-pane active" id="tab_1">
                  <form method="POST" role="form" action="<?php echo site_url('sppdController/insertSPPD'); ?>">

                        <div class="form-group">
                            <label>Pegawai yang diperintah</label>
                            <input type="text" name="pegawai_diperintah"
                            class="form-control sc-input-required sc-select pegawai_diperintah" >

                  </div>
                  <div class="form-group">
                    <label>Maksud perjalanan Dinas</label><textarea rows="2" cols="130" name="maksud" class="form-control  sc-input-required"></textarea>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6">
                        <label>Alat Angkut yang dipergunakan</label>
                        <input type="text" name="alat_angkut" class=" form-control sc-input-required" placeholder="Alat Angkut yang dipergunakan">
                      </div>
                      <div class="col-sm-3">
                        <label>Tempat Berangkat</label>
                        <input type="text" name="tempat_berangkat" class="form-control sc-input-required" placeholder="Tempat Berangkat">
                      </div>
                      <div class="col-sm-3">
                        <label>Tempat Tujuan</label>
                        <input type="text" name="tempat_tujuan" class="form-control sc-input-required" placeholder="Tempat Tujuan">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">

                      <div class="col-sm-3">
                        <label>Tgl Berangkat</label>
                        <input type="text" name="tgl_berangkat" class="input-tanggal form-control sc-input-required sc-date" value="" placeholder="Tgl Berangkat">
                      </div>
                      <div class=" col-sm-3">
                        <label>Tgl Kembali</label>
                        <input type="text" name="tgl_kembali" class="input-tanggal form-control sc-input-required sc-date" value="" placeholder="Tgl Kembali">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Pengikut &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                    <input type="text" name="pengikut" id="pengikut" class="form-control sc-select-multi" placeholder="Pengikut">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label>Instansi Tujuan</label>
                        <input type="text" name="instansi" class="form-control sc-input-required" placeholder="Instansi Tujuan">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Keterangan Lain &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan Lain">
                  </div>
                  <input type="submit" value="Simpan" class="btn btn-primary">
                  </form>
                </div>
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

</html>
