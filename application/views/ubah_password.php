<?php
require_once('templates/session.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view("templates/auth_header") ?>

<body id="page-top">
  <div id="wrapper">
    <?php $this->load->view("templates/auth_sidebar") ?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php $this->load->view("templates/auth_topbar") ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?= $this->session->flashdata('message'); ?>
          <!-- DataTales User -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary col-sm-3" id="judul">Ubah Password User Bidang</h6>

            </div>
            <div class="card-body">
              <div class="table-responsive ">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <col width="50%">
                  <col width="50%">
                  <thead>
                    <tr>
                      <th>Nama Bidang</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($list as $li) {
                      echo "<tr>
                            <td>" . $li->NAMA_BIDANG . "</td>
                            <td>";
                      ?>
                      <a href="" data-target="#ubah<?php echo $li->ID_BIDANG ?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info">
                        <i class="fas fa-sm fa-edit"></i> Ubah Password
                      </a>


                      </td>
                      </tr>

                      <!-- Ubah Password Modal-->
                      <div class="modal fade" id="ubah<?php echo $li->ID_BIDANG; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="tab-pane active" id="tab_1">
                                <form method="POST" role="form" action="<?php echo site_url('UserController/setPassword'); ?>">
                                  <div class="form-group">
                                    <div class="row">
                                      <div class="col-sm-8">
                                        <input type="hidden"  name="idbidang" value="<?php echo $li->ID_BIDANG; ?>">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group input-group">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <label>Masukkan password lama</label>
                                        <input type="password" required placeholder="Password Lama" name="passlama" class=" form-control sc-input-required">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group input-group">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <label>Masukkan password baru</label>
                                        <input type="password" placeholder="Passsword Baru" required name="passbaru1" class=" form-control sc-input-required">
                                        <?= form_error('passbaru1', '<small class="text-danger pl-3">', '</small>'); ?>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group input-group">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <label>Masukkan password baru lagi</label>
                                        <input type="password" placeholder="Verifikasi Password Baru" required name="passbaru2" class=" form-control sc-input-required">
                                      </div>
                                    </div>
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
                    <script language="javascript">

                    </script>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- DataTales Admin -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary col-sm-3" id="judul">Ubah Password Admin</h6>

            </div>
            <div class="card-body">
              <div class="table-responsive ">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <col width="50%">
                  <col width="50%">
                  <thead>
                    <tr>
                      <th>Nama Admin</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($adm as $li) {
                      echo "<tr>
                            <td>" . $li->ID_ADM . "</td>
                            <td>";
                      ?>
                      <a href="" data-target="#ubahadm<?php echo $li->ID_ADM ?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-info">
                        <i class="fas fa-sm fa-edit"></i> Ubah Password
                      </a>


                      </td>
                      </tr>

                      <!-- Ubah Password Modal-->
                      <div class="modal fade" id="ubahadm<?php echo $li->ID_ADM; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-body">
                              <div class="tab-pane active" id="tab_1">
                                <form method="POST" role="form" action="<?php echo site_url('UserController/setPasswordAdm'); ?>">
                                  <div class="form-group">
                                    <div class="row">
                                      <div class="col-sm-8">
                                        <input type="hidden"  name="idadm" value="<?php echo $li->ID_ADM; ?>">
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group input-group">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <label>Masukkan password lama</label>
                                        <input type="password" required placeholder="Password Lama" name="passlama" class=" form-control sc-input-required">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group input-group">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <label>Masukkan password baru</label>
                                        <input type="password" placeholder="Passsword Baru" required name="passbaru1" class=" form-control sc-input-required">
                                        <?= form_error('passbaru1', '<small class="text-danger pl-3">', '</small>'); ?>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group input-group">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <label>Masukkan password baru lagi</label>
                                        <input type="password" placeholder="Verifikasi Password Baru" required name="passbaru2" class=" form-control sc-input-required">
                                      </div>
                                    </div>
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
                    <script language="javascript">

                    </script>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php $this->load->view("templates/auth_footer") ?>
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
          <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>



</body>

</html>
<script>
  var timeout = 4000; // in miliseconds (3*1000)

  $('.alert').delay(timeout).fadeOut(500);
</script>