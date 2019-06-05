<?php

  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/tick.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/book.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/controllers/ctrlTicker.php";

  if (!isset($_GET['accion'])) {
    die();
  }

  switch ($_GET['accion']) {
    case 'getTicks':
      if (!isset($_GET['book']) || !isset($_GET['intervalo'])) {
        die();
      }
      echo json_encode(getTicks($_GET['book'], $_GET['intervalo']));
      break;
  }

 ?>
