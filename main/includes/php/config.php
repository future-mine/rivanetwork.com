<?php
  $mysqlServer = "localhost"; // MySQL Server Adress
  $mysqlServerPort = "3306"; // MySQL Port (Default: 3306)
  $mysqlUsername = "demo_auth"; // MySQL Username
  $mysqlPassword = "41U;kHv}[6V5"; // MySQL Password
  $mysqlDatabase = "demo_auth"; // MySQL Database

  try {
    $db = new PDO("mysql:host=".$mysqlServer."; port=".$mysqlServerPort."; dbname=".$mysqlDatabase."; charset=utf8", $mysqlUsername, $mysqlPassword);
  } catch (PDOException $e) {
    die("<strong>MySQL Connect Error:</strong> ".utf8_encode($e->getMessage()));
  }
?>