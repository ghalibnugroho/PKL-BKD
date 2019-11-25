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
          <?= $this->session->flashdata('message'); ?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar SPPD</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <col width="12%">
                  <col width="30%">
                  <col width="10%">
                  <col width="10%">
                  <col width="10%">
                  <col width="10%">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Maksud</th>
                      <th>Kab/Kota Tujuan</th>
                      <th>Tanggal Berangkat</th>
                      <th>Tanggal Kembali</th>
                      <th>Kateogri</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($list as $li) {
                      echo "<tr style='font-size:13px;'>
                            <td>" . $li->NAMA . "</td>
                            <td>" . $li->DASAR . "</td>
                            <td>" . $li->TMP_TUJUAN . " </td>
                            <td>" . $li->TGL_BERANGKAT . "</td>
                            <td>" . $li->TGL_KEMBALI . "</td>
                            <td>" . $li->KATEGORI. "</td>";
                      if (($li->TMP_TUJUAN == null) && ($li->TGL_KEMBALI == null) && ($li->TGL_BERANGKAT == null)) {
                        echo "<td><a href=\"" . site_url("sppd/") . $li->ID_ST . "\" class=\"d-none d-sm-inline-block btn btn-sm btn-success\"><i class=\"fas fa-sm fa-pencil\"></i> Buat SPPD </a>
                            </tr>";
                      } else {
                        echo "<td><a href=\"" . site_url("sppd/") . $li->ID_ST . "\" class=\"d-none d-sm-inline-block btn btn-sm btn-info\"><i class=\"fas fa-sm fa-edit\"></i> Edit </a>
                              <a href=\"" . site_url("unduh-sppd/") . $li->ID_SPPD . "\" class=\"d-none d-sm-inline-block btn btn-sm btn-success\" target=\"_blank\"><i class=\"fas fa-sm fa-download\" ></i> Unduh </a>
                            </td></tr>";
                      }
                    }
                    ?>

                  </tbody>
                </table>
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





</body>

</html>
<script>
  $(document).ready( function () {
    $('#dataTable').DataTable();
  } );
  var timeout = 4000; // in miliseconds (3*1000)

  $('.alert').delay(timeout).fadeOut(500);
</script>