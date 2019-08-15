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
        <?=$this->session->flashdata('message');?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar SPPD</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <col width="12%">
                  <col width="40%">
                  <col width="12%">
                  <col width="12%">
                  <col width="12%">
                  <col width="12%">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Maksud</th>
                      <th>Instansi Tujuan</th>
                      <th>Tanggal Berangkat</th>
                      <th>Tanggal Kembali</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    foreach($list as $li){
                      echo "<tr>
                            <td>" .$li->NAMA."</td>
                            <td>" .$li->DASAR."</td>
                            <td>" .$li->INSTANSI." </td>
                            <td>" .$li->TGL_BERANGKAT."</td>
                            <td>" .$li->TGL_KEMBALI."</td>";
                            if (($li->INSTANSI == null)&& ($li->TGL_KEMBALI == null)&&($li->TGL_BERANGKAT == null)) {
                              echo "<td><a href=\"".site_url("sppdController/sppd/").$li->ID_ST."\" class=\"d-none d-sm-inline-block btn btn-sm btn-success\"><i class=\"fas fa-sm fa-pencil\"></i> Buat SPPD </a>
                            </tr>"; 
                            }else{
                              echo "<td><a href=\"".site_url("sppdController/sppd/").$li->ID_ST."\" class=\"d-none d-sm-inline-block btn btn-sm btn-info\"><i class=\"fas fa-sm fa-edit\"></i> Edit </a>
                            </tr>"; 
                            }
                            
                    }
                  ?>

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
          <a class="btn btn-primary" href="<?=base_url('auth/logout');?>">Logout</a>
        </div>
      </div>
    </div>
  </div>



</body>

</html>
