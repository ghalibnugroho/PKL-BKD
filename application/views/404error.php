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

                        <div class="container-fluid ">

                            <!-- 404 Error Text -->
                            <div class="text-center ">
                                <div class="error mx-auto" data-text="404">404</div>
                                <p class="lead text-gray-800 mb-5">Page Not Found</p>
                                <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
                                <a href="index.html">&larr; Back to Dashboard</a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->

            </div>
            <!-- Footer-->
            <?php $this->load->view("templates/auth_footer") ?>
            <!-- End of Footer -->

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
                adminBarGraphic();
                adminPieGraphic();
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
            function adminBarGraphic() {
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
            function adminPieGraphic() {
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