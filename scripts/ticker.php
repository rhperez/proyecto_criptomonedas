<?php

  include_once "../includes/settings.php";
  include_once "../controllers/ctrlTicker.php";
  include_once "../classes/tick.php";

  $URL_BASE = $PRODUCCION==1 ? $URL_PRODUCCION : $URL_PRUEBAS;

  function tickerBitso($url_base, $produccion, $book) {
    $url = $url_base."ticker/?book=".$book;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $tick;

    if (!$response) {
      $status = 0;
      echo "No se obtuvo respuesta del servidor.";
      $tick = new Tick($book, '', '', '', '', '', '', '', '', $status);
      insertTick($tick, '400', 'No hay respuesta del servidor');
    }
    $json = json_decode($response);
    if ($json->success) {
      echo 'Success!';
      $tick = new Tick($json->payload->book, $json->payload->volume, $json->payload->last, $json->payload->high, $json->payload->low,
      $json->payload->vwap, $json->payload->ask, $json->payload->bid, $json->payload->created_at, $produccion);
      insertTick($tick, '0', '');
      //sendNotifications($book, $max_to_sell, $min_to_buy, $json->payload->last, $recipient);
    } else {
      $status = 3;
      echo '<br>Fail!<br>';
      echo $json->error->message;
      $tick = new Tick($book, '', '', '', '', '', '', '', '', $status);
      insertTick($tick, $json->error->code, $json->error->message);
    }
    curl_close($ch);
  }


  tickerBitso($URL_BASE, $PRODUCCION, 'btc_mxn');
  tickerBitso($URL_BASE, $PRODUCCION, 'eth_mxn');
  tickerBitso($URL_BASE, $PRODUCCION, 'xrp_mxn');
  tickerBitso($URL_BASE, $PRODUCCION, 'ltc_mxn');

?>
