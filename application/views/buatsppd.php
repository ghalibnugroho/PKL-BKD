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
                  <h6 class="m-0 font-weight-bold text-primary">Buat SPPD</h6>
                </div>
                <div class="card-body">
                <div class="tab-pane active full-height" id="tab_1">  
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label>Pejabat yang memberi perintah</label>
                                    <input type="text" name="nip_pejabat" id="nip_pejabat" 
                                    class="form-control sc-input-required sc-select" 
                                    placeholder="Pejabat yang memberi perintah" data-sf="LoadNip">
                                    <input type="hidden" name="cPageSource" id="cPageSource" 
                                    value="">
                                    <input type="hidden" name="code" id="code" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Maksud Perjalanan Dinas</label>
                            <input type="text" name="purpose" id="purpose"
                            class="form-control sc-input-required" placeholder="Maksud Perjalanan Dinas">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Alat Angkut yang dipergunakan</label>
                                    <input type="text" name="transport" id="transport" 
                                    class="form-control sc-input-required" 
                                    placeholder="Alat Angkut yang dipergunakan">
                                </div>
                                <div class="col-sm-3">
                                    <label>Tempat Berangkat</label>
                                    <input type="text" name="place_from" id="place_from" 
                                    class="form-control sc-input-required" 
                                    placeholder="Tempat Berangkat">
                                </div>
                                <div class="col-sm-3">
                                    <label>Tempat Tujuan</label>
                                    <input type="text" name="place_to" id="place_to" 
                                    class="form-control sc-input-required" 
                                    placeholder="Tempat Tujuan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Lama Perjalanan (Hari)</label>
                                    <input type="text" name="length_journey" id="length_journey" 
                                    class="form-control sc-input-required sc-number" value="1" 
                                    placeholder="Lama Perjalanan">
                                </div>
                                <div class="col-sm-3">
                                    <label>Tgl Berangkat</label>
                                    <input type="text" name="date_go" id="date_go" 
                                    class="input-tanggal form-control sc-input-required sc-date" value=""
                                    placeholder="Tgl Berangkat" >
                                </div>
                                <div class=" col-sm-3">
                                    <label>Tgl Kembali</label>
                                    <input type="text" name="date_back" id="date_back" 
                                    class="input-tanggal form-control sc-input-required sc-date" value="" 
                                    placeholder="Tgl Kembali" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Pegawai yang diperintah</label>
                                    <input type="text" name="nip_leader" id="nip_leader" 
                                    class="form-control sc-input-required sc-select" 
                                    placeholder="Pegawai yang diperintah" data-sf="LoadNip">
                                </div>
                                <div class="col-sm-2">
                                    <label>Tingkat Perjalanan</label>
                                    <input type="text" name="rate_travel" id="rate_travel"
                                    class="form-control sc-input-required" placeholder="Tingkat Perjalanan">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pengikut &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                            <input type="text" name="nip" id="nip" 
                            class="form-control sc-select-multi" 
                            placeholder="Pengikut" data-sf="LoadNip">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label>Instansi (Pembebanan Anggaran)</label>
                                    <input type="text" name="government" id="government" 
                                    class="form-control sc-input-required" 
                                    placeholder="Instansi (Pembebanan Anggaran)">
                                </div>
                                <div class="col-sm-2">
                                    <label>Mata Aggaran</label>
                                    <input type="text" name="budget_from" id="budget_from" 
                                    class="form-control sc-input-required" 
                                    placeholder="Mata Aggaran">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Lain &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                            <input type="text" name="description" id="description" 
                            class="form-control" placeholder="Keterangan Lain">
                        </div>
                        <hr />
                        <div class="form-group">
                            <label>Dasar Surat</label>
                                    <!--<input type="text" name="letter_content" id="letter_content" 
                            class="form-control  sc-input-required" placeholder="Dasar Surat"> -->
                            <textarea rows="6" cols="130" id="letter_content" 
                            class="form-control  sc-input-required">
                            </textarea>
                        </div>
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