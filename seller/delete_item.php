<?php
require '../confing.php';

if (isset($_POST['delete_item']) && isset($_POST['s_id']) && isset($_POST['c_id']) && isset($_POST['pizid'])) {
    $sid = $_POST['s_id'];
    $pd_id = $_POST['c_id'];
    $pizza_id = $_POST['pizid'];

    // Create a prepared statement
    $delete_item = $db_connection->prepare("DELETE FROM detail WHERE pizza_id = ? AND sid = ? AND pd_id = ?");
    $delete_item->bind_param("iii",$pizza_id, $sid, $pd_id);

    // Execute the prepared statement
    if ($delete_item->execute() === true) {
        header("Location: $base_urls/showproduct.php"); // Remove the space before the colon
        exit;
    } else {
        header("Location: $base_urls/showproduct.php"); // Remove the space before the colon
        exit;
    }
}
?>