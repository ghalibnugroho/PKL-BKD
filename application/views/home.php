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
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Kegiatan BKD</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tk->total_kegiatan ?> Kegiatan</div>
                          </div>
                          <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                          <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Kegiatan BKD</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tk->total_kegiatan ?> Kegiatan</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
      <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

          <!-- Project Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
            </div>
            <div class="card-body">
              <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
              <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
              <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>

          <!-- Color System -->
          <div class="row">
            <div class="col-lg-6 mb-4">
              <div class="card bg-primary text-white shadow">
                <div class="card-body">
                  Primary
                  <div class="text-white-50 small">#4e73df</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card bg-success text-white shadow">
                <div class="card-body">
                  Success
                  <div class="text-white-50 small">#1cc88a</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card bg-info text-white shadow">
                <div class="card-body">
                  Info
                  <div class="text-white-50 small">#36b9cc</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card bg-warning text-white shadow">
                <div class="card-body">
                  Warning
                  <div class="text-white-50 small">#f6c23e</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card bg-danger text-white shadow">
                <div class="card-body">
                  Danger
                  <div class="text-white-50 small">#e74a3b</div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                  Secondary
                  <div class="text-white-50 small">#858796</div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="col-lg-6 mb-4">

          <!-- Illustrations -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
            </div>
            <div class="card-body">
              <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="assets/img/undraw_posting_photo.svg" alt="">
              </div>
              <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
              <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw &rarr;</a>
            </div>
          </div>

          <!-- Approach -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
            </div>
            <div class="card-body">
              <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>
              <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>
            </div>
          </div>

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

  <script>
    //suratTugas
    <?php
    $a = [];
    $b = [];
    //looping graphic label
    if ($this->session->userdata('priority') == 1) {
      foreach ($label_graphic as $bt) {
        $a[] = $bt['bulan_tahun'];
      }
      foreach ($value_count as $vc) {
        $b[] = $vc['jumlah_sppd'];
      }
    }

    ?>
    let a = <?php echo json_encode($a); ?>; //label
    let b = <?php echo json_encode($b); ?>; //data
    <?php
    if ($this->session->userdata('priority') == 1) { ?>
      BarGraphic();
      PieGraphic();
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
            data: [<?php foreach ($total_sppd_kat_dinas_luar as $total) {
                      echo $total->dinas_luar;
                    } ?>, <?php foreach ($total_sppd_kat_dinas_dalam as $total) {
                            echo $total->dinas_dalam;
                          } ?>],
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