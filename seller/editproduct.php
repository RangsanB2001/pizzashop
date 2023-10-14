<?php
require 'header.php';

// Check if 'id' is set and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM pizza WHERE piza_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Fetch data once and store it in variables
        $piza_id = $row['piza_id'];
        $piz_image = $row['piz_image'];
        $piz_name = $row['piz_name'];
        $details = $row['details'];
    }
}
?>

<div class="container" style="margin-top: 40px">
    <!-- ... Rest of your HTML code ... -->
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <img src="../images/<?= $piz_image ?>" class="card-img-top md-1" alt="<?= $piz_name ?>">
            </div>
        </div>
    </div>
    <form action="editproduct.php" method="post" enctype="multipart/form-data">
        <div class="row g-3 mb-2">
            <div class="col-sm-12">
                <label for="form-label">รูปภาพพิซซ่า</label>
                <input type="file" class="form-control" name="image" accept="image/png, image/jpg,image/jpeg" required>
            </div>
            <div class="col-sm-12">
                <label for="form-label">ชื่อหน้าพิซซ่า</label>
                <input type="text" class="form-control" value="<?= $piz_name ?>" name="name" required>
            </div>
            <div class="col-sm-12">
                <label for="form-label">รายละเอียด</label>
                <textarea type="text" class="form-control" value="<?= $details ?>" name="detail" required><?= $details ?></textarea>
            </div>
            <div class="col-sm-12">
                <label for="form-label">ราคา</label>
                <input type="text" class="form-control" name="price" required>
            </div>
            <div class="col-sm-12">
                <label for="form-label">กำหนดไซต์</label>
                <?php
                $sql = "SELECT * FROM size";
                $size = $conn->query($sql);
                ?>
                <select id="pizza-size" name="pizza-size" class="form-select" required>
                    <?php if ($size->num_rows > 0) {
                        while ($row = $size->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['size_id']; ?>" selected>
                                <?php echo $row['size_name']; ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-12">
                <label for="form-label">กำหนดไซต์แป้ง</label>
                <?php
                $sql = "SELECT * FROM pizzadough";
                $size = $conn->query($sql);
                ?>
                <select id="pizzadoung" name="pizzadoung" class="form-select" required>
                    <?php if ($size->num_rows > 0) {
                        while ($row = $size->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['pizdough_id']; ?>" selected>
                                <?php echo $row['dough_name']; ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-sm-6">
                <button class="btn btn-primary" type="submit">บันทึก</button>
            </div>
        </div>
    </form>
    <!-- ... Rest of your HTML code ... -->
</div>
</body>

</html>