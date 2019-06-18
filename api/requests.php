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
      echo buildJsonTicksResponse(getTicksIntervalo($_GET['book'], $_GET['intervalo']));
      break;
    case 'getTicksTable':
      if (!isset($_GET['book'])) {
        echo buildJsonTicksTable(getTicks());
      } else {
        echo buildJsonTicksTable(getTicks($_GET['book']));
      }
      break;
    case 'getOpenTicks':
      if (!isset($_GET['book'])) {
        echo buildJsonOpenTicks(getOpenTicks());
      } else {
        echo buildJsonOpenTicks(getOpenTicks($_GET['book']));
      }
      break;
    case 'getOpenTicksTable':
      if (!isset($_GET['book'])) {
        echo buildJsonOpenTicksTable(getOpenTicks());
      } else {
        echo buildJsonOpenTicksTable(getOpenTicks($_GET['book']));
      }
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
  function buildJsonTicksResponse($arrayTicks) {
    if (!$arrayTicks) {
      $json_ticks = json_encode(array('response' => 'error', 'error_message' => 'No se devolvieron ticks.'));
    } else {
      $json_ticks = json_encode(array('response' => 'success', 'data' => $arrayTicks));
    }
    return $json_ticks;
  }

  /**
   *  Construye un json de respuesta para un request de ticks para una tabla
   *
   *  @param array Tick : el arreglo de ticks a devolver
   *  @return string json: el json de respuesta.
   */
  function buildJsonTicksTable($arrayTicks) {

    $arrayTicksTable = array();
    foreach ($arrayTicks as $tick) {
      $arrayTicksTable[] = array($tick->id, $tick->book, '$'.number_format($tick->last, 2), '$'.number_format($tick->high, 2), '$'.number_format($tick->low, 2), '$'.number_format($tick->bid, 2), '$'.number_format($tick->ask, 2), '$'.number_format($tick->vwap, 2), number_format($tick->volume, 2), $tick->created_at);
    }
    return json_encode(array('data' => $arrayTicksTable));
  }

  /**
   *  Construye un json de respuesta para un request de ticks de apertura y cierre
   *
   *  @param array Tick : el arreglo de ticks a devolver
   *  @return string json: el json de respuesta.
   */
  function buildJsonOpenTicks($arrayTicks) {
    $arrayTicksTable = array();
    $open = $arrayTicks[0]->last;
    $high = $arrayTicks[0]->high;
    $low = $arrayTicks[0]->low;
    $close = 0;
    $date = new DateTime($arrayTicks[0]->created_at);
    for ($i = 1; $i < sizeof($arrayTicks)- 1 ; $i++) {
      $close = $arrayTicks[$i]->last;
      $arrayTicksTable[] = array('open'=>$open, 'high'=>$high, 'low'=>$low, 'close'=>$close, 'date'=>$date->format('Y-m-d'));
      $open = $arrayTicks[$i]->last;
      $high = $arrayTicks[$i]->high;
      $low = $arrayTicks[$i]->low;
      $close = 0;
      $date = new DateTime($arrayTicks[$i]->created_at);
    }
    //$close = $arrayTicks[++$i]->last;
    //$arrayTicksTable[] = array('$'.number_format($open, 2), '$'.number_format($high, 2), '$'.number_format($low, 2), '$'.number_format($close, 2), $date);
    return json_encode(array('data' => $arrayTicksTable));
  }

  /**
   *  Construye un json de respuesta para un request de ticks de apertura y cierre para una tabla
   *
   *  @param array Tick : el arreglo de ticks a devolver
   *  @return string json: el json de respuesta.
   */
  function buildJsonOpenTicksTable($arrayTicks) {
    $arrayTicksTable = array();
    $open = $arrayTicks[0]->last;
    $high = $arrayTicks[0]->high;
    $low = $arrayTicks[0]->low;
    $close = 0;
    $date = new DateTime($arrayTicks[0]->created_at);
    for ($i = 1; $i < sizeof($arrayTicks)- 1 ; $i++) {
      $close = $arrayTicks[$i]->last;
      if ($close > $open) {
        $variacionPCent = number_format((($close / $open) - 1) * 100, 2);
      } else {
        $variacionPCent = "-".number_format((($open / $close) - 1) * 100, 2);
      }

      $arrayTicksTable[] = array('$'.number_format($open, 2), '$'.number_format($high, 2), '$'.number_format($low, 2), '$'.number_format($close, 2), $variacionPCent, $date->format('d/m/Y'));
      $open = $arrayTicks[$i]->last;
      $high = $arrayTicks[$i]->high;
      $low = $arrayTicks[$i]->low;
      $close = 0;
      $date = new DateTime($arrayTicks[$i]->created_at);
    }
    //$close = $arrayTicks[++$i]->last;
    //$arrayTicksTable[] = array('$'.number_format($open, 2), '$'.number_format($high, 2), '$'.number_format($low, 2), '$'.number_format($close, 2), $date);
    return json_encode(array('data' => $arrayTicksTable));
  }

 ?>
