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


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">DAFTAR PEGAWAI : </h6>
                            <input type="text" name="search_text" id="search_text" placeholder="Nama/NIP" class="form-control col-3" />
                            <a href="#" data-target="#penginapan" data-toggle="modal" class="btn btn-info btn-icon-split float-right"><span class="icon text-white-50"><i class="fas fa-sm fa-plus"></i></span><span class="text">Tambah Pegawai</span>
                                    </a>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="result"></div>
                                <div style="clear:both"></div>
                                <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <col width="15%">
                                    <col width="18%">
                                    <col width="12%">
                                    <col width="8%">
                                    <col width="17%">
                                    <thead>
                                        <tr>
                                            <th>NIP</th>
                                            <th>NAMA</th>
                                            <th>PANGKAT</th>
                                            <th>GOLONGAN</th>
                                            <th>JABATAN</th>
                                            <th>TANGGAL LAHIR</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
foreach ($list as $li) {
    echo "<tr>
                            <td>" . $li->NIP . "</td>
                            <td>" . $li->NAMA . "</td>
                            <td>" . $li->PANGKAT . " </td>
                            <td>" . $li->GOLONGAN . "</td>
                            <td>" . $li->JABATAN . "</td>
                            <td>" . $li->TANGGALLAHIR . "</td>
                            <td><a href=\"#\" class=\"d-none d-sm-inline-block btn btn-sm btn-info\"><i class=\"fas fa-sm fa-edit\"></i> Edit </a>
                            </tr>";
}
?>

                                    </tbody>
                                </table> -->
                            </div>
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

    <div class="modal fade" id="penginapan" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <div class="tab-pane active col-12" id="tab_1">
                <form method="POST" role="form" action="<?php echo site_url('sppdController/addPegawai'); ?>">
                    <div class="form-group">
                        <div class="row">
                            <!-- <?php echo date("jS F, Y", strtotime("11.12.10")); ?> -->
                            <div class="col-6">
                                <label>Nama</label>
                                <input type="text" name="nama_pegawai" placeholder="Nama Pegawai"
                                class="form-control sc-input-required sc-select" >
                            </div>
                            <div class="col-6">
                                <label>NIP</label>
                                <input type="text" name="nip_pegawai" placeholder="NIP Pegawai"
                                class="form-control sc-input-required sc-select" >
                            </div>
                            <div class="col-12">
                                <label>Bidang</label>
                                <input type="text" name="bidang_pegawai" placeholder="Bidang Pegawai"
                                class="form-control sc-input-required sc-select " >
                            </div>
                            <div class="col-3">
                                <label>Pangkat</label>
                                <input type="text" name="pangkat_pegawai" placeholder="Pangkat Pegawai"
                                class="form-control sc-input-required sc-select" >
                            </div>
                            <div class="col-3">
                                <label>Golongan</label>
                                <input type="text" name="golongan_pegawai" placeholder="Golongan Pegawai"
                                class="form-control sc-input-required sc-select" >
                            </div>
                            <div class="col-6">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan_pegawai" placeholder="Jabatan Pegawai"
                                class="form-control sc-input-required sc-select " >
                            </div>
                            <div class="col-6">
                                <label>Tanggal Lahir</label>
                                    <input type="text" name="tanggal"
                                    class="input-tanggal form-control sc-input-required sc-date tanggal" value=""
                                    placeholder="Tgl Berangkat" >
                            </div>
                            <div class="col-6">
                                <label>Tingkat</label>
                                <input type="text" name="tingkat_pegawai" placeholder="Tingkat Pegawai"
                                class="form-control sc-input-required sc-select" >
                            </div>

                        </div>
                    </div>
                    <!-- <div class="form-group">
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
                    </div> -->


                        <!-- <div class="form-group">
                            <label>Keterangan Lain &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan Lain">
                        </div> -->
                        <input type="submit" value="Simpan" class="btn btn-primary">
                  </form>
                </div>
            <span aria-hidden="true">×</span>
          </button>
        </div>

      </div>
    </div>
  </div>


    <script>
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
        $(document).ready(function() {

            load_data();

            function load_data(query) {
                $.ajax({
                    url: "<?php echo base_url(); ?>sppdController/fetchDataPegawai",
                    method: "POST",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#result').html(data);
                    }
                })
            }

            $('#search_text').keyup(function() {
                var search = $(this).val();
                if (search != '') {
                    load_data(search);
                } else {
                    load_data();
                }
            });
        });
    </script>