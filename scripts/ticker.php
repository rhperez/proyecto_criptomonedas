<?php

  include_once "connections/conn.php";
  include_once "includes/settings.php";

  $URL_PRUEBAS = "https://api-dev.bitso.com/v3/";
  $URL_PRODUCCION = "https://api.bitso.com/v3/";

  $status = 2; // 1 para produccion, 2 para pruebas
  $URL_BASE = $status==1 ? $URL_PRODUCCION : $URL_PRUEBAS;

  $btc_min_to_buy = 200000;
  $btc_max_to_sell = 350000;
  $eth_min_to_buy = 20000;
  $eth_max_to_sell = 28000;
  $xrp_min_to_buy = 25;
  $xrp_max_to_sell = 75;
  $ltc_min_to_buy = 4000;
  $ltc_max_to_sell = 6000;

  $recipient = "robertoh@ciencias.unam.mx";

  function tickerBitso($url_base, $status, $book, $max_to_sell, $min_to_buy) {
    $url = $url_base."ticker/?book=".$book;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (!$response) {
      $status = 4;
      echo "No se obtuvo respuesta del servidor.";
      $str_insert = "INSERT INTO Ticks (bitso_book, bitso_volume, bitso_last, bitso_high, bitso_low, bitso_vwap, bitso_ask, bitso_bid, bitso_created_at, server_error_code, server_error_message, status)
      VALUES ('".$book."', '0', '0', '0', '0', '0', '0', '0', CURRENT_TIMESTAMP(), '0', 'No hay respuesta del servidor', '".$status."')";
    }
    $json = json_decode($response);
    if ($json->success) {
      echo 'Success!';
      $str_insert = "INSERT INTO Ticks (bitso_book, bitso_volume, bitso_last, bitso_high, bitso_low, bitso_vwap, bitso_ask, bitso_bid, bitso_created_at, status)
      VALUES ('".$json->payload->book."', '".$json->payload->volume."', '".$json->payload->last."', '".$json->payload->high."', '".$json->payload->low."', '".$json->payload->vwap."', '".$json->payload->ask."', '".$json->payload->bid."', '".$json->payload->created_at."', '".$status."')";
      sendNotifications($book, $max_to_sell, $min_to_buy, $json->payload->last, $recipient);
      /*
      if ($json->payload->last <= $min_to_buy ) {
        sendMailBuy("robertoh@ciencias.unam.mx", $json->payload->last);
      }
      if ($json->payload->last >= $max_to_sell) {
        sendMailSell("robertoh@ciencias.unam.mx", $json->payload->last);
      }
      */
    } else {
      $status = 3;
      echo '<br>Fail! :( <br>';
      echo $json->error->message;
      $str_insert = "INSERT INTO Ticks (bitso_book, bitso_volume, bitso_last, bitso_high, bitso_low, bitso_vwap, bitso_ask, bitso_bid, bitso_created_at, bitso_error_code, bitso_error_message, status)
      VALUES ('".$book."', '0', '0', '0', '0', '0', '0', '0', CURRENT_TIMESTAMP(), '".$json->error->code."', '".$json->error->message."', '".$status."')";
    }
    $conn = connect();
    mysqli_query($conn, $str_insert);
    $conn->close();
    curl_close($ch);
  }
/*
  function sendMailBuy($to, $last) {
    $subject = 'Compra Bitcoins';
    $message = 'Buen día\r\nTe informamos que el tipo de cambio de BTC a MXN está a '.$last.", de modo que puede interesarte comprar.";
    $headers = 'From: Mailer Digitable <mailer_noreply@digitable.mx>' . "\r\n" .
    'Reply-To: roberto@digitable.mx' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

  }

  function sendMailSell($to, $last) {
    $subject = 'Vende Bitcoins';
    $message = 'Buen día'."\r\n".'Te informamos que el tipo de cambio de BTC a MXN está a <strong>'.$last.'</strong>, de modo que puede interesarte vender.';
    $headers = 'From: mailer_noreply@digitable.mx' . "\r\n" .
    'Reply-To: roberto@digitable.mx' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

  }
*/
  function sendNotifications($book, $max, $min, $last, $recipient) {
    switch($book) {
      case "btc_mxn":
        $moneda = "Bitcoins";
        break;
      case "eth_mxn":
        $moneda = "Ethereum";
        break;
      case "xrp_mxn":
        $moneda = "Ripple";
        break;
      case "ltc_mxn":
        $moneda = "Litcoins";
        break;
    }
    $headers = 'From: mailer_noreply@digitable.mx' . "\r\n" .
    'Reply-To: roberto@digitable.mx' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    if ($last <= $min) {
      $subject = 'Oportunidad de compra: '.$moneda;
      $message = 'Buen día.<br>Te informamos que el tipo de cambio de '.$moneda.' a Pesos Mexicanos es de <strong>'.$last.'</strong>.';
      mail($to, $subject, $message, $headers);
    } else if ($last >= $max) {
      $subject = 'Es momento de vender en '.$moneda;
      $message = 'Buen día.<br>Te informamos que el tipo de cambio de '.$moneda.' a Pesos Mexicanos es de <strong>'.$last.'</strong>.';
      mail($to, $subject, $message, $headers);
    }

  }


  tickerBitso($URL_BASE, $status, 'btc_mxn', $btc_max_to_sell, $btc_min_to_buy);
  tickerBitso($URL_BASE, $status, 'eth_mxn', $eth_max_to_sell, $eth_min_to_buy);
  tickerBitso($URL_BASE, $status, 'xrp_mxn', $xrp_max_to_sell, $xrp_min_to_buy);
  tickerBitso($URL_BASE, $status, 'ltc_mxn', $ltc_max_to_sell, $ltc_min_to_buy);

?>
