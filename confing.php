<?php
$base_url ='http://localhost/PizzaShop';

$base_urls ='http://localhost/PizzaShop/seller';

session_start();
error_reporting(E_ERROR | E_PARSE); 
date_default_timezone_set('Asia/Bangkok');

// $db_connection = mysqli_connect("sql112.infinityfree.com", "if0_35226902", "CcyAWTUbmomQW", "if0_35226902_pizza");

$db_connection = mysqli_connect("localhost", "root", "", "PizzaShop");

// $clientID = '569894861207-i6o7ptipkelu13l3pve3l9a9ck79ehrq.apps.googleusercontent.com';
// $clientSecret = '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';

$clientID = '569894861207-hldgbll2g4e5cemkl4ke0v8anhgq3foc.apps.googleusercontent.com';
$clientSecret = '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';
// CHECK DATABASE CONNECTION
if (mysqli_connect_errno()) {
    echo "Connection Failed" . mysqli_connect_error();
    exit;
}
?>
