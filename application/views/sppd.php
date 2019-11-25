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
              <h6 class="m-0 font-weight-bold text-primary">SPPD</h6>
            </div>
            <div class="card-body">
              <div class="tab-pane active full-height" id="tab_1">
                <?php foreach ($list as $li) {
                  # code...
                  ?>
                  <form method="POST" role="form" action="<?php echo site_url('sppdController/updateSPPD'); ?>">
                    <div class="formsppd form-group">
                      <input type="hidden" name="id" value="<?php echo $li->ID_SPPD; ?>">
                      <label>Maksud perjalanan Dinas</label>
                      <p><?php echo $li->TUJUAN ?></p>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-7">
                          <label>Kegiatan</label>
                          <select required name="kegiatan" class="skegiatan form-control sc-input-required" id="select_kegiatan" onchange="getKegiatan()">
                            <option><?php echo $li->KODE?$li->KODE:(isset($_COOKIE['kegiatan'])?$_COOKIE['kegiatan']:"") ?></option>
                            <?php foreach ($kegiatan as $keg) {
                                echo "<option>" . $keg->NAMA_KEGIATAN . "</option>";
                              } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-4">
                          <label>Alat Angkut yang dipergunakan</label>
                          <select required name="alat_angkut" class="form-control sc-input-required" id="alat_angkut" onchange="getAlatAngkut()">
                          <option value="none" selected disabled hidden> 
                              <?php echo isset($_COOKIE['angkut'])?"Angkutan ".$_COOKIE['angkut']:"Pilih Jenis Angkutan" ?> 
                          </option>
                            <option value="Dinas" <?php echo $li->ALAT_ANGKUT=="Dinas"? "selected":" " ?>>Angkutan Dinas</option>
                            <option value="Umum" <?php echo $li->ALAT_ANGKUT=="Umum"? "selected":" " ?>>Angkutan Umum</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-3">
                          <label>Tempat Berangkat</label>
                          <input required type="text" onchange="getBerangkat()" id="tempat_berangkat" name="tempat_berangkat" class="form-control sc-input-required" value="<?php echo $li->TMP_BERANGKAT?$li->TMP_BERANGKAT:(isset($_COOKIE['berangkat'])?$_COOKIE['berangkat']:NULL); ?>" placeholder="Tempat Berangkat">
                        </div>
                        <div class="col-sm-3">
                          <label>Tempat Tujuan</label>
                          <input required type="text" onchange="getTujuan()" id="tempat_tujuan" name="tempat_tujuan" class="form-control sc-input-required" value="<?php echo $li->TMP_TUJUAN?$li->TMP_TUJUAN:(isset($_COOKIE['tujuan'])?$_COOKIE['tujuan']:NULL); ?>" placeholder="Tempat Tujuan">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-3">
                          <label>Tgl Berangkat</label>
                          <input required type="text" id="tgl_berangkat" onchange="getTglBerangkat()" name="tgl_berangkat" class="input-tanggal form-control sc-input-required sc-date" value="<?php echo $li->TGL_BERANGKAT?$li->TGL_BERANGKAT:(isset($_COOKIE['tglBerangkat'])?$_COOKIE['tglBerangkat']:NULL); ?>" placeholder="Tgl Berangkat">
                        </div>
                        <div class=" col-sm-3">
                          <label>Tgl Kembali</label>
                          <input required type="text" id="tgl_kembali" onchange="getTglKembali()" name="tgl_kembali" class="input-tanggal form-control sc-input-required sc-date" value="<?php echo $li->TGL_KEMBALI?$li->TGL_KEMBALI:(isset($_COOKIE['tglKembali'])?$_COOKIE['tglKembali']:NULL); ?>" placeholder="Tgl Kembali">
                        </div>
                      </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4" id="instansi">
                      <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Instansi Tujuan</h6>
                        <a href="" data-target="#modaltambah" data-toggle="modal" class="btn btn-info btn-icon-split">
                          <span class="icon text-white-50">
                            <i class="fas fa-sm fa-plus"></i>
                          </span>
                          <span class="text">Tambah Instansi Tujuan</span>
                        </a>
                      </div>

                      <div class="card-body">
                        <?= $this->session->flashdata('instansi'); ?>
                        <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <col width="10%">
                            <col width="30%">
                            <col width="30%">
                            <col width="20%">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Instansi Tujuan</th>
                                <th>Tanggal Berangkat</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $num = 1;
                                foreach ($instansi as $in) {
                                  echo "<tr><td>" . $num++ . "</td>
                                      <td>" . $in->INSTANSI . "</td>
                                      <td>" . $in->TANGGAL . "</td>
                                      <td>"
                                  ?>
                                <a href="" data-target="#modalhapus<?php echo $in->ID_INSTANSI; ?>" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-danger">
                                  <i class="fas fa-sm fa-trash"></i> Hapus
                                </a>
                                </td>
                                </tr>


                              <?php
                                }
                                ?>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-4">
                          <label>Kategori Dinas</label>
                          <select required name="kategori" class="form-control sc-input-required" id="select_kategori" onchange="getKategori()">
                            <option value="Dinas Dalam" <?php echo ($li->KATEGORI == 'Dinas Dalam') || isset($_COOKIE['kategori']) ? 'selected' : NULL; ?>>Dinas Dalam</option>
                            <option value="Dinas Luar" <?php echo ($li->KATEGORI == 'Dinas Luar') || isset($_COOKIE['kategori']) ? 'selected' : NULL; ?>>Dinas Luar</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-group">
                        <label>Keterangan Lain &nbsp;&nbsp;<small style="opacity:.7"><i>(optional)</i></small></label>
                        <input type="text" name="keterangan" id="keterangan" onkeyup="getKeterangan()" class="form-control" placeholder="Keterangan Lain" value="<?php echo $li->KETERANGAN?$li->KETERANGAN:(isset($_COOKIE['ket'])?$_COOKIE['ket']:NULL); ?>">
                      </div>
                      <input type="submit" onclick="simpan()" value="Simpan" class="btn btn-primary">
                  </form>
                <?php } ?>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        <!-- Modal Tambah Instansi-->
        <div class="modal fade " id="modaltambah" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="tab-pane active" id="tab_1">
                  <form method="POST" role="form" action="<?php echo site_url('sppdController/tambahInstansi'); ?>">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-8">
                          <input type="hidden" name="idst" value="<?php echo $list[0]->ID_ST; ?>">
                          <input type="hidden" name="idsppd" value="<?php echo $list[0]->ID_SPPD; ?>">
                        </div>
                      </div>
                    </div>

                    <div class="form-group input-group">
                      <div class="row">
                        <div class="col-sm-5">
                          <label>Instansi Tujuan</label>
                          <input type="text" required name="minstansi" class=" form-control sc-input-required">
                        </div>
                        <div class="col-sm-5">
                          <label>Tanggal</label>
                          <input type="date" required name="mtanggal" class="form-control sc-input-required">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                      <input type="submit" value="Simpan" class="btn btn-primary">
                    </div>
                  </form>
                </div>
                </button>
              </div>
            </div>
          </div>
        </div>
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

    <?php
    foreach ($instansi as $in) {
      ?>
      <div class="modal fade" id="modalhapus<?php echo $in->ID_INSTANSI; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data instansi?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Anda akan menghapus instansi <?php echo $in->INSTANSI; ?>.</div>
            <div class="modal-footer">
              <form method="post" action="<?php echo site_url('sppdController/hapusInstansi'); ?>">
                <input type="hidden" name="idinstansi" value="<?php echo $in->ID_INSTANSI; ?>">
                <input type="hidden" name="idst" value="<?php echo $list[0]->ID_ST; ?>">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <input type="submit" value="Hapus" class="btn btn-danger">
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
<?php
}
?>
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

</script>
<script>
  var src = ["Kab. Simeulue", "Kab. Aceh Singkil", "Kab. Aceh Selatan", "Kab. Aceh Tenggara", "Kab. Aceh Timur", "Kab. Aceh Tengah", "Kab. Aceh Barat", "Kab. Aceh Besar", "Kab. Pidie", "Kab. Bireuen", "Kab. Aceh Utara", "Kab. Aceh Barat Daya", "Kab. Gayo Lues", "Kab. Aceh Tamiang", "Kab. Nagan Raya", "Kab. Aceh Jaya", "Kab. Bener Meriah", "Kab. Pidie Jaya", "Kota Banda Aceh", "Kota Sabang", "Kota Langsa", "Kota Lhokseumawe", "Kota Subulussalam", "Kab. Nias", "Kab. Mandailing Natal", "Kab. Tapanuli Selatan", "Kab. Tapanuli Tengah", "Kab. Tapanuli Utara", "Kab. Toba Samosir", "Kab. Labuhan Batu", "Kab. Asahan", "Kab. Simalungun", "Kab. Dairi", "Kab. Karo", "Kab. Deli Serdang", "Kab. Langkat", "Kab. Nias Selatan", "Kab. Humbang Hasundutan", "Kab. Pakpak Bharat", "Kab. Samosir", "Kab. Serdang Bedagai", "Kab. Batu Bara", "Kab. Padang Lawas Utara", "Kab. Padang Lawas", "Kab. Labuhan Batu Selatan", "Kab. Labuhan Batu Utara", "Kab. Nias Utara", "Kab. Nias Barat", "Kota Sibolga", "Kota Tanjung Balai", "Kota Pematang Siantar", "Kota Tebing Tinggi", "Kota Medan", "Kota Binjai", "Kota Padangsidimpuan", "Kota Gunungsitoli", "Kab. Kepulauan Mentawai", "Kab. Pesisir Selatan", "Kab. Solok", "Kab. Sijunjung", "Kab. Tanah Datar", "Kab. Padang Pariaman", "Kab. Agam", "Kab. Lima Puluh Kota", "Kab. Pasaman", "Kab. Solok Selatan", "Kab. Dharmasraya", "Kab. Pasaman Barat", "Kota Padang", "Kota Solok", "Kota Sawah Lunto", "Kota Padang Panjang", "Kota Bukittinggi", "Kota Payakumbuh", "Kota Pariaman", "Kab. Kuantan Singingi", "Kab. Indragiri Hulu", "Kab. Indragiri Hilir", "Kab. Pelalawan", "Kab. S I A K", "Kab. Kampar", "Kab. Rokan Hulu", "Kab. Bengkalis", "Kab. Rokan Hilir", "Kab. Kepulauan Meranti", "Kota Pekanbaru", "Kota D U M A I", "Kab. Kerinci", "Kab. Merangin", "Kab. Sarolangun", "Kab. Batang Hari", "Kab. Muaro Jambi", "Kab. Tanjung Jabung Timur", "Kab. Tanjung Jabung Barat", "Kab. Tebo", "Kab. Bungo", "Kota Jambi", "Kota Sungai Penuh", "Kab. Ogan Komering Ulu", "Kab. Ogan Komering Ilir", "Kab. Muara Enim", "Kab. Lahat", "Kab. Musi Rawas", "Kab. Musi Banyuasin", "Kab. Banyu Asin", "Kab. Ogan Komering Ulu Selatan", "Kab. Ogan Komering Ulu Timur", "Kab. Ogan Ilir", "Kab. Empat Lawang", "Kota Palembang", "Kota Prabumulih", "Kota Pagar Alam", "Kota Lubuklinggau", "Kab. Bengkulu Selatan", "Kab. Rejang Lebong", "Kab. Bengkulu Utara", "Kab. Kaur", "Kab. Seluma", "Kab. Mukomuko", "Kab. Lebong", "Kab. Kepahiang", "Kab. Bengkulu Tengah", "Kota Bengkulu", "Kab. Lampung Barat", "Kab. Tanggamus", "Kab. Lampung Selatan", "Kab. Lampung Timur", "Kab. Lampung Tengah", "Kab. Lampung Utara", "Kab. Way Kanan", "Kab. Tulangbawang", "Kab. Pesawaran", "Kab. Pringsewu", "Kab. Mesuji", "Kab. Tulang Bawang Barat", "Kab. Pesisir Barat", "Kota Bandar Lampung", "Kota Metro", "Kab. Bangka", "Kab. Belitung", "Kab. Bangka Barat", "Kab. Bangka Tengah", "Kab. Bangka Selatan", "Kab. Belitung Timur", "Kota Pangkal Pinang", "Kab. Karimun", "Kab. Bintan", "Kab. Natuna", "Kab. Lingga", "Kab. Kepulauan Anambas", "Kota B A T A M", "Kota Tanjung Pinang", "Kab. Kepulauan Seribu", "Kota Jakarta Selatan", "Kota Jakarta Timur", "Kota Jakarta Pusat", "Kota Jakarta Barat", "Kota Jakarta Utara", "Kab. Bogor", "Kab. Sukabumi", "Kab. Cianjur", "Kab. Bandung", "Kab. Garut", "Kab. Tasikmalaya", "Kab. Ciamis", "Kab. Kuningan", "Kab. Cirebon", "Kab. Majalengka", "Kab. Sumedang", "Kab. Indramayu", "Kab. Subang", "Kab. Purwakarta", "Kab. Karawang", "Kab. Bekasi", "Kab. Bandung Barat", "Kab. Pangandaran", "Kota Bogor", "Kota Sukabumi", "Kota Bandung", "Kota Cirebon", "Kota Bekasi", "Kota Depok", "Kota Cimahi", "Kota Tasikmalaya", "Kota Banjar", "Kab. Cilacap", "Kab. Banyumas", "Kab. Purbalingga", "Kab. Banjarnegara", "Kab. Kebumen", "Kab. Purworejo", "Kab. Wonosobo", "Kab. Magelang", "Kab. Boyolali", "Kab. Klaten", "Kab. Sukoharjo", "Kab. Wonogiri", "Kab. Karanganyar", "Kab. Sragen", "Kab. Grobogan", "Kab. Blora", "Kab. Rembang", "Kab. Pati", "Kab. Kudus", "Kab. Jepara", "Kab. Demak", "Kab. Semarang", "Kab. Temanggung", "Kab. Kendal", "Kab. Batang", "Kab. Pekalongan", "Kab. Pemalang", "Kab. Tegal", "Kab. Brebes", "Kota Magelang", "Kota Surakarta", "Kota Salatiga", "Kota Semarang", "Kota Pekalongan", "Kota Tegal", "Kab. Kulon Progo", "Kab. Bantul", "Kab. Gunung Kidul", "Kab. Sleman", "Kota Yogyakarta", "Kab. Pacitan", "Kab. Ponorogo", "Kab. Trenggalek", "Kab. Tulungagung", "Kab. Blitar", "Kab. Kediri", "Kab. Malang", "Kab. Lumajang", "Kab. Jember", "Kab. Banyuwangi", "Kab. Bondowoso", "Kab. Situbondo", "Kab. Probolinggo", "Kab. Pasuruan", "Kab. Sidoarjo", "Kab. Mojokerto", "Kab. Jombang", "Kab. Nganjuk", "Kab. Madiun", "Kab. Magetan", "Kab. Ngawi", "Kab. Bojonegoro", "Kab. Tuban", "Kab. Lamongan", "Kab. Gresik", "Kab. Bangkalan", "Kab. Sampang", "Kab. Pamekasan", "Kab. Sumenep", "Kota Kediri", "Kota Blitar", "Kota Malang", "Kota Probolinggo", "Kota Pasuruan", "Kota Mojokerto", "Kota Madiun", "Kota Surabaya", "Kota Batu", "Kab. Pandeglang", "Kab. Lebak", "Kab. Tangerang", "Kab. Serang", "Kota Tangerang", "Kota Cilegon", "Kota Serang", "Kota Tangerang Selatan", "Kab. Jembrana", "Kab. Tabanan", "Kab. Badung", "Kab. Gianyar", "Kab. Klungkung", "Kab. Bangli", "Kab. Karang Asem", "Kab. Buleleng", "Kota Denpasar", "Kab. Lombok Barat", "Kab. Lombok Tengah", "Kab. Lombok Timur", "Kab. Sumbawa", "Kab. Dompu", "Kab. Bima", "Kab. Sumbawa Barat", "Kab. Lombok Utara", "Kota Mataram", "Kota Bima", "Kab. Sumba Barat", "Kab. Sumba Timur", "Kab. Kupang", "Kab. Timor Tengah Selatan", "Kab. Timor Tengah Utara", "Kab. Belu", "Kab. Alor", "Kab. Lembata", "Kab. Flores Timur", "Kab. Sikka", "Kab. Ende", "Kab. Ngada", "Kab. Manggarai", "Kab. Rote Ndao", "Kab. Manggarai Barat", "Kab. Sumba Tengah", "Kab. Sumba Barat Daya", "Kab. Nagekeo", "Kab. Manggarai Timur", "Kab. Sabu Raijua", "Kota Kupang", "Kab. Sambas", "Kab. Bengkayang", "Kab. Landak", "Kab. Pontianak", "Kab. Sanggau", "Kab. Ketapang", "Kab. Sintang", "Kab. Kapuas Hulu", "Kab. Sekadau", "Kab. Melawi", "Kab. Kayong Utara", "Kab. Kubu Raya", "Kota Pontianak", "Kota Singkawang", "Kab. Kotawaringin Barat", "Kab. Kotawaringin Timur", "Kab. Kapuas", "Kab. Barito Selatan", "Kab. Barito Utara", "Kab. Sukamara", "Kab. Lamandau", "Kab. Seruyan", "Kab. Katingan", "Kab. Pulang Pisau", "Kab. Gunung Mas", "Kab. Barito Timur", "Kab. Murung Raya", "Kota Palangka Raya", "Kab. Tanah Laut", "Kab. Kota Baru", "Kab. Banjar", "Kab. Barito Kuala", "Kab. Tapin", "Kab. Hulu Sungai Selatan", "Kab. Hulu Sungai Tengah", "Kab. Hulu Sungai Utara", "Kab. Tabalong", "Kab. Tanah Bumbu", "Kab. Balangan", "Kota Banjarmasin", "Kota Banjar Baru", "Kab. Paser", "Kab. Kutai Barat", "Kab. Kutai Kartanegara", "Kab. Kutai Timur", "Kab. Berau", "Kab. Penajam Paser Utara", "Kota Balikpapan", "Kota Samarinda", "Kota Bontang", "Kab. Malinau", "Kab. Bulungan", "Kab. Tana Tidung", "Kab. Nunukan", "Kota Tarakan", "Kab. Bolaang Mongondow", "Kab. Minahasa", "Kab. Kepulauan Sangihe", "Kab. Kepulauan Talaud", "Kab. Minahasa Selatan", "Kab. Minahasa Utara", "Kab. Bolaang Mongondow Utara", "Kab. Siau Tagulandang Biaro", "Kab. Minahasa Tenggara", "Kab. Bolaang Mongondow Selatan", "Kab. Bolaang Mongondow Timur", "Kota Manado", "Kota Bitung", "Kota Tomohon", "Kota Kotamobagu", "Kab. Banggai Kepulauan", "Kab. Banggai", "Kab. Morowali", "Kab. Poso", "Kab. Donggala", "Kab. Toli-toli", "Kab. Buol", "Kab. Parigi Moutong", "Kab. Tojo Una-una", "Kab. Sigi", "Kota Palu", "Kab. Kepulauan Selayar", "Kab. Bulukumba", "Kab. Bantaeng", "Kab. Jeneponto", "Kab. Takalar", "Kab. Gowa", "Kab. Sinjai", "Kab. Maros", "Kab. Pangkajene Dan Kepulauan", "Kab. Barru", "Kab. Bone", "Kab. Soppeng", "Kab. Wajo", "Kab. Sidenreng Rappang", "Kab. Pinrang", "Kab. Enrekang", "Kab. Luwu", "Kab. Tana Toraja", "Kab. Luwu Utara", "Kab. Luwu Timur", "Kab. Toraja Utara", "Kota Makassar", "Kota Parepare", "Kota Palopo", "Kab. Buton", "Kab. Muna", "Kab. Konawe", "Kab. Kolaka", "Kab. Konawe Selatan", "Kab. Bombana", "Kab. Wakatobi", "Kab. Kolaka Utara", "Kab. Buton Utara", "Kab. Konawe Utara", "Kota Kendari", "Kota Baubau", "Kab. Boalemo", "Kab. Gorontalo", "Kab. Pohuwato", "Kab. Bone Bolango", "Kab. Gorontalo Utara", "Kota Gorontalo", "Kab. Majene", "Kab. Polewali Mandar", "Kab. Mamasa", "Kab. Mamuju", "Kab. Mamuju Utara", "Kab. Maluku Tenggara Barat", "Kab. Maluku Tenggara", "Kab. Maluku Tengah", "Kab. Buru", "Kab. Kepulauan Aru", "Kab. Seram Bagian Barat", "Kab. Seram Bagian Timur", "Kab. Maluku Barat Daya", "Kab. Buru Selatan", "Kota Ambon", "Kota Tual", "Kab. Halmahera Barat", "Kab. Halmahera Tengah", "Kab. Kepulauan Sula", "Kab. Halmahera Selatan", "Kab. Halmahera Utara", "Kab. Halmahera Timur", "Kab. Pulau Morotai", "Kota Ternate", "Kota Tidore Kepulauan", "Kab. Fakfak", "Kab. Kaimana", "Kab. Teluk Wondama", "Kab. Teluk Bintuni", "Kab. Manokwari", "Kab. Sorong Selatan", "Kab. Sorong", "Kab. Raja Ampat", "Kab. Tambrauw", "Kab. Maybrat", "Kota Sorong", "Kab. Merauke", "Kab. Jayawijaya", "Kab. Jayapura", "Kab. Nabire", "Kab. Kepulauan Yapen", "Kab. Biak Numfor", "Kab. Paniai", "Kab. Puncak Jaya", "Kab. Mimika", "Kab. Boven Digoel", "Kab. Mappi", "Kab. Asmat", "Kab. Yahukimo", "Kab. Pegunungan Bintang", "Kab. Tolikara", "Kab. Sarmi", "Kab. Keerom", "Kab. Waropen", "Kab. Supiori", "Kab. Mamberamo Raya", "Kab. Nduga", "Kab. Lanny Jaya", "Kab. Mamberamo Tengah", "Kab. Yalimo", "Kab. Puncak", "Kab. Dogiyai", "Kab. Intan Jaya", "Kab. Deiyai", "Kota Jayapura"]
  
  function simpan(){
    document.cookie = "kegiatan=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "angkut=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "berangkat=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "tujuan=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "tglBerangkat=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "tglKembali=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "kategori=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    document.cookie = "ket=; expires=Thu, 01 Jan 1970 00:00:00 UTC";

  }
  function getKegiatan(){
    document.cookie="kegiatan="+document.getElementById("select_kegiatan").value;
  }

  function getAlatAngkut(){
    document.cookie="angkut="+document.getElementById("alat_angkut").value;
  }

  function getBerangkat(){
    document.cookie="berangkat="+document.getElementById("tempat_berangkat").value;
  }

  function getTujuan(){
    document.cookie="tujuan="+document.getElementById("tempat_tujuan").value;
  }

  function getTglBerangkat(){
    document.cookie="tglBerangkat="+document.getElementById("tgl_berangkat").value;
  }

  function getTglKembali(){
    document.cookie="tglKembali="+document.getElementById("tgl_kembali").value;
  }

  function getKategori(){
    document.cookie="kategori="+document.getElementById("select_kategori").value;
  }

  function getKeterangan(){
    document.cookie="ket="+document.getElementById("keterangan").value;
  }

  $("#tempat_berangkat").autocomplete({
    source: function(request, response) {
      var results = $.ui.autocomplete.filter(src, request.term);

      response(results.slice(0, 10));
    }
  });
  $("#tempat_tujuan").autocomplete({
    source: function(request, response) {
      var results = $.ui.autocomplete.filter(src, request.term);

      response(results.slice(0, 10));
    }
  });
  $('.skegiatan').select2({
    placeholder: "Input Bidang",
    dropdownParent: $('.formsppd'),
    width: '100%',
  });

  if (window.location.hash) {
    var hash = window.location.hash;

    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 1500, 'swing');
  }
  var timeout = 4000; // in miliseconds (3*1000)

  $('.alert').delay(timeout).fadeOut(500);
</script>

</html>