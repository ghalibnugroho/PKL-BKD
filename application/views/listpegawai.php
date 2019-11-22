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
                            <h6 class="m-0 font-weight-bold text-primary">DAFTAR PEGAWAI : </h6>
                            <input type="text" name="search_text" id="search_text" placeholder="Nama/NIP" class="form-control col-3" />
                            <a href="#" data-target="#tambahPegawai" data-toggle="modal" class="btn btn-info btn-icon-split float-right"><span class="icon text-white-50"><i class="fas fa-sm fa-plus"></i></span><span class="text">Tambah Pegawai</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?= $this->session->flashdata('tambahPegawai'); ?>
                                <?= $this->session->flashdata('updatePegawai'); ?>
                                <?= $this->session->flashdata('hapusPegawai'); ?>
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
                                            echo "<td>
                            <td>" . $li->NIP . "</td>
                            <td>" . $li->NAMA . "</td>
                            <td>" . $li->PANGKAT . " </td>
                            <td>" . $li->GOLONGAN . "</td>
                            <td>" . $li->JABATAN . "</td>
                            <td>" . $li->TANGGALLAHIR . "</td>
                            <td><a href=\"\" data-target=\"#editPegawai\" data-toggle=\"modal\" class=\"d-none d-sm-inline-block btn btn-sm btn-info\"><i class=\"fas fa-sm fa-edit\"></i> Edit </a>
                            </td>";
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

    <div class="modal fade" id="tambahPegawai" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="tab-pane active col-12" id="tab_1">
                        <form method="POST" role="form" action="<?php echo site_url('PegawaiController/addPegawai'); ?>">
                            <div class="form-group">
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div class="row">
                                    <!-- <?php echo date("jS F, Y", strtotime("11.12.10")); ?> -->
                                    <div class="col-6">
                                        <label>Nama</label>
                                        <input required type="text" name="nama_pegawai" placeholder="Nama Pegawai" class="form-control sc-input-required sc-select">
                                    </div>
                                    <div class="col-6">
                                        <label>NIP</label>
                                        <input required type="text" name="nip_pegawai" placeholder="NIP Pegawai" class="form-control sc-input-required sc-select">
                                    </div>
                                    <div class="col-12">
                                        <label>Bidang</label>
                                        <select required id="dd-bidang" name="bidang">
                                            <option></option>
                                            <option value="SEKRETARIAT">Sekretariat</option>
                                            <option value="MUTASI">Mutasi</option>
                                            <option value="PKFP">PKFP</option>
                                            <option value="PKP">PKP</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label>Pangkat</label>
                                        <select required id="dd-pangkat" name="pangkat">
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
                                        <select required id="dd-golongan" name="golongan">
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
                                        <input required type="text" name="jabatan_pegawai" placeholder="Jabatan Pegawai" class="form-control sc-input-required sc-select ">
                                    </div>
                                    <div class="col-6">
                                        <label>Tanggal Lahir</label>
                                        <input required type="text" name="tanggal" class="input-tanggal form-control sc-input-required sc-date tanggal" value="" placeholder="Tgl Lahir">
                                    </div>
                                    <div class="col-6">
                                        <label>Tingkat</label>
                                        <input required type="text" name="tingkat_pegawai" placeholder="Tingkat Pegawai" class="form-control sc-input-required sc-select">
                                    </div>

                                </div>
                            </div>
                            <input type="submit" value="Tambahkan Pegawai" class="btn btn-primary col-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    foreach ($list as $li) { ?>

        <div class="modal fade" id="editPegawai<?php echo $li->NIP ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="tab-pane active col-12" id="tab_1">
                            <form method="POST" role="form" action="<?php echo site_url('PegawaiController/editPegawai'); ?>">
                                <div class="form-group">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><span style="color: blue"><?php echo $li->NAMA  ?></span> - EDIT DATA PEGAWAI</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Nama</label>
                                            <input required type="text" name="nama_pegawai" placeholder="Nama Pegawai" class="form-control sc-input-required sc-select" value="<?php echo $li->NAMA ?>">
                                        </div>
                                        <div class="col-6">
                                            <label>NIP</label>
                                            <input required type="text" name="nip_pegawai" placeholder="NIP Pegawai" class="form-control sc-input-required sc-select" value="<?php echo $li->NIP ?>">
                                            <input type="hidden" name="niphidden" value="<?php echo $li->NIP ?>">
                                        </div>
                                        <div class="col-12">
                                            <label>Bidang</label>
                                            <select required id="dd-bidang1" name="bidang1" class="form-control">
                                                <option></option>
                                                <option value="2" <?php if ($li->ID_BIDANG == 2) echo 'selected="selected"'; ?>>Sekretariat</option>
                                                <option value="3" <?php if ($li->ID_BIDANG == 3) echo 'selected="selected"'; ?>>Mutasi</option>
                                                <option value="4" <?php if ($li->ID_BIDANG == 4) echo 'selected="selected"'; ?>>PKFP</option>
                                                <option value="5" <?php if ($li->ID_BIDANG == 5) echo 'selected="selected"'; ?>>PKP</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label>Pangkat</label>
                                            <select required id="dd-pangkat" name="pangkat" class="form-control">
                                                <option></option>
                                                <option value="Juru Muda" <?php if ($li->PANGKAT == "Juru Muda") echo 'selected="selected"'; ?>>Juru Muda</option>
                                                <option value="Juru Muda Tingkat I" <?php if ($li->PANGKAT == "Juru Muda Tingkat I") echo 'selected="selected"'; ?>>Juru Muda Tingkat I</option>
                                                <option value="Juru" <?php if ($li->PANGKAT == "Juru") echo 'selected="selected"'; ?>>Juru</option>
                                                <option value="Juru Tingkat I" <?php if ($li->PANGKAT == "Juru Tingkat I") echo 'selected="selected"'; ?>>Juru Tingkat I</option>
                                                <option value="Pengatur Muda" <?php if ($li->PANGKAT == "Pengatur Muda") echo 'selected="selected"'; ?>>Pengatur Muda</option>
                                                <option value="Pengatur Muda Tingkat I" <?php if ($li->PANGKAT == "Pengatur Muda Tingkat I") echo 'selected="selected"'; ?>>Pengatur Muda Tingkat I</option>
                                                <option value="Pengatur" <?php if ($li->PANGKAT == "Pengatur") echo 'selected="selected"'; ?>>Pengatur</option>
                                                <option value="Pengatur Tingkat I" <?php if ($li->PANGKAT == "Pengatur Tingkat I") echo 'selected="selected"'; ?>>Pengatur Tingkat I</option>
                                                <option value="Penata Muda" <?php if ($li->PANGKAT == "Penata Muda") echo 'selected="selected"'; ?>>Penata Muda</option>
                                                <option value="Penata Muda Tingkat I" <?php if ($li->PANGKAT == "Penata Muda Tingkat I") echo 'selected="selected"'; ?>>Penata Muda Tingkat I</option>
                                                <option value="Penata" <?php if ($li->PANGKAT == "Penata") echo 'selected="selected"'; ?>>Penata</option>
                                                <option value="Penata Tingkat I" <?php if ($li->PANGKAT == "Penata Tingkat I") echo 'selected="selected"'; ?>>Penata Tingkat I</option>
                                                <option value="Pembina" <?php if ($li->PANGKAT == "Pembina") echo 'selected="selected"'; ?>>Pembina</option>
                                                <option value="Pembina Tingkat I" <?php if ($li->PANGKAT == "Pembina Tingkat I") echo 'selected="selected"'; ?>>Pembina Tingkat I</option>
                                                <option value="Pembina Utama Muda" <?php if ($li->PANGKAT == "Pembina Utama Muda") echo 'selected="selected"'; ?>>Pembina Utama Muda</option>
                                                <option value="Pembina Utama Madya" <?php if ($li->PANGKAT == "Pembina Utama Madya") echo 'selected="selected"'; ?>>Pembina Utama Madya</option>
                                                <option value="Pembina Utama" <?php if ($li->PANGKAT == "Pembina Utama") echo 'selected="selected"'; ?>>Pembina Utama</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label>Golongan</label>
                                            <select required id="dd-golongan" name="golongan" class="form-control">
                                                <option></option>
                                                <option value="I/a" <?php if ($li->GOLONGAN == "I/a") echo 'selected="selected"'; ?>>I/a</option>
                                                <option value="I/b" <?php if ($li->GOLONGAN == "I/b") echo 'selected="selected"'; ?>>I/b</option>
                                                <option value="I/c" <?php if ($li->GOLONGAN == "I/c") echo 'selected="selected"'; ?>>I/c</option>
                                                <option value="I/d" <?php if ($li->GOLONGAN == "I/d") echo 'selected="selected"'; ?>>I/d</option>
                                                <option value="II/a" <?php if ($li->GOLONGAN == "II/a") echo 'selected="selected"'; ?>>II/a</option>
                                                <option value="II/b" <?php if ($li->GOLONGAN == "II/b") echo 'selected="selected"'; ?>>II/b</option>
                                                <option value="II/c" <?php if ($li->GOLONGAN == "II/c") echo 'selected="selected"'; ?>>II/c</option>
                                                <option value="II/d" <?php if ($li->GOLONGAN == "II/d") echo 'selected="selected"'; ?>>II/d</option>
                                                <option value="III/a" <?php if ($li->GOLONGAN == "III/a") echo 'selected="selected"'; ?>>III/a</option>
                                                <option value="III/b" <?php if ($li->GOLONGAN == "III/b") echo 'selected="selected"'; ?>>III/b</option>
                                                <option value="III/c" <?php if ($li->GOLONGAN == "III/c") echo 'selected="selected"'; ?>>III/c</option>
                                                <option value="III/d" <?php if ($li->GOLONGAN == "III/d") echo 'selected="selected"'; ?>>III/d</option>
                                                <option value="IV/a" <?php if ($li->GOLONGAN == "IV/a") echo 'selected="selected"'; ?>>IV/a</option>
                                                <option value="IV/b" <?php if ($li->GOLONGAN == "IV/b") echo 'selected="selected"'; ?>>IV/b</option>
                                                <option value="IV/c" <?php if ($li->GOLONGAN == "IV/c") echo 'selected="selected"'; ?>>IV/c</option>
                                                <option value="IV/d" <?php if ($li->GOLONGAN == "IV/d") echo 'selected="selected"'; ?>>IV/d</option>
                                                <option value="IV/e" <?php if ($li->GOLONGAN == "IV/e") echo 'selected="selected"'; ?>>IV/e</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label>Jabatan</label>
                                            <input required type="text" name="jabatan_pegawai" placeholder="Jabatan Pegawai" class="form-control sc-input-required sc-select" value="<?php echo $li->JABATAN ?>">
                                        </div>
                                        <div class="col-6">
                                            <label>Tanggal Lahir</label>
                                            <input required type="text" name="tanggal" class="input-tanggal form-control sc-input-required sc-date " placeholder="Tanggal Lahir" value="<?php echo $li->TANGGALLAHIR ?>">
                                        </div>
                                        <div class="col-6">
                                            <label>Tingkat</label>
                                            <input required type="text" name="tingkat_pegawai" placeholder="Tingkat Pegawai" class="form-control sc-input-required sc-select" value="<?php echo $li->TINGKAT ?>">
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
    foreach ($list as $li) { ?>
        <div class="modal fade" id="hapusPegawai<?php echo $li->NIP ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">Apakah anda yakin menghapus pegawai tersebut?</h6>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Hapus <span style="color: blue"=><?php echo $li->NAMA ?></span> dari daftar pegawai</div>
                    <div class="modal-footer">

                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="<?= base_url('PegawaiController/hapusPegawai/' . $li->NIP); ?>">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    ?>
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
                    url: "<?php echo base_url(); ?>PegawaiController/fetchDataPegawai",
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
        var timeout = 4000; // in miliseconds (3*1000)

        $('.alert').delay(timeout).fadeOut(500);
    </script>