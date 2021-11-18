<?php
$servername = "localhost";
$username = "app";
$password = "543210";
$dbname = "Prueba";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo '<br>'. $e->getMessage();
}

?> 