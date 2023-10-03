<?php require 'haeder.php'; 

$id = $_GET['id'];

$sql = "SELECT * FROM pizza WHERE piza_id = $id";
$result = $db_connection->query($sql);

 if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $id = $row['piza_id'];
                    $img = $row['piz_image'];
                    $name = $row['piz_name'];
                    $price = $row['unit_price'];
                }
 }
?>

<!-- Pizza Ordering Form -->
<div class="container mt-5">
    <h1 class="text-center">กรุณาเลือกขนาดและแป้ง</h1>
    <form id="pizza-order-form" class="mt-4">
        <!-- Pizza Options -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="pizza-option">
                    <img src="images/<?=$img?>" alt="Margherita Pizza" class="pizza-image" width="200px" height="200px">
                    <input type="hidden" name="pizza-img" id="pizza-img" value="images/<?=$img?>"
                        class="form-check-input" checked>
                    <label>
                        <input type="radio" style="display: none;" name="pizza-type" value="<?=$name?>"
                            class="form-check-input" checked>
                        <?=$name?>
                    </label>
                    <p>
                        <input type="hidden" name="pizza-price" id="pizza-price" value="<?=$price?>"
                            class="form-check-input" checked><?=$price?>
                        <input type="hidden" name="pizza-id" id="pizza-id" value="<?=$id?>" class="form-check-input"
                            checked>
                    </p>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Select Pizza Size -->
                <div class="mb-3">
                    <label class="form-label">เลือกขนาด:</label>
                    <div class="form-check">
                        <input type="radio" id="small" name="pizza-size" value="เล็ก" class="form-check-input" required>
                        <label for="small" class="form-check-label">ถาดเล็ก</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="medium" name="pizza-size" value="กลาง" class="form-check-input" required>
                        <label for="medium" class="form-check-label">ถาดกลาง</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="large" name="pizza-size" value="ใหญ่" class="form-check-input" required>
                        <label for="large" class="form-check-label">ถาดใหญ่</label>
                    </div>
                </div>
                <!-- Select Pizza Crust -->
                <div class="mb-3">
                    <label for="pizza-crust" class="form-label">เลือกแป้งพิซซ่า:</label>
                    <select id="pizza-crust" name="pizza-crust" class="form-select" required>
                        <option value="บางกรอบ">บางกรอบ</option>
                        <option value="หนานุ่ม">หนานุ่ม</option>
                        <option value="ขอบชีต">ขอบชีต</option>
                    </select>
                </div>
                <?php if (!isset($_SESSION['login_id'])) { ?>
                <a type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@fat">Sign in</a>
                <?php }else{ ?>
                <!-- Add to Cart Button -->
                <button type="button" onclick="addToCart()" class="btn btn-warning">เพิ่มลงตระกร้า</button>
                <?php } ?>
    </form>
</div>
</div>

</div>

<?php require 'footer.php'; ?>