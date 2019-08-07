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
                  <form method="POST" role="form" action="<?php echo site_url('sppdController/insertSPPD');?>">

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
<script>
  $(document).ready(function() {
    $(".pegawai_diperintah").autocomplete({
      source: "<?php echo site_url('sppdController/getPegawai/?'); ?>"
    });
  });

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

  $('input[name="pengikut"]').amsifySuggestags({
    suggestionsAction: {
      url: '<?php echo site_url('sppdController/getPegawaiAll'); ?>'
    }
    //suggestions: ['Malang', 'Kediri', 'Madiun', 'Surabaya', 'Jayapura', 'Timika']
  });

  $('#transport').inputTags({
    autocomplete: {
      values: ['jQuery', 'tags', 'plugin', 'Javascript'],
      only: true
    },
    max: 3,
    create: function() {
      console.log('Tag added !');
    }
  });
</script>

</html>