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
                            <h6 class="m-0 font-weight-bold text-primary">DAFTAR KEGIATAN : </h6>
                            <input type="text" name="search_text" id="search_text" placeholder="Kode / Nama Kegiatan / NIP" class="form-control col-3" />
                            <a href="#" data-target="#tambahKegiatan" data-toggle="modal" class="btn btn-info btn-icon-split float-right"><span class="icon text-white-50"><i class="fas fa-sm fa-plus"></i></span><span class="text">Tambah Kegiatan</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?= $this->session->flashdata('tambahKegiatan'); ?>
                                <?= $this->session->flashdata('updateKegiatan'); ?>
                                <?= $this->session->flashdata('hapusKegiatan'); ?>
                                <div id="result"></div>
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


    <div class="modal fade" id="tambahKegiatan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="tab-pane active col-12" id="tab_1">
                        <form method="POST" role="form" action="<?php echo site_url('KegiatanController/addKegiatan'); ?>">
                            <div class="form-group">
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="row">
                                    <!-- <?php echo date("jS F, Y", strtotime("11.12.10")); ?> -->
                                    <div class="col-6">
                                        <label>Kode Kegiatan</label>
                                        <input required type="text" name="kode_kegiatan" placeholder="Kode Kegiatan" class="form-control sc-input-required sc-select">
                                    </div>
                                    <div class="col-6">
                                        <label>NIP</label>
                                        <select required id="nip" name="nip_pegawai" class="form-control sc-input-required sc-select">
                                            <option></option>
                                            <?php 
                                            foreach($NIP as $n){
                                                echo "<option>".$n->NIP."</option>";
                                            };
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label>Nama Kegiatan</label>
                                        <input required type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" class="form-control sc-input-required sc-select">
                                    </div>
                                    <div class="col-6">
                                        <label>Bidang Pegawai</label>
                                        <select required id="dd-bidang" name="bidang" class="form-control">
                                            <option></option>
                                            <option value="2">Sekretariat</option>
                                            <option value="3">Mutasi</option>
                                            <option value="4">PKFP</option>
                                            <option value="5">PKP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="Tambahkan Kegiatan" class="btn btn-primary col-3">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    foreach ($list as $li) {
        $KODE_TEMP = str_replace(".", "", $li->kode);
        ?>

        <div class="modal fade" id="editKegiatan<?php echo $KODE_TEMP ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="tab-pane active col-12" id="tab_1">
                            <form method="POST" role="form" action="<?php echo site_url('KegiatanController/editKegiatan'); ?>">
                                <div class="form-group">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><span style="color: blue"><?php echo $li->nama  ?></span> - EDIT DATA KEGIATAN</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Kode Kegiatan</label>
                                            <input required type="text" name="kode_kegiatan" placeholder="Kode Kegiatan" class="form-control sc-input-required sc-select" value="<?php echo $li->kode ?>">
                                            <input type="hidden" name="kode_hidden" value="<?php echo $li->kode ?>">
                                        </div>
                                        <div class=" col-6">
                                            <label>NIP</label>
                                            <input required type="text" name="nip_pegawai" placeholder="NIP Pegawai" class="form-control sc-input-required sc-select" value="<?php echo $li->nip_pptk ?>">
                                        </div>
                                        <div class=" col-6">
                                            <label>Nama Kegiatan</label>
                                            <input required type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" class="form-control sc-input-required sc-select" value="<?php echo $li->nama_kegiatan ?>">
                                        </div>
                                        <div class="col-6">
                                            <label>Bidang Pegawai</label>
                                            <select required id="dd-bidang" name="bidang" class="form-control">
                                                <option></option>
                                                <option value="2" <?php if ($li->id_bidang == 2) echo 'selected="selected"'; ?>>Sekretariat</option>
                                                <option value="3" <?php if ($li->id_bidang == 3) echo 'selected="selected"'; ?>>Mutasi</option>
                                                <option value="4" <?php if ($li->id_bidang == 4) echo 'selected="selected"'; ?>>PKFP</option>
                                                <option value="5" <?php if ($li->id_bidang == 5) echo 'selected="selected"'; ?>>PKP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" value="Accept" class="btn btn-primary col-3">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>
    <?php
    foreach ($list as $li) {
        $KODE_TEMP = str_replace(".", "", $li->kode);
        ?>
        <div class="modal fade" id="hapusKegiatan<?php echo $KODE_TEMP ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Apakah anda yakin menghapus kegiatan tersebut?</h6>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Hapus Kegiatan <span style="color: blue"=><?php echo $li->kode ?></span> dari daftar kegiatan</div>
                    <div class="modal-footer">

                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="<?= base_url('KegiatanController/hapusKegiatan/' . $li->kode); ?>">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>

    <script>
        $('#dd-bidang').select2({
            placeholder: "Input Bidang Pegawai",
            dropdownParent: $('#tambahKegiatan'),
            width: '100%',
        });
        $('#nip').select2({
            placeholder: "Input NIP Pegawai",
            dropdownParent: $('#tambahKegiatan'),
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
        $(document).ready(function() {

            load_data();

            function load_data(query) {
                $.ajax({
                    url: "<?php echo base_url(); ?>KegiatanController/fetchDataKegiatan",
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