<?php require 'header.php';

$sql = "SELECT o.*, COUNT(oi.order_id) AS order_items_count
FROM `order` o
LEFT JOIN `order_items` oi ON o.order_id = oi.order_id
WHERE DATE(o.create_order) = CURDATE()
GROUP BY o.order_id";
$result = $conn->query($sql);


if (isset($_POST['confirm'])) {
    $status = 'กำลังเตรียมพิซซ่า';
    $oid = $_POST['oid'];
    $update_sql = "UPDATE `order` SET status_order = ? WHERE order_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $oid);

    if ($update_stmt->execute()) {
        header("Location: order.php");
    } else {
        header("Location: order.php");
    }
}


if (isset($_POST['update_order'])) {
    $status = 'กำลังจัดส่งกรุณารอรับ';
    $oid = $_POST['oid'];
    $update_sql = "UPDATE `order` SET status_order = ? WHERE order_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $oid);

    if ($update_stmt->execute()) {
        header("Location: order.php");
    } else {
        header("Location: order.php");
    }
}


if (isset($_POST['cancel'])) {

    $status = 'ยกเลิก';
    $notation = $_POST['detail'];
    $oid = $_POST['oid'];
    $update_sql = "UPDATE `order` SET status_order = ? AND notation = ? WHERE order_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $status, $notation, $oid);

    if ($update_stmt->execute()) {
        header("Location: order.php");
    } else {
        header("Location: order.php");
    }
}
?>

<div class="container pt-5 mt-5">
    <div class="card">
        <!-- <div class="col-sm-12 p-2 ms-auto">
            <a href="addProduct.php" class="btn btn-primary">เพิ่มรายการใหม่</a>
        </div> -->
        <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">ออเดอร์ที่</th>
                        <th class="text-center">จำนวนถาด</th>
                        <th class="text-center">ราคารวมทั้งหมด</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?= $row['orderref'] ?>
                                </td>
                                <td class="text-center">
                                    <?= $row['order_items_count'] ?>
                                </td>
                                <td class="text-center">
                                    <?= $row['total_price'] ?>
                                </td>
                                <td class="text-center">
                                    <?= $row['status_order'] ?>
                                </td>
                                <form action="order.php" method="post">
                                    <td class="text-center">
                                        <input type="hidden" name="oid" value="<?= $row['order_id'] ?>">

                                        <?php if ($row['status_order'] === 'กำลังเตรียมพิซซ่า') { ?>
                                            <button class="btn btn-info" type="submit" name="update_order">จัดส่งออเดอร์</button>
                                        <?php } ?>

                                        <?php if ($row['status_order'] === 'ชำระเงินแล้ว') { ?>
                                            <button class="btn btn-primary" type="submit" name="confirm">รับออเดอร์</button>
                                            <a class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">ยกเลิกออเดอร์</a>
                                        <?php } ?>
                                        <a href="detailorder.php?id=<?= $row['order_id'] ?>"
                                            class="btn btn-outline-warning text-black">ดูรายละเอียด</a>
                                    </td>
                                </form>
                            </tr>
                            
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="order.php" method="post">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">คุณต้องการยกเลิกออเดอร์นี้
                                                    ใช่หรือไม่</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="detail">หมายเหตุ</label>
                                                <input type="text" class="form-control" name="detail">
                                                <input type="hidden" name="oid" value="<?= $row['order_id'] ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่
                                                    ยืนยัน</button>
                                                <button type="submit" name="cancel"
                                                    class="btn btn-primary">ยืนยันการยกเลิก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">ไม่มีรายการออเดอร์</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="../js/datatables.min.js"></script>
</body>

</html>