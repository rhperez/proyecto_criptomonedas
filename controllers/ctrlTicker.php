<?php

  include_once "../connections/conn.php";
  include_once "../classes/tick.php";

  /**
   *  Almacena la informacion de un tick en la base de datos.
   *
   *  @param Tick $tick: el tick a almacenar
   *  @param integer $server_error_code código de error, dejar en 0 en caso de no existir
   *  @param string $server_error_message mensaje de error, dejar en '' en caso de no existir
   */
  function insertTick($tick, $server_error_code, $server_error_message) {

    $str_insert = "INSERT INTO Ticks (bitso_book, bitso_volume, bitso_last, bitso_high, bitso_low, bitso_vwap, bitso_ask, bitso_bid, bitso_created_at,
       error_code, error_message, status)
    VALUES ('$tick->book', '$tick->volume', '$tick->last', '$tick->high', '$tick->low', '$tick->vwap', '$tick->ask', '$tick->bid', '$tick->created_at',
       '$server_error_code', '$server_error_message', '$tick->status')";
     $conn = connect();
     mysqli_query($conn, $str_insert);
     $conn->close();
  }

  /**
   *  Almacena la informacion de un book en la base de datos.
   *
   *  @param Book $book: el book a almacenar
   */
  function insertBook($book) {
    $str_insert = "INSERT INTO Books (book, minimum_price, maximum_price, minimum_amount, maximum_amount, minimum_value, maximum_value, status)
    VALUES ('$book->book', '$book->minimum_price', '$book->maximum_price', '$book->minimum_amount', '$book->maximum_amount',
      '$book->minimum_value', '$book->maximum_value', '$book->status')";
    $conn = connect();
    mysqli_query($conn, $str_insert);
    $conn->close();
  }

  /**
   *  Devuelve los books almacenados en la base de datos
   *
   *  @return Book array: el arreglo de books obtenidos
   */
  function getBooks() {
    $str_query = "SELECT DISTINCT book, minimum_price, maximum_price, minimum_amount, maximum_amount, minimum_value, maximum_value, status
     FROM Books
     WHERE status = 1";
    $conn = connect();
    $result = mysqli_query($conn, $str_query);
    $arrayBooks = array();
    while ($row = $result->fetch_assoc()) {
      $arrayBooks[] = new Book($row['book'], $row['minimum_price'], $row['maximum_price'], $row['minimum_amount'], $row['maximum_amount'],
       $row['minimum_value'], $row['maximum_value'], $row['status']);
    }
    $conn->close();
    return $arrayBooks;
  }

?>
