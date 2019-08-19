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
                            <a href="#" data-target="#tambahPegawai" data-toggle="modal" class="btn btn-info btn-icon-split float-right"><span class="icon text-white-50"><i class="fas fa-sm fa-plus"></i></span><span class="text">Tambah Pegawai</span>
                                    </a>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <?=$this->session->flashdata('tambahPegawai');?>
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

    <div class="modal fade" id="tambahPegawai" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                <select id="dd-bidang" name="bidang">
                                    <option></option>
                                    <option value="SEKRETARIAT">Sekretariat</option>
                                    <option value="MUTASI">Mutasi</option>
                                    <option value="PKFP">PKFP</option>
                                    <option value="PKP">PKP</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label>Pangkat</label>
                                <select id="dd-pangkat" name="pangkat">
                                    <option></option>
                                    <option value="Juru Muda">Juru Muda</option>
                                    <option value="Juru Muda Tingkat I">Juru Muda Tingkat I</option>
                                    <option value="Juru">Juru</option>
                                    <option value="Juru Tingkat I">Juru Tingkat I</option>
                                    <option value="Pengatur Muda">Pengatur Muda</option>
                                    <option value="Pengatur Muda Tingkat I">Pengatur Muda Tingkat I</option>
                                    <option value="Pengatur">Pengatur</option>
                                    <option value="Pengatur Tingkat I">Pengatur Tingkat I</option>
                                    <option value="Penata Muda">Penata Muda</option>
                                    <option value="Penata Muda Tingkat I">Penata Muda Tingkat I</option>
                                    <option value="Penata">Penata</option>
                                    <option value="Penata Tingkat I">Penata Tingkat I</option>
                                    <option value="Pembina">Pembina</option>
                                    <option value="Pembina Tingkat I">Pembina Tingkat I</option>
                                    <option value="Pembina Utama Muda">Pembina Utama Muda</option>
                                    <option value="Pembina Utama Madya">Pembina Utama Madya</option>
                                    <option value="Pembina Utama">Pembina Utama</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label>Golongan</label>
                                <select id="dd-golongan" name="golongan">
                                    <option></option>
                                    <option value="I/a">I/a</option>
                                    <option value="I/b">I/b</option>
                                    <option value="I/c">I/c</option>
                                    <option value="I/d">I/d</option>
                                    <option value="II/a">II/a</option>
                                    <option value="II/b">II/b</option>
                                    <option value="II/c">II/c</option>
                                    <option value="II/d">II/d</option>
                                    <option value="III/a">III/a</option>
                                    <option value="III/b">III/b</option>
                                    <option value="III/c">III/c</option>
                                    <option value="III/d">III/d</option>
                                    <option value="IV/a">IV/a</option>
                                    <option value="IV/b">IV/b</option>
                                    <option value="IV/c">IV/c</option>
                                    <option value="IV/d">IV/d</option>
                                    <option value="IV/e">IV/e</option>
                                </select>
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
                    <input type="submit" value="Tambahkan Pegawai" class="btn btn-primary col-3">
                  </form>
                </div>
            <span aria-hidden="true">×</span>
          </button>
        </div>

      </div>
    </div>
  </div>

    <script>
       $('#dd-bidang').select2({
        placeholder: "Input Bidang",
        dropdownParent: $('#tambahPegawai'),
        width: '100%',
        });
       $('#dd-pangkat').select2({
        placeholder: "Input Pangkat",
        dropdownParent: $('#tambahPegawai'),
        width: '100%',
        });
       $('#dd-golongan').select2({
        placeholder: "Input golongan",
        dropdownParent: $('#tambahPegawai'),
        width: '100%',
        });
        </script>
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