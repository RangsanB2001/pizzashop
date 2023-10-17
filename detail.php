<?php
ob_start();
require 'haeder.php';

// ตรวจสอบว่ามีการรับพารามิเตอร์ id จาก URL หรือไม่
if (isset($_GET['id'])) {
    $pid = $_GET['id'];
    // คิวรี่ฐานข้อมูลเพื่อดึงข้อมูลสินค้าที่มี id ที่ตรงกับที่รับมาจาก URL
    $sql = "SELECT * FROM pizza
JOIN detail ON detail.pizza_id = pizza.piza_id
JOIN size ON detail.sid = size.size_id
JOIN pizzadough ON detail.pd_id = pizzadough.pizdough_id
WHERE pizza.piza_id = $pid";
    $result = $db_connection->query($sql);
    // ตรวจสอบว่ามีข้อมูลสินค้าหรือไม่
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['piza_id'];
        $img = $row['piz_image'];
        $name = $row['piz_name'];
        $detail = $row['details'];
        $price = $row['price'];
    } else {
        // ถ้าไม่พบสินค้าในฐานข้อมูลก็สามารถเปลี่ยนยังหน้าที่ต้องการได้
        header("Location: error.php");
        exit();
    }
}

// add to cart
if (isset($_POST['add_to_cart'])) {
    // รับข้อมูลจากฟอร์ม
    $uid = $_SESSION['gg_id']; 
    $pizza_id = $_POST['pizza-id'];
    $pizza_name = $_POST['pizza-type'];
    $pizza_crust = $_POST['pizza-crust'];
    $quantity = intval($_POST['quantity']);
    $pizza_size = $_POST['pizza-size'];

    // Check if the record already exists in the cart table
    $check_sql = "SELECT * FROM cart WHERE piz_id = ? AND s_id = ? AND pd_id = ?";
    $check_stmt = $db_connection->prepare($check_sql);
    $check_stmt->bind_param("iii", $pid, $pizza_size, $pizza_crust);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // The record already exists, so update the amount
        $update_sql = "UPDATE cart SET amount = amount + ? WHERE piz_id = ? AND s_id = ? AND pd_id = ? AND cart.user_id = ?";
        $update_stmt = $db_connection->prepare($update_sql);
        $update_stmt->bind_param("iiiis", $quantity, $pizza_id, $pizza_size, $pizza_crust,$uid);

        if ($update_stmt->execute()) {
            header("Location: detail.php?id=" . $pizza_id);
        } else {
            header("Location: detail.php?id=" . $pizza_id);
        }
    } else {
        // The record doesn't exist, so insert a new one
        $insert_sql = "INSERT INTO `cart` (`user_id`,`piz_id`, `s_id`, `pd_id`, `amount`) VALUES (?,?,?,?,?)";
        $insert_stmt = $db_connection->prepare($insert_sql);
        $insert_stmt->bind_param("siiii",$uid, $pizza_id, $pizza_size, $pizza_crust, $quantity);

        if ($insert_stmt->execute()) {
            header("Location: detail.php?id=" . $pizza_id);
        } else {
            header("Location: detail.php?id=" . $pizza_id);
        }
    }
}

?>
<div class="container mt-5">
    <h1 class="text-center">
        <?= $name ?>
    </h1>
    <form id="pizza-order-form" action="detail.php" method="post" class="mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="pizza-option">
                    <img src="images/<?= $img ?>" alt="<?= $name ?>" class="pizza-image" width="200px" height="200px">
                    <input type="hidden" name="pizza-img" id="pizza-img" value="<?= $img ?>" class="form-check-input"
                        checked>
                    <label>
                        <input type="radio" style="display: none;" name="pizza-type" value="<?= $name ?>"
                            class="form-check-input" checked>
                        <?= $name ?>
                        <p>
                            <?= $detail ?>
                        </p>
                    </label>
                    <p>
                        <!-- Add hidden input for base price -->
                        <input type="hidden" name="base-price" id="base-price" class="form-check-input"
                            value="<?= $price ?>" checked>
                        <input type="hidden" name="pizza-id" id="pizza-id" value="<?= $pid ?>" class="form-check-input"
                            checked>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Select Pizza Size -->
                <div class="mb-3">
                    <label for="pizza-crust" class="form-label">เลือกขนาด:</label>
                    <?php
                    $sql = "SELECT DISTINCT * FROM size JOIN detail ON detail.sid = size.size_id WHERE detail.pizza_id = $pid";
                    $result = $db_connection->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $price = $row['price'];
                            $size = $row['size_name'];
                            $siz_id = $row['size_id'];
                            ?>
                            <div class="form-check">
                                <input type="radio" id="<?= $size ?>" name="pizza-size" value="<?= $siz_id ?>"
                                    class="form-check-input" required />
                                <label for="<?= $size ?>" class="form-check-label">
                                    <?= $size ?>
                                </label>
                                <span class="price-<?= $size ?>">
                                    <?= $price ?>
                                </span> บาท
                            </div>
                        <?php }
                    }
                    ?>
                </div>
                <!-- Select Pizza Size -->
                <div class="mb-3">
                    <label class="form-label">เลือกแป้งพิซซ่า: </label>
                    <?php
                    $sql = "SELECT DISTINCT pizzadough.pizdough_id ,pizzadough.dough_name FROM pizzadough JOIN detail ON detail.pd_id = pizzadough.pizdough_id WHERE detail.pizza_id = $pid";
                    $result = $db_connection->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dou_id = $row['pizdough_id'];
                            $dou_name = $row['dough_name'];
                            ?>
                            <div class="form-check">
                                <input type="radio" id="<?= $dou_name ?>" name="pizza-crust" value="<?= $dou_id ?>"
                                    class="form-check-input" required />
                                <label for="<?= $dou_name ?>" class="form-check-label">
                                    <?= $dou_name ?>
                                </label>
                            </div>
                        <?php }
                    }
                    ?>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">จำนวนถาด</label>
                    <input type="number" id="quantity" name="quantity" class="form-control w-50" value="1" required>
                </div>
                <?php if (!isset($_SESSION['gg_id'])) { ?>
                    <a type="button" class="btn btn-outline-warning" href="Login.php">Sign in</a>
                <?php } else { ?>
                    <!-- Add to Cart Button -->
                    <button type="submit" name="add_to_cart" class="btn btn-warning">เพิ่มลงตระกร้า</button>
                    <!-- <button type="submit" name="add_to_cart" class="btn btn-warning">เพิ่มลงตระกร้า</button> -->
                <?php } ?>
            </div>
        </div>
    </form>
</div>
</body>

</html>