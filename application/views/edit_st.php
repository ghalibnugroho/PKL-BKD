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
          <div class="card shadow mb-4" id="editst">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Surat Tugas</h6>
                </div>
                <div class="card-body">
                <div class="tab-pane active full-height" id="tab_1">  
                <?php 
                    foreach ($st as $d ) {
                        
                    
                ?>
                <form method="POST" role="form" action="<?php echo base_url('SuratTugasController/editST');?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="hidden" required name="id" value="<?php echo $d->ID_ST; ?>">
                                    <label>Tanggal pembuatan surat</label>
                                    <input type="text" name="tanggal"
                                    class="input-tanggal form-control sc-input-required sc-date tanggal" value="<?php echo $d->TANGGAL; ?>"
                                    placeholder="Tgl Berangkat" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-3">
                              <label>Nomor Surat</label>
                              <input type="text" name="nosurat"
                              class="form-control sc-input-required " value="<?php echo $d->NOMOR_SURAT; ?>"
                              placeholder="" >
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label>Dasar</label>
                            <textarea required rows="2" cols="" name="dasar" 
                            class="form-control  sc-input-required"><?php echo $d->DASAR ;?></textarea>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-4">
                            <label>Pegawai yang diperintah </label>
                              <select required id="selectPegawai" name="diperintah" class=" diperintah form-control sc-input-required">
                                <option><?php echo $peserta[0]->NAMA;?></option>
                                <?php foreach ($all as $op) {
                                  echo "<option>".$op->NAMA."</option>";
                                }
                                ?>
                              </select>
                            </div> 
                          </div> 
                        </div>
                        <div class="form-group">
                            <label>Pengikut &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                            <input type="text" name="pengikut" id="pengikut" value="<?php for ($i=1 ;$i < count($peserta); $i++) { 
                              echo $peserta[$i]->NAMA;
                              if ($i != count($peserta)-1) {
                                echo ",,";
                              };
                            }?>"
                            class="form-control sc-select-multi" 
                            placeholder="Pengikut">
                        </div>
                        <div class="form-group">
                            <label>Untuk</label>
                            <textarea required  rows="2" cols="130" name="untuk"
                            class="form-control  sc-input-required"><?php echo $d->TUJUAN; ?></textarea>
                        </div>

                        <input type="submit" value="Simpan" class="btn btn-primary">
                </form>
                    <?php } ?>
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


</body>

</html>

<script>
  $('#selectPegawai').select2({
      placeholder: "Nama Pegawai",
      dropdownParent: $('#editst'),
      width: '100%',
    });
     $(document).ready(function(){
        $( ".diperintah" ).autocomplete({
          source: "<?php echo site_url('SuratTugasController/getPegawai/?');?>"
        });
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
					}
		//suggestions: ['Malang', 'Kediri', 'Madiun', 'Surabaya', 'Jayapura', 'Timika']
	});

</script>