<?php
$base_url ='http://localhost/PizzaShop';

session_start();
// change the information according to your database
// $db_connection = mysqli_connect("sql313.byethost4.com", "b4_35023426", "rangsan2234", "b4_35023426_google_login");

$db_connection = mysqli_connect("localhost", "root", "", "ชื่อดาต้าเบส");

$clientID = 'ใส่key clientID api google';
$clientSecret = 'ใส่key clientSecret api google';
// CHECK DATABASE CONNECTION
if (mysqli_connect_errno()) {
    echo "Connection Failed" . mysqli_connect_error();
    exit;
}
?>
