<?php
ob_start();
require 'haeder.php';

if (!isset($_SESSION['gg_id'])){
    header("Location: $base_url/index.php");
    exit;
}

if (isset($_SESSION['gg_id'])) {
    $user_id = $_SESSION['gg_id'];

    $sql = "SELECT * FROM cart 
            JOIN pizza ON cart.piz_id = pizza.piza_id 
            WHERE cart.user_id = '$user_id'";

    $result = $db_connection->query($sql);

    // ตรวจสอบว่ามีข้อมูลสินค้าหรือไม่
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartid = $row['cart_id'];
            $pid = $row['piz_id'];
            $size = $row['s_id'];
            $cid = $row['pd_id'];
            $name = $row['piz_name'];
            $quantity = $row['amount'];
            $img = $row['piz_image'];

            // แป้ง
            $stmt_size = $db_connection->prepare("SELECT * FROM pizzadough JOIN detail ON detail.pd_id = pizzadough.pizdough_id WHERE pizzadough.pizdough_id = ? AND detail.pizza_id = ?");
            $stmt_size->bind_param("ii", $cid, $pid);
            $stmt_size->execute();
            $result_curst = $stmt_size->get_result();
            if ($result_curst->num_rows > 0) {
                $row = $result_curst->fetch_assoc();
                $cid = $row['pizdough_id'];
                $cname = $row['dough_name'];
            }

            // ดึงข้อมูล size
            $stmt_size = $db_connection->prepare("SELECT * FROM size JOIN detail ON detail.sid = size.size_id WHERE detail.sid = ? AND detail.pizza_id = ?");
            $stmt_size->bind_param("ii", $size, $pid);
            $stmt_size->execute();
            $result_size = $stmt_size->get_result();
            if ($result_size->num_rows > 0) {
                $row = $result_size->fetch_assoc();
                $ssid = $row['size_id'];
                $sname = $row['size_name'];
                // กำหนดราคาตามขนาดพิซซ่าที่เลือก
                $price = $row['price'];
            } else {
                // หากไม่มีขนาดที่ตรงกัน ให้ใช้ราคาเริ่มต้น
                $price = $priceDefault;
            }
            // คำนวณราคารวมของรายการ
            $subtotal = $price * $quantity;

            // กำหนดรายการสินค้าในตะกร้า
            if (!isset($Cart['cart'])) {
                $Cart['cart'] = [];
            }

            // ตรวจสอบว่ารายการสินค้านี้มีอยู่ในตะกร้าแล้วหรือไม่
            if (isset($Cart['cart'][$cartid])) {
                // ถ้ามีอยู่แล้ว ให้เพิ่มจำนวนสินค้า
                $Cart['cart'][$cartid]['quantity'] += $quantity;
                $Cart['cart'][$cartid]['subtotal'] += $subtotal;
            } else {
                // ถ้ายังไม่มีในตะกร้า ให้เพิ่มรายการใหม่
                $Cart['cart'][$cartid] = [
                    'piz_id' => $pid,
                    'img' => $img,
                    'name' => $name,
                    'size' => $sname,
                    'crust' => $cname,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }
        }
    }

    // ลบรายการสินค้าในตะกร้า
    if (isset($_POST['remove_item'])) {
        $cartid = $_POST['remove_item'];
        // Use prepared statement to delete the item from the database
        $stmt = $db_connection->prepare("DELETE FROM cart WHERE cart_id = ?");
        $stmt->bind_param("i", $cartid);

        if ($stmt->execute()) {
            // You may also want to remove the item from the session cart if needed
            if (isset($Cart['cart'][$cartid])) {
                header("Location: $base_url/carts.php");
                exit; // Redirect and exit to prevent further processing
            }
        }

        $stmt->close();
    }

    // อัปเดตจำนวนสินค้าในตะกร้า

    if (isset($_POST['minus'])) {
        $cartid = $_POST['minus'];
        $quantity = max(1, $_POST['quantity'][$cartid] - 1);

        $stmt = $db_connection->prepare("UPDATE `cart` SET `amount` = ? WHERE cart_id = ?");
        $stmt->bind_param("ii", $quantity, $cartid);

        if ($stmt->execute()) {
            header("Location: $base_url/carts.php");
            exit;
        }
    }

    if (isset($_POST['plus'])) {
        $cartid = $_POST['plus'];
        $quantity = max(1, $_POST['quantity'][$cartid] + 1);

        $stmt = $db_connection->prepare("UPDATE `cart` SET `amount` = ? WHERE cart_id = ?");
        $stmt->bind_param("ii", $quantity, $cartid);

        if ($stmt->execute()) {
            header("Location: $base_url/carts.php");
            exit;
        }
    }

}

if (isset($_POST['checkout'])) {
    $total = $_POST['total'];
    $user_id = $_SESSION['gg_id'];
    $status_order = 'ยังไม่ชำระเงิน';
    $orderref = substr(md5(rand() . time()), 0, 8);

    $sql = "INSERT INTO `order` (user_id,total_price,status_order, orderref) VALUES ('$user_id',$total,'$status_order', '$orderref')";

    if ($db_connection->query($sql) === TRUE) {
        $order_id = $db_connection->insert_id;

        foreach ($Cart['cart'] as $item) {
            $piz_id = $item['piz_id'];
            $pizza_name = $item['name']; // Change to 'name' instead of 'pizza_name'
            $size = $item['size'];
            $crust = $item['crust'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $subtotal = $item['subtotal'];

            $sql = "INSERT INTO `order_items` (order_id, pizza_id, piz_name, unit_price, qtr_item, sub_total, size, dough) VALUES ($order_id, $piz_id, '$pizza_name', $price, $quantity, $subtotal, '$size', '$crust')";

            if ($db_connection->query($sql) !== TRUE) {
                echo "<script>
                    alert('Order Not successful'); 
                    window.location.href = '$base_url/carts.php';
                    </script>";
                exit;
            }
        }

        $stmt = $db_connection->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Order successful'); 
                window.location.href = '$base_url/checkout.php';
                </script>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Order Not successful'); 
            window.location.href = '$base_url/carts.php';
            </script>";
        exit;
    }
}
?>
<section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container mt-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="col-lg-12">
                            <h1 class="text-center">ตะกร้าสินค้า</h1>
                            <!-- แสดงรายการสินค้าในตะกร้า -->
                            <form method="post" action="carts.php">
                                <?php if (!empty($Cart['cart'])): ?>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>รายการ</th>
                                                <th>ขนาด</th>
                                                <th>แป้งพิซซ่า</th>
                                                <th>ราคาต่อหน่วย</th>
                                                <th>จำนวน</th>
                                                <th>รวม</th>
                                                <th>ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($Cart['cart'] as $cartid => $item): ?>
                                                <tr>
                                                    <td>
                                                        <img src="images/<?= $item['img'] ?>" alt="" width="100">
                                                    </td>
                                                    <td>
                                                        <?= $item['name'] ?>
                                                        <input type="hidden" name="name" value="<?= $item['name'] ?>">
                                                        <input type="hidden" name="piz_id" id="" value="<?= $item['piz_id'] ?>">
                                                    </td>
                                                    <td>
                                                        <?= $item['size'] ?>
                                                        <input type="hidden" name="size" value="<?= $item['size'] ?>">
                                                    </td>
                                                    <td>
                                                        <?= $item['crust'] ?>
                                                        <input type="hidden" name="crust" value=" <?= $item['crust'] ?>">
                                                    </td>
                                                    <td>
                                                        <?= $item['price'] ?>
                                                        <input type="hidden" name="price" value="<?= $item['price'] ?>">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="quantity-controls">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <button class="btn btn-danger quantity-decrement"
                                                                        value="<?= $cartid ?>" name="minus">-</button>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="number"
                                                                        class="form-control w-100 text-center quantity-input"
                                                                        name="quantity[<?= $cartid ?>]"
                                                                        value="<?= $item['quantity'] ?>" min="1" required>
                                                                    <input type="hidden" name="cart_id" value="<?= $cartid ?>">
                                                                </div>
                                                                <div class="col">
                                                                    <button class="btn btn-primary quantity-increment"
                                                                        value="<?= $cartid ?>" name="plus">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?= $item['subtotal'] ?>
                                                        <input type="hidden" name="subtotal" value="<?= $item['subtotal'] ?>">
                                                    </td>
                                                    <td>
                                                        <button type="submit" name="remove_item" class="btn btn-danger"
                                                            value="<?= $cartid ?>">
                                                            ลบ
                                                        </button>
                                                        <input type="hidden" name="pizza_id" value="<?= $pizza_id ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="h4 text-center text-warning mt-3">ไม่มีสินค้าในตะกร้า</p>
                                <?php endif; ?>

                                <!-- แสดงราคารวมในตะกร้า -->
                                <h3 class="mt-4">ราคารวม:
                                    <?php
                                    $total = 0;
                                    if (isset($Cart['cart'])) {
                                        foreach ($Cart['cart'] as $item) {
                                            $total += $item['subtotal'];
                                        }
                                    } ?>
                                    <input type="hidden" name="total" id="" value="<?= $total ?>">
                                    <?= $total; ?> บาท
                                </h3>
                                <?php if ($total > 0) { ?>
                                <button type="submit" name="checkout" class="btn btn-primary">ยืนยันสั้งซื้อ</button>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>

</html>