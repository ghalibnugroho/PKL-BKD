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


          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive scrollable">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No SPPD</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Maksud</th>
                      <th>Pemberi Perintah</th>
                      <th>Pegawai yang Diperintah</th>
                      <th>Tujuan</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td>800/1221/35.73.403/2019</td>
                      <td>23/06/2019</td>
                      <td>Dilaksanakan</td>
                      <td>Mencari Dragon Ball</td>
                      <td>Goku</td>
                      <td>Gohan</td>
                      <td>Membangunkan dewa naga</td>
                    </tr>
                    <tr>
                      <td>800/1222/35.73.403/2019</td>
                      <td>23/06/2019</td>
                      <td>Dilaksanakan</td>
                      <td>Mencari Planet Namex</td>
                      <td>Goku</td>
                      <td>Krilin</td>
                      <td>Jalan-jalan</td>
                    </tr>
                    <tr>
                      <td>800/1223/35.73.403/2019</td>
                      <td>23/06/2019</td>
                      <td>Dilaksanakan</td>
                      <td>Mengalahkan Frieza</td>
                      <td>Goku</td>
                      <td>Bejita</td>
                      <td>Kedamaian dunia</td>
                    </tr>
                    
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
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
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

  <!-- Footer-->
  <?php $this->load->view("templates/auth_footer") ?>

</body>

</html>