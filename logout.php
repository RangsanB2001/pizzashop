<?php
require_once('LineLogin.php');

session_start();
$_SESSION = array();
session_destroy();

$profile = $_SESSION['profile'];
$pro = $_SESSION['pro'];
$line = new LineLogin();
$line->revoke($profile->access_token);
session_destroy();
header("Location: index.php");
exit;

?>