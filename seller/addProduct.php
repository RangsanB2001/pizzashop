<?php require 'header.php'; ?>
<div class="container" style="margin-top: 30px">
    <div class="row g-5 justify-content-center">
        <section class="bg-info-subtle p-2">
            <h1 class="text-capitalize text-center">เพิ่มรายการพิซซ่า</h1>
        </section>
        <div class="col-md-8 col-sm-12">
            <form action="processAddProduct.php" method="post" enctype="multipart/form-data">
                <div class="row g-3 mb-2">
                    <div class="col-sm-12">
                        <label for="form-label">รูปภาพพิซซ่า</label>
                        <input type="file" class="form-control" name="image" accept="image/png, image/jpg,image/jpeg"
                            required>
                    </div>
                    <div class="col-sm-12">
                        <label for="form-label">ชื่อหน้าพิซซ่า</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="col-sm-12">
                        <label for="form-label">รายละเอียด</label>
                        <textarea type="text" class="form-control" name="detail" required></textarea>
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
        </div>
    </div>

</div>
</body>

</html>