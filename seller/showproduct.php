<?php require 'header.php';

$sql = "SELECT * FROM pizza";
$result = $conn->query($sql);
?>



<div class="container pt-5 mt-5">
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>รายการที่</th>
                <th>รูป</th>
                <th>ชื่อ</th>
                <th>ราคา</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
            <tr>
                <td><?= $i ?></td>
                <td><img src="../images/<?= $row['piz_image'] ?>" alt="Pizza Image" width="80px" height="80px"></td>
                <td><?= $row['piz_name'] ?></td>
                <td><?= $row['unit_price'] ?></td>
                <td>
                    <button class="btn btn-danger">ลบ</button>
                    <button class="btn btn-warning">แก้ไข</button>
                </td>
            </tr>
            <?php
                    $i++;
                }
            } else { ?>
            <tr>
                <td colspan="5">ไม่มีรายการพิซซ่า</td>
            </tr>
            <?php  } ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>