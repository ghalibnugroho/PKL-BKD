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

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <?php
            if ($this->session->userdata('priority') == 1) {
              foreach ($total_pegawai as $tp) { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <a style="text-decoration:none;" href=" <?php echo site_url('daftar-pegawai'); ?>">
                    <div class="card border-left-danger shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pegawai BKD</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tp->total_pegawai ?> Pegawai </div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              <?php } ?>
              <!-- Earnings (Monthly) Card Example -->
              <?php
                foreach ($total_kegiatan as $tk) { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <a style="text-decoration:none;" href=" <?php echo site_url('daftar-kegiatan'); ?>">
                    <div class="card border-left-info shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Jenis Kegiatan BKD</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tk->total_kegiatan ?>Jenis Kegiatan</div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-flag fa-2x text-gray-300"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              <?php }
                foreach ($total_st as $st) { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Surat Tugas</div>
                          <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $st->total_st ?> Surat Tugas</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <!-- Pending Requests Card Example -->
              <?php
                foreach ($total_sppd as $sppd) { ?>
                <div class="col-xl-3 col-md-6 mb-4">
                  <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Surat Perintah Perjalanan Dinas</div>
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sppd->total_sppd ?> SPPD</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        <?php }
        } else {
          foreach ($total_pegawai as $tp) { ?>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pegawai BKD</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tp->total_pegawai ?> Pegawai</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }
          ?>
        <!-- Earnings (Monthly) Card Example -->
        <?php
          foreach ($total_kegiatan as $tk) { ?>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Jenis Kegiatan BKD</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tk->total_kegiatan ?> Jenis Kegiatan</div>
                  </div>
                  <div class="col-auto">
                    <i class="fa fa-flag fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }
          foreach ($total_stBidang as $st) { ?>
          <div class="col-xl-3 col-md-6 mb-4">
            <a style="text-decoration:none;" href=" <?php echo site_url('list-st'); ?>">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Surat Tugas</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $st->jumlah_st ?> Surat Tugas</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php }
          foreach ($total_sppdBidang as $sppd) { ?>
          <div class="col-xl-3 col-md-6 mb-4">
            <a style="text-decoration:none;" href=" <?php echo site_url('list-sppd'); ?>">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Surat Perintah Perjalanan Dinas</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $sppd->jumlah_sppd ?> SPPD</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
    <?php }
    } ?>
    <!-- Earnings (Monthly) Card Example -->

    <!-- Content Row -->

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-success">Jumlah Keberangkatan Dinas</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <div class="chart-area">
              <canvas id="myAreaChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-warning">Surat Perintah Perjalanan Dinas</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
              <canvas id="myPieChart"></canvas>
              <p id="message_pie" style="color: black; text-align: center; padding-top: 70px; font-size: 20px; font-weight: bold;"></p>
            </div>
            <div class="mt-4 text-center small">
              <span class="mr-2">
                <i class="fas fa-circle text-warning"></i> Dinas Dalam
              </span>
              <span class="mr-2">
                <i class="fas fa-circle text-danger"></i> Dinas Luar
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->


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

  <script>
    //suratTugas
    <?php
    $a = [];
    $b = [];
    $c = [];
    //looping graphic label
    if ($this->session->userdata('priority') == 1) {
      foreach ($label_graphic as $bt) {
        $a[] = $bt['bulan_tahun'];
      }
      foreach ($value_count as $vc) {
        $b[] = $vc['jumlah_sppd'];
      }
      foreach ($total_sppd_kat_dinas_luar as $total) {
        $c[] +=  $total->dinas_luar;
      }
      foreach ($total_sppd_kat_dinas_dalam as $total) {
        $c[] +=  $total->dinas_dalam;
      }
    } else {
      foreach ($label_graphic_user as $bt) {
        $a[] = $bt['bulan_tahun'];
      }
      foreach ($value_count_user as $vc) {
        $b[] = $vc['jumlah_sppd'];
      }
      foreach ($total_sppd_dinas_dalam_bidang as $total) {
        $c[] += $total->dinas_dalam;
      }
      foreach ($total_sppd_dinas_luar_bidang as $total) {
        $c[] += $total->dinas_luar;
      }
      $c = array_reverse($c);
    }

    ?>
    let a = <?php echo json_encode($a); ?>; //label
    let b = <?php echo json_encode($b); ?>;
    let c = <?php echo json_encode($c); ?>; //data
    var message_pie = document.getElementById('message_pie');
    <?php
    if ($this->session->userdata('priority') == 1) { ?>
      BarGraphic();
      if (c[0] == 0 && c[1] == 0) {
        $('#myPieChart').remove();
        message_pie.innerHTML = "Chart values is Empty";
      } else {
        PieGraphic();
      }
    <?php } else if ($this->session->userdata('priority') == 2) { ?>
      BarGraphic();
      if (c[0] == 0 && c[1] == 0) {
        $('#myPieChart').remove();
        message_pie.innerHTML = "Chart values is Empty";
      } else {
        PieGraphic();
      }
    <?php } ?>

    function addData(chart, label, data) {
      chart.data.labels.push(label);
      chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
      });
      chart.update();
    }

    function removeData(chart) {
      chart.data.labels.pop();
      chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
      });
      chart.update();
    }

    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    // Area Chart Example
    function BarGraphic() {
      var ctx = document.getElementById("myAreaChart");
      var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: a,
          datasets: [{
            label: "Surat Perintah Perjalanan Dinas",
            lineTension: 0.3,
            backgroundColor: "rgb(32, 172, 134)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: b,
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                beginAtZero: true
                // Include a dollar sign in the ticks

              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return tooltipItem.yLabel + " " + datasetLabel;
              }
            }
          }
        }
      });
    }
    //sppd
    function PieGraphic() {
      Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#858796';

      // Pie Chart Example
      var ctx = document.getElementById("myPieChart");
      var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ["Dinas Luar", "Dinas Dalam"],
          datasets: [{
            data: c,
            backgroundColor: ['#e74a3b', '#f6c23e'],
            hoverBackgroundColor: ['#17a673', '#17a673'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: false
          },
          cutoutPercentage: 80,
        },
      });
    }
  </script>



</body>

</html>