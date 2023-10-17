<?php
ob_start();
require 'haeder.php';

if (isset($_POST['update_order'])) {
    $status = 'ออเดอร์เรียบร้อย';
    $oid = $_POST['oid'];
    $update_sql = "UPDATE `order` SET status_order = ? WHERE order_id = ?";
    $update_stmt = $db_connection->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $oid);

    if ($update_stmt->execute()) {
        header("Location: orderhistory.php");
    } else {
        header("Location: orderhistory.php");
    }
}

$stmt = $db_connection->prepare("SELECT * FROM `order` WHERE order.user_id = '$id'");
$stmt->execute();
$result = $stmt->get_result();
$orderCount;

?>

<div class="container">
    <div class="or">
        <div class="row">
            <h1 class="text-center" style="color: red; margin-top: 20px;">My Order</h1>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="row row-cols-lg-4">
                                    <div class="col-md-3" style="margin-top: 30px; ">
                                        <h5 class="card-title text-danger" style="font-size: 18px;">
                                            <p>Orders ID:
                                                <?php echo $row['orderref']; ?>
                                            </p>
                                        </h5>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 20px; ">
                                        <h5 class="card-title text-danger" style="font-size: 18px;">
                                            Price
                                            <?php echo $row['total_price'] ?> ฿
                                        </h5>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 20px; ">
                                        <p class="h-6 card-title text-warning" style="font-size: 18px;">
                                            <?php echo $row['status_order'] ?>
                                            <span class="small">
                                                <?= $row['notation'] ?>
                                            </span>
                                        </p>
                                    </div>
                                    <!-- ปุ่มกดยกเลิก -->
                                    <div class="col-md-4" style="margin-top: 20px; ">
                                        <div class="row">
                                            <div class="col">
                                                <form action="orderhistory.php" method="POST">
                                                    <input type="hidden" name="oid" value="<?= $row['order_id'] ?>">
                                                    <?php if ($row['status_order'] === 'กำลังจัดส่งกรุณารอรับ') { ?>
                                                        <button class="btn btn-info" type="submit"
                                                            name="update_order">รับพิซซ่าแล้ว</button>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <form action="detail_order.php" method="GET">
                                                    <input type="hidden" name="oid" value="<?= $row['order_id'] ?>">
                                                    <button type="submit" class="btn btn-outline-warning">View</button>
                                                </form>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php require 'footer.php' ?>