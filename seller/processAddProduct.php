<?php
// session_start();
require 'config.php';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['name'], $_POST['price'], $_FILES['image'])
) {

    // รับค่าที่ส่งมาจากฟอร์ม
    $name = $_POST['name'];
    $price = $_POST['price'];

    // ตรวจสอบไฟล์รูปภาพที่อัปโหลด
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_size = $image['size'];
    $image_type = $image['type'];

    // เช็คนามสกุลไฟล์รูปภาพ (เช่น jpg, png)
    $allowed_extensions = array('jpg', 'jpeg', 'png');
    $file_extension = pathinfo($image_name, PATHINFO_EXTENSION);

    if (in_array($file_extension, $allowed_extensions)) {
        // ตรวจสอบว่าไฟล์เป็นรูปภาพจริงๆ
        if (getimagesize($image_tmp)) {
            // กำหนดโฟลเดอร์เก็บรูปภาพ
            $upload_directory = '../images/';

            // สร้างชื่อไฟล์ใหม่
            $new_image_name = uniqid() . '.' . $file_extension;

            // ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ปลายทาง
            if (move_uploaded_file($image_tmp, $upload_directory . $new_image_name)) {

                $sql = "INSERT INTO pizza (piz_name,unit_price,piz_image) VALUES ('$name',$price, '$new_image_name')";
                if ($conn->query($sql)) {

                    echo "<script>
                alert('เพิ่มเมนูเรียบร้อย'); // Change the message
                window.location.href = 'addProduct.php';
              </script>";

                }
            } else {
                echo "<script>
                alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ'); // Change the message
                window.location.href = 'addProduct.php';
              </script>";
            }
        } else {
            echo "<script>
            alert('ไฟล์ที่อัปโหลดไม่ใช่รูปภาพที่ถูกต้อง'); // Change the message
            window.location.href = 'addProduct.php';
          </script>";
        }
    } else {
        echo "<script>
        alert('นามสกุลของรูปภาพไม่ถูกต้อง'); // Change the message
        window.location.href = 'addProduct.php';
      </script>";
    }
}
?>