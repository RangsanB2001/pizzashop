<?php require 'header.php';

// $sql = "SELECT DISTINCT pizza.*, detail.price, size.size_name, pizzadough.dough_name, MAX(detail.detail_id) AS max_detail_id 
// FROM pizza
// JOIN detail ON detail.pizza_id = pizza.piza_id 
// JOIN size ON detail.sid = size.size_id 
// JOIN pizzadough ON detail.pd_id = pizzadough.pizdough_id 
// WHERE pizza.piza_id = detail.pizza_id
// GROUP BY pizza.piza_id, pizza.piz_name, detail.price, size.size_name, pizzadough.dough_name";

$sql = "SELECT DISTINCT pizza.*, size.*, pizzadough.*, detail.* FROM pizza 
JOIN detail ON detail.pizza_id = pizza.piza_id 
JOIN size ON detail.sid = size.size_id 
JOIN pizzadough ON detail.pd_id = pizzadough.pizdough_id 
WHERE pizza.piza_id = detail.pizza_id";
$result = $conn->query($sql);
?>



<div class="container pt-5 mt-5">
    <div class="card">
        <div class="col-sm-12 p-2 ms-auto">
            <a href="addProduct.php" class="btn btn-primary">เพิ่มรายการใหม่</a>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>รายการที่</th>
                        <th>รูป</th>
                        <th>ชื่อ</th>
                        <th>ราคา</th>
                        <th>รายละเอียด</th>
                        <th>ไซต์ทั้งหมด</th>
                        <th>แป้งทั้งหมด</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <?= $i ?>
                                </td>
                                <td><img src="../images/<?= $row['piz_image'] ?>" alt="Pizza Image" width="80px" height="80px">
                                </td>
                                <td>
                                    <?= $row['piz_name'] ?>
                                </td>
                                <td>
                                    <?= $row['price'] ?>
                                </td>
                                <td>
                                    <?= $row['details']; ?>
                                </td>
                                <td>
                                <?= $row['size_name']; ?>
                                </td>
                                <td>
                                <?= $row['dough_name']; ?>
                                </td>
                                <td>
                                    <button class="btn btn-danger">ลบ</button>
                                    <a href="editproduct.php?id=<?= $row['piza_id'] ?>" class="btn btn-warning">แก้ไข</a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5">ไม่มีรายการพิซซ่า</td>
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