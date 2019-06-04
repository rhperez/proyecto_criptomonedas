<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include_once $path."/proyecto_criptomonedas/includes/settings.php";
  include_once $path."/proyecto_criptomonedas/controllers/ctrlTicker.php";
  include_once $path."/proyecto_criptomonedas/classes/book.php";

  $URL_BASE = $PRODUCCION==1 ? $URL_PRODUCCION : $URL_PRUEBAS;

  /**
   *  Obtiene books y los almacena en la base de datos
   *
   *  @param string $url_base la url desde donde se obtienen los books
   *  @param int produccion 1 si esta habilitado en produccion, 2 si es en pruebas
   */
  function loadBooks($url_base, $produccion) {
    $url = $url_base."available_books/";
    // Se genera la peticion
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error_code = '';
    $error_message = '';

    if (!$response) {   // Si no hay respuesta se muestra un error
      $status = 0;
      echo "No se obtuvo respuesta del servidor.";
    }
    $json = json_decode($response);   // Guarda la respuesta en un json
    if ($json->success) {   // Se obtuvieron los books sin problemas
      echo 'Respuesta exitosa!';
      $arrayBooks = $json->payload;
      foreach ($arrayBooks as $book) {
        insertBook(new Book($book->book, $book->minimum_price, $book->maximum_price, $book->minimum_amount, $book->maximum_amount,
        $book->minimum_value, $book->maximum_value, $produccion));
      }

    } else {  // Se genero un error desde el servidor
      $status = 3;
      echo '<br>Error del servidor<br>';
      echo $json->error->message;
    }
    curl_close($ch);
  }

  loadBooks($URL_BASE, $PRODUCCION);

?>
