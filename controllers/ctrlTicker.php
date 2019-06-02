<?php

  include_once "../connections/conn.php";
  include_once "../classes/tick.php";

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
