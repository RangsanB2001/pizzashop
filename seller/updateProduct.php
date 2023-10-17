<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $piza_id = $_POST['id'];

    // Get other form data
    $name = $_POST['name'];
    $priceMini = $_POST['price_mini'];
    $priceMedium = $_POST['price_medium'];
    $priceLarge = $_POST['price_large'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadedImage = $_FILES['image']['tmp_name'];
        $imageFileName = $_FILES['image']['name'];
        $targetFolder = 'images/';
        $targetPath = $targetFolder . $imageFileName;

        if (move_uploaded_file($uploadedImage, $targetPath)) {
            // Prepare SQL query with image update
            $sql = "UPDATE `pizza` SET `piz_image`='$imageFileName', `piz_name`='$name', `price_mini`='$priceMini', `price_medium`='$priceMedium', `price_large`='$priceLarge' WHERE piza_id = $piza_id";
        } else {
            // Handle image upload error
            echo "<script>
                    alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ'); // Change the message
                    window.location.href = 'editproduct.php?id=$piza_id';
                  </script>";
        }
    } else {
        // Prepare SQL query without image update
        $sql = "UPDATE `pizza` SET `piz_name`='$name', `price_mini`='$priceMini', `price_medium`='$priceMedium', `price_large`='$priceLarge' WHERE piza_id = $piza_id";
    }

    // Execute the SQL query
    if ($db_connection->query($sql)) {
        // Redirect to a success page if the update was successful
        header('Location: showproduct.php');
        exit();
    } else {
        // Handle database query error
        echo "<script>
                alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล'); // Change the message
                window.location.href = 'editproduct.php?id=$piza_id';
              </script>";
    }
}
?>
