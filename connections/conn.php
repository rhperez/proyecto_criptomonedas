<?php

function connect() {
  $host = "localhost";
  $user = "digitab1_public";
  $pswd = "Aq@gdM2npL==";
  $db = "digitab1_bitso";
  $conn = mysqli_connect($host, $user, $pswd, $db);
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    return null;
  }
  return $conn;
}

 ?>
