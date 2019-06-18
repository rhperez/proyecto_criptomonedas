<!DOCTYPE html>
<html lang="en">
<?php

  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/controllers/ctrlTicker.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/book.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/tick.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/includes/settings.php";

  $current_book = isset($_GET['book']) ? $_GET['book'] : $DEFAULT_BOOK;
  $current_chart = isset($_GET['chart']) ? $_GET['chart'] : $DEFAULT_CHART;
  $exploded_book = explode("_", $current_book);
  $current_tick = null;

  $arrayLastTicks = getLastTicks();
  foreach ($arrayLastTicks as $tick) {
    if ($tick->book == $current_book) {
      $current_tick = $tick;
      break;
    }
  }

  $arrayOpenTicks = getOpenTicks($current_book);
  $open_tick = $arrayOpenTicks[sizeof($arrayOpenTicks) - 1];
  $close_tick = $current_tick;

  $tick_date = new DateTime($tick->created_at);

 ?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Digitable Trading - Gráficas</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include_once "sidebar.php"; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php echo '<input type="hidden" id="current_book" value="'.$current_book.'"></input>';?>
        <?php echo '<input type="hidden" id="current_chart" value="'.$current_chart.'"></input>';?>

        <!-- Topbar -->
        <?php include_once "topbar.php"; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Gráficas</h1>
          <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in this theme. The charts below have been customized - for further customization options, please visit the <a target="_blank" href="https://www.chartjs.org/docs/latest/">official Chart.js documentation</a>.</p>

          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-12 col-lg-7">

              <?php
                switch ($current_chart) {

                  case 'CANDLE':
                  ?>
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Candlestick Chart</h6>
                    </div>
                    <div class="card-body">
                      <div class="chart-bar">
                        <div id="chartdiv"></div>
                      </div>
                      <hr>
                      Styling for the bar chart can be found in the <code>/js/demo/chart-bar-demo.js</code> file.
                    </div>
                  </div>
                  <?php
                    break;
                    case '1DAY':
                    default:
                    ?>
                    <div class="card shadow mb-4">
                      <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
                      </div>
                      <div class="card-body">
                        <div class="chart-area">
                          <canvas id="myAreaChart"></canvas>
                        </div>
                        <hr>
                        Styling for the area chart can be found in the <code>/js/demo/chart-area-demo.js</code> file.
                      </div>
                    </div>
                    <?php
                    break;
                  }
                  ?>
              <!-- Area Chart -->


            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
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
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <!-- Graphs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment-with-locales.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/es.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

  <!-- Resources amcharts-->
  <script src="https://www.amcharts.com/lib/4/core.js"></script>
  <script src="https://www.amcharts.com/lib/4/charts.js"></script>
  <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

  <!-- Graficas -->
  <script src="js/charts/main-chart.js"></script>
  <script src="js/charts/candlestick-chart.js"></script>

  <script type="text/javascript">
    var current_book = 'BTC_MXN';
    var interval = '1DAY';

    jQuery(document).ready(function($) {
      switch ($("#current_chart").val()) {
        case 'CANDLE':
          loadCandle();
          break;
        case '1DAY':
        default:
          loadMain($("#current_book").val(), '1DAY');
          break;
      }


    });

  </script>

  <style>
    #chartdiv {
      width: 100%;
      height: 100%;
    }
  </style>

</body>

</html>
