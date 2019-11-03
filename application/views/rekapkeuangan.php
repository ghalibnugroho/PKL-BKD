<?php
require_once 'templates/session.php';
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
                        <div class="card-header">
                            <form id="cariRekap" method="POST" role="form" action="<?php echo site_url('RincianController/rekapkeuangan'); ?>">
                                <h6 class="m-0 font-weight-bold text-primary">REKAP KEUANGAN : </h6>
                                <select id="tahun" name="tahun">
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php
                                        for ($i=$tanggal; $i <= date('Y') ; $i++) { 
                                            echo"<option>". $i." </option>";
                                        }
                                    ?>
                                </select>
                                <button id="btnFindRekap" name="submit" class="btn btn-primary" type="submit" form="cariRekap" value="Submit"><span class="icon text-white-50"><i class="fas fa-sm fa-search"></i></span><span class="text"> find</span></button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?= $this->session->flashdata('tambahKegiatan'); ?>
                                <?= $this->session->flashdata('updateKegiatan'); ?>
                                <?= $this->session->flashdata('hapusKegiatan'); ?>
                                <div id="result">
                                    <?php
                                    if (isset($_POST['submit'])) {
                                        if (isset($_POST['tahun'])) {
                                            if ($_POST['tahun'] != "") {
                                                echo '<div class="">Rekap Keuangan Tahun <span style="color: blue"=>' . $_POST['tahun'] . ' </span> <span id="btn-margin-unduh">
                                                <a href=\'' . site_url('RincianController/exportRekap/') . $_POST['tahun'] . '\' class="d-none d-sm-inline-block btn btn-sm btn-success"><i class="fas fa-sm fa-download"></i> Unduh </a> </span>
                                                </div>';
                                            } else {
                                                echo "* Pilih Tahun Rekap Keuangan yang ingin anda cari";
                                            }
                                        }
                                    } else {
                                        echo "* Pilih Tahun Rekap Keuangan yang ingin anda cari";
                                    }
                                    ?>
                                </div>
                                <div style="clear:both"></div>
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




    <script>
        $('#tahun').select2({
            placeholder: "Tahun Rekap Keuangan",
            width: '20%',
        });



        $('#dd-bidang').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    </script>