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
$result = $db_connection->query($sql);
?>



<div class="container text-center pt-5 mt-5">
    <div class="card">
        <div class="row row-cols-lg-4 mt-2">
            <div class="ms-2 col">
                <a href="addProduct.php" class="btn btn-primary">เพิ่มรายการใหม่</a>
            </div>
            <div class="col">
                <a href="showsize.php" class="btn btn-primary">ขนาดของพิซซ่า</a>
            </div>
            <div class="col">
                <a href="showcrust.php" class="btn btn-primary">ประเภทแป้ง</a>
            </div>
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
                                    <form action="delete_item.php" method="post">
                                        <input type="hidden" name="s_id" value="<?= $row['sid'] ?>">
                                        <input type="hidden" name="c_id" value="<?= $row['pd_id'] ?>">
                                        <input type="hidden" name="pizid" value="<?= $row['pizza_id'] ?>">
                                        <button type="submit" class="btn btn-danger"
                                            onclick="alert('You clicked OK. Proceeding...')" name="delete_item">ลบ</button>
                                    </form>
                                    <!-- <a href="editproduct.php?id" class="btn btn-warning">แก้ไข</a> -->
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="8">ไม่มีรายการพิซซ่า</td>
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