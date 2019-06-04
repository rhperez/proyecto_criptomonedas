<?php
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/includes/settings.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/controllers/ctrlTicker.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/tick.php";
  include_once "/home4/digitab1/public_html/proyecto_criptomonedas/classes/book.php";

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
      echo "<strong>Error 400:</strong> No se obtuvo respuesta del servidor.<br>";
      $error_code = '400';
      $error_message = 'No se obtuvo respuesta del servidor.';
      $tick = new Tick($book, '', '', '', '', '', '', '', '', $status);
    }
    $json = json_decode($response);   // Guarda la respuesta en un json
    if ($json->success) {   // Se obtuvo el tick sin problemas
      echo "Guardando info book: ".$json->payload->book."... <br>";
      $error_code = '0';
      $error_message = '';
      $tick = new Tick($json->payload->book, $json->payload->volume, $json->payload->last, $json->payload->high, $json->payload->low,
      $json->payload->vwap, $json->payload->ask, $json->payload->bid, $json->payload->created_at, $produccion);
      echo "Info guardada exitosamente! <br>";
      //sendNotifications($book, $max_to_sell, $min_to_buy, $json->payload->last, $recipient);
    } else {  // Se genero un error desde el servidor
      $status = 3;
      echo "<strong>Error $json->error->code:</strong> $json->error->message.<br>";
      $error_code = $json->error->code;
      $error_message = $json->error->message;
      $tick = new Tick($book, '', '', '', '', '', '', '', '', $status);
    }
    insertTick($tick, $error_code, $error_message);   // Almacena el tick
    curl_close($ch);
  }


  $arrayBooks = getBooks(); //  Obtiene los books de la base de datos
  foreach ($arrayBooks as $book) {  //Por cada book obtiene un tick
    tickerBitso($URL_BASE, $PRODUCCION, $book->book);
  }


?>
