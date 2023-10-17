<?php
require 'header.php';

$sql = "SELECT * FROM pizzadough";
$result = $db_connection->query($sql);

if (isset($_POST['adddogh'])) {
    $name = $_POST['namedong'];
    $sql = "INSERT INTO pizzadough (`dough_name`) VALUES ('$name')";
    $result = $db_connection->query($sql);

    if ($result) {
        header("Location: $base_url/showcrust.php");
        exit;
    } else {
        header("Location: $base_url/showcrust.php");
        exit;
    }
}
?>
<div class="container text-center pt-5 mt-5">
    <div class="card">
        <div class="row row-cols-lg-4 mt-2">
            <div class="ms-2 col">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">เพิ่ม</button>
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
                        <th>ชื่อ</th>
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
                                <td>
                                    <?= $row['dough_name'] ?>
                                </td>
                                <td>
                                    <a name="cu_id" value="<?= $row['pizdough_id'] ?>" class="btn btn-warning"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal1">แก้ไข</a>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่ม</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <label for="namesize">แป้ง</label>
                    <input type="text" name="namedong" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="adddogh" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไข</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <label for="namesize">แป้ง</label>
                    <input type="text" name="namesize" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="../js/datatables.min.js"></script>
</body>

</html>