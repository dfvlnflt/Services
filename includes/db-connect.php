<?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "root";
  //SWITCH WITH YOUR DATABASE
  $database = "marketing";
  $port = "8889";
  $conn = new mysqli($servername, $username, $password, $database,$port);
  if ($conn->connect_error){die("Connection failed: ".$conn->connect_error);}
?>
