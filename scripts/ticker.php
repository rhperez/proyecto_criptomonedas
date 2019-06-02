<?php

  include_once "../includes/settings.php";
  include_once "../controllers/ctrlTicker.php";
  include_once "../classes/tick.php";

  $URL_BASE = $PRODUCCION==1 ? $URL_PRODUCCION : $URL_PRUEBAS;

  /**
   *  Obtiene un tick y lo almacena en la base de datos
   *
   *  @param string $url_base la url desde donde se obtiene el tick
   *  @param int produccion 1 si esta habilitado en produccion, 2 si es en pruebas
   *  @param string $book el book desde el que se generara el tick
   */
  function tickerBitso($url_base, $produccion, $book) {
    $url = $url_base."ticker/?book=".$book;
    // Se genera la peticion
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error_code = '';
    $error_message = '';

    if (!$response) {   // Si no hay respuesta se genera un tick vacio con error 400
      $status = 0;
      echo "No se obtuvo respuesta del servidor.";
      $error_code = '400';
      $error_message = 'No hay respuesta del servidor';
      $tick = new Tick($book, '', '', '', '', '', '', '', '', $status);
    }
    $json = json_decode($response);   // Guarda la respuesta en un json
    if ($json->success) {   // Se obtuvo el tick sin problemas
      echo 'Respuesta exitosa!';
      $error_code = '0';
      $error_message = '';
      $tick = new Tick($json->payload->book, $json->payload->volume, $json->payload->last, $json->payload->high, $json->payload->low,
      $json->payload->vwap, $json->payload->ask, $json->payload->bid, $json->payload->created_at, $produccion);
      //sendNotifications($book, $max_to_sell, $min_to_buy, $json->payload->last, $recipient);
    } else {  // Se genero un error desde el servidor
      $status = 3;
      echo '<br>Error del servidor<br>';
      echo $json->error->message;
      $error_code = $json->error->code;
      $error_message = $json->error->message;
      $tick = new Tick($book, '', '', '', '', '', '', '', '', $status);
    }
    insertTick($tick, $error_code, $error_message);   // Almacena el tick
    curl_close($ch);
  }


  tickerBitso($URL_BASE, $PRODUCCION, 'btc_mxn');
  tickerBitso($URL_BASE, $PRODUCCION, 'eth_mxn');
  tickerBitso($URL_BASE, $PRODUCCION, 'xrp_mxn');
  tickerBitso($URL_BASE, $PRODUCCION, 'ltc_mxn');

?>
