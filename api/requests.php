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
      echo buildJSONTicksResponse(getTicks($_GET['book'], $_GET['intervalo']));
      break;
  }

  /**
   *  Construye un json de respuesta para un request de ticks
   *
   *  @param array Tick : el arreglo de ticks a devolver
   *  @return string json: el json de respuesta.
   *  Si el arreglo de ticks es valido, devuelve response:success, y data:arrayTicks,
   *  en otro caso devuelve un json de error con response:error
   */
  function buildJSONTicksResponse($arrayTicks) {
    if (!$arrayTicks) {
      $json_ticks = json_encode(array('response' => 'error', 'error_message' => 'No se devolvieron ticks.'));
    } else {
      $json_ticks = json_encode(array('response' => 'success', 'data' => $arrayTicks));
    }
    return $json_ticks;
  }

 ?>
