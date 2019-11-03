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
          <div class="card shadow mb-4" id="inputST">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Surat Tugas</h6>
                </div>
                <div class="card-body">
                <div class="tab-pane active full-height" id="tab_1">  
                <form method="POST" role="form" action="<?php echo site_url('SuratTugasController/insertSurattugas');?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Tanggal pembuatan surat</label>
                                    <input required type="text" name="tanggal"
                                    class="input-tanggal form-control sc-input-required sc-date tanggal" value=""
                                    placeholder="Tgl Berangkat" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-3">
                              <label>Nomor Surat</label>
                              <input type="text" name="nosurat"
                              class="form-control sc-input-required" value=""
                              placeholder="" >
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label>Dasar</label>
                            <textarea required rows="2" cols="" name="dasar"
                            class="form-control  sc-input-required"></textarea>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-4">
                              <label>Pegawai yang diperintah</label>
                              <select required id="selectPegawai" name="diperintah" class=" diperintah form-control sc-input-required">
                                <option></option>
                                <?php foreach ($data as $op) {
                                  echo "<option>".$op->NAMA."</option>";
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label>Pengikut &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                            <input type="text" name="pengikut" id="pengikut" 
                            class="form-control sc-select-multi" 
                            placeholder="Pengikut">
                        </div>
                        <div class="form-group">
                            <label>Untuk</label>
                            <textarea required rows="2" cols="130" name="untuk"
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


  <!-- Footer-->
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

<script>
  $('#selectPegawai').select2({
      placeholder: "Nama Pegawai",
      dropdownParent: $('#inputST'),
      width: '100%',
      });
  $(document).ready(
    function() {
    $(function() {
          $(".tanggal").datepicker({
             showButtonPanel: true,
             //minDate: new Date(),
             showTime: true
          });
       });
   });
   
	$('input[name="pengikut"]').amsifySuggestags({
    suggestionsAction : {
						url : '<?php echo site_url('SuratTugasController/getPegawaiAll');?>'
					},
          whiteList: true
		//suggestions: ['Malang', 'Kediri', 'Madiun', 'Surabaya', 'Jayapura', 'Timika']
	});

</script>