<!DOCTYPE html>
<html lang="en">
<?php

  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/controllers/ctrlTicker.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/book.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/tick.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/includes/settings.php";

  $current_book = isset($_GET['book']) ? $_GET['book'] : $DEFAULT_BOOK;
  $exploded_book = explode("_", $current_book);
  $current_tick = null;

  $arrayLastTicks = getLastTicks();
  foreach ($arrayLastTicks as $tick) {
    if ($tick->book == $current_book) {
      $current_tick = $tick;
      break;
    }
  }

  $tick_date = new DateTime($tick->created_at);

 ?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Proyecto Criptomonedas - Panel de Control</title>

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
    <?php readfile("sidebar.html"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php echo '<input type="hidden" id="current_book" value="'.$current_book.'"></input>';?>

        <!-- Topbar -->
        <?php readfile("topbar.html"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="mb-1 text-xs text-right">Último tick recibido: <?php echo $tick_date->format('d/m/y H:i:s'); ?></div>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-info text-uppercase font-weight-bold"><?php echo $exploded_book[0]." / ".$exploded_book[1]; ?></h1>
            <div class="dropdown no-arrow">
              <button class="btn btn-info btn-icon-split dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon text-white-50">
                  <i class="fas fa-coins"></i>
                </span>
                <span class="text">Mercados disponibles</span>
              </button>
              <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="width:220px;">
                <?php
                foreach ($arrayLastTicks as $tick) {
                  $cambio = explode("_", $tick->book);
                  echo '<a class="dropdown-item" href="index.php?book='.$tick->book.'">';
                    echo '<div class="row">';
                      echo '<div class="col-md-4 text-s font-weight-bold text-info text-uppercase mb-1" style="text-align:left;">';
                        echo $cambio[0];
                      echo '</div>';
                      echo '<div class="col-md-8 text-s text-uppercase mb-1" style="text-align:right;">';
                        echo '$'.number_format($tick->last, 2)." ".$cambio[1];
                      echo '</div>';
                    echo '</div>';
                  echo '</a>';
                }
                ?>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Último precio -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-1">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="font-weight-bold text-primary text-uppercase mb-1">Último precio</div>
                      <div class="h6 mb-0 font-weight-bold text-uppercase text-gray-800"><?php echo '1 '.$exploded_book[0].' = $'.number_format($current_tick->last, 2).' '.$exploded_book[1];?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Precios Máximo y Mínimo -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-1">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col-4">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-2">Máximo</div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-2">Mínimo</div>
                    </div>
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800 mb-2"><?php echo '$'.number_format($current_tick->high, 2);?></div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800 mb-2"><?php echo '$'.number_format($current_tick->low, 2);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-arrows-alt-v fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Precios de Compra y Venta -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-1">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col-4">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Compra</div>
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Venta</div>
                    </div>
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800 mb-2"><?php echo '$'.number_format($current_tick->ask, 2);?></div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800 mb-2"><?php echo '$'.number_format($current_tick->bid, 2);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments-dollar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-1">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col-4">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">Volumen</div>
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">VWAP</div>
                    </div>
                    <div class="col mr-2">
                      <div class="h6 mb-0 font-weight-bold text-gray-800 mb-2"><?php echo number_format($current_tick->volume, 2);?></div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800 mb-2"><?php echo '$'.number_format($current_tick->vwap, 2);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-box fa-2x text-gray-300 text-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-9 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-info text-uppercase"><?php echo $exploded_book[0].' / '.$exploded_book[1];?> precios últimas horas</h6>
                  <div class="row">

                    <div class="col-6">
                      <div class="dropdown no-arrow">
                        <button class="btn btn-info btn-icon-split btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="icon text-white-50">
                            <i class="far fa-calendar"></i>
                          </span>
                          <span class="text">Periodos</span>
                        </button>
                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">

                        </div>
                      </div>
                    </div>
                  </div>
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
            <div class="col-xl-3 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
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
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">
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

  <!-- Page level custom scripts -->
  <script src="js/charts/main-chart.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

  <script type="text/javascript">
    var current_book = 'BTC_MXN';
    var interval = '1 DAY';

    jQuery(document).ready(function($) {
      loadData($("#current_book").val(), '1DAY');
    });

    function selectBook(book) {
      current_book = book;
      $("#header_book").text(current_book.toUpperCase());
    }
  </script>

</body>

</html>
