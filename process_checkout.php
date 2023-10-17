<?php
include('confing.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once dirname(__FILE__) . '../omise-php/lib/Omise.php';
        define('OMISE_API_VERSION', '2019-05-29');
        define('OMISE_PUBLIC_KEY', 'ใส่ key_public_omise');
        define('OMISE_SECRET_KEY', 'ใส่ key_secert_omise');


        $omiseToken = $_POST['omiseToken'];

        $charge = OmiseCharge::create(
            array(
                'amount' => $_POST['amount'],
                'currency' => 'thb',
                'card' => $omiseToken
            )
        );
        echo "<pre>";
        if ($charge['status'] === "successful") {
            $db_connection->begin_transaction();
            $user_id = $_SESSION['login_id'];
            $status_order = 'ชำระเงินแล้ว';

            // Assuming you retrieve the order_id, address, and phone from the form
            $order_id = $_POST['order_id'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];

            // Update the order table
            $sql = "UPDATE `order` SET `status_order` = ? WHERE `order_id` = ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("si", $status_order, $order_id);
            $stmt->execute();

            // Update the user table
            $sql = "UPDATE `user` SET `address` = ?, `phone` = ? WHERE gg_id = ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("ssi", $address, $phone, $user_id);
            $stmt->execute();

            // Select data from multiple tables
            $sql = "SELECT `order`.`orderref`,`user`.`address`,`user`.`email`, `user`.`fullname`, `order`.`total_price`, `order_items`.`piz_name`, 
            `order_items`.`qtr_item`, `order_items`.`size`, `order_items`.`dough`, `order_items`.`sub_total`
            FROM `user` 
            JOIN `order` ON `order`.`user_id` = `user`.`gg_id` 
            JOIN `order_items` ON `order`.`order_id` = `order_items`.`order_id` 
            WHERE `order`.`user_id` = ? AND `order_items`.`order_id`= ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param("ii", $user_id, $order_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $customerData = $result->fetch_all(MYSQLI_ASSOC);

                // Send an order notification to LINE
                $lineToken = "ใส่ TOKEN LINE_NOTIfy"; // Replace with your LINE Notify token
                $message = "PangKungPizza New order\n";
                $message .= "เลขที่ออเดอร์: " . $customerData[0]['orderref'] . "\n";
                $message .= "อีเมลผู้ซื้อ: " . $customerData[0]['email'] . "\n";
                $message .= "ชื่อผู้ซื้อ: " . $customerData[0]['fullname'] . "\n";
                $message .= "ยอดรวม: " . $customerData[0]['total_price'] . " THB\n";
                $message .= "ที่อยู่จัดส่ง: " . $customerData[0]['address'] . "\n";
                $message .= "-------------------------\n";

                $sql = "SELECT * FROM order_items WHERE order_items.order_id = ?";
                $stmt = $db_connection->prepare($sql);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $orderItems = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($orderItems as $item) {
                    $message .= "รายการที่สั่ง: " . $item['piz_name'] . " จำนวน: " . $item['qty_item'] . " ถาด ขนาด: " . $item['size'] . " - แป้ง: " . $item['dough'] . " - ราคารวม: " . $item['sub_total'] . " THB\n";
                }

                $data = array('message' => $message);

                $data_string = http_build_query($data);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineToken);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);

                $db_connection->commit();

                echo "<script>
                        alert('ชำระเงินเรียบร้อย');
                        window.location.href = 'index.php';
                        </script>";
                exit;
            }
        } else {
            echo "<script>
            alert('ชำระเงินไม่สำเร็จ!!!');
            window.history.back();
            </script>";
        }
    } catch (Exception $e) {
        $db_connection->Rollback();
        echo $e->getMessage();
        echo '<script>
            alert("' . $e->getMessage() . '");
            window.history.back();
          </script>';
        exit;
    }
}
?>
