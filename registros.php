<!DOCTYPE html>
<html lang="en">
<?php

  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/controllers/ctrlTicker.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/book.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/tick.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/includes/settings.php";

  $current_book = isset($_GET['book']) ? $_GET['book'] : $ALL_BOOKS;
  $exploded_book = explode("_", $current_book);
  $table_title = 'Ticks registrados'. (isset($_GET['book']) ? ' '.$exploded_book[0].'/'.$exploded_book[1] : ' TODOS LOS MERCADOS');

  $current_tick = null;

  $arrayLastTicks = getLastTicks();
  foreach ($arrayLastTicks as $tick) {
    if ($tick->book == $current_book) {
      $current_tick = $tick;
      break;
    }
  }
 ?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Digitable Trading - Registros</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/datatables.min.css" rel="stylesheet">

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

        <!-- Topbar -->
        <?php include_once "topbar.php"; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <?php echo '<input type="hidden" id="current_book" value="'.$current_book.'"></input>';?>

          <!-- Page Heading -->

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-info text-uppercase"><?php echo $table_title; ?></h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-chevron-down fa-sm fa-fw text-info"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header text-info">Registros disponibles:</div>
                  <a class="dropdown-item" href="tables.php">Todos los mercados</a>
                  <?php
                  foreach ($arrayLastTicks as $tick) {
                    $cambio = explode("_", $tick->book);
                    echo '<a class="dropdown-item text-uppercase" href="tables.php?book='.$tick->book.'">'.$cambio[0].' / '.$cambio[1].'</a>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-primary text-xs text-center text-uppercase">Tick ID</th>
                      <th class="text-primary text-xs text-center text-uppercase">Último</th>
                      <th class="text-primary text-xs text-center text-uppercase">Mercado</th>
                      <th class="text-primary text-xs text-center text-uppercase">Máximo</th>
                      <th class="text-primary text-xs text-center text-uppercase">Mínimo</th>
                      <th class="text-primary text-xs text-center text-uppercase">Compra</th>
                      <th class="text-primary text-xs text-center text-uppercase">Venta</th>
                      <th class="text-primary text-xs text-center text-uppercase">Ponderado</th>
                      <th class="text-primary text-xs text-center text-uppercase">Volumen</th>
                      <th class="text-primary text-xs text-center text-uppercase">Fecha y hora</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-800 text-xs text-center"> </tbody>
                </table>
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
  <script src="vendor/datatables/datatables.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/data/datatable-ticks.js"></script>

</body>

</html>
