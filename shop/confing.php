<?php
session_start();
// change the information according to your database
// $db_connection = mysqli_connect("sql313.byethost4.com", "b4_35023426", "rangsan2234", "b4_35023426_google_login");

$db_connection = mysqli_connect("localhost", "root", "", "pizzashop");

$clientID = '569894861207-i6o7ptipkelu13l3pve3l9a9ck79ehrq.apps.googleusercontent.com';
$clientSecret = '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';
// CHECK DATABASE CONNECTION
if (mysqli_connect_errno()) {
    echo "Connection Failed" . mysqli_connect_error();
    exit;
}
?>