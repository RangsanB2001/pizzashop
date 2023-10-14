<?php

$base_url = 'http://localhost/PizzaShop';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzashop";


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>