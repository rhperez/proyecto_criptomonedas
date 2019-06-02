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

?>
