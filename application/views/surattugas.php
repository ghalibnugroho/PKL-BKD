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
                  <h6 class="m-0 font-weight-bold text-primary">Surat Tugas</h6>
                </div>
                <div class="card-body">
                <div class="tab-pane active full-height" id="tab_1">  
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Tanggal pembuatan surat</label>
                                    <input type="text" name="date_go" id="date_go" 
                                    class="input-tanggal form-control sc-input-required sc-date" value=""
                                    placeholder="Tgl Berangkat" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Dasar</label>
                            <textarea rows="2" cols="130" id="letter_content" 
                            class="form-control  sc-input-required">
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label>Pegawai yang diperintah</label>
                            <input type="text" name="purpose" id="purpose"
                            class="form-control sc-input-required" >
                        </div>
                        <div class="form-group">
                            <label>Untuk</label>
                            <textarea rows="2" cols="130" id="letter_content" 
                            class="form-control  sc-input-required">
                            </textarea>
                        </div>


                        <hr />

                        <button type="button" class="btn btn-primary" id="cmdSave" name="cmdSave">Simpan</button>
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
</script>
</body>

</html>
