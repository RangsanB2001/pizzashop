<?php require 'header.php'; ?>
<div class="container" style="margin-top: 60px">
    <div class="row g-5 justify-content-center">
        <section class="bg-info-subtle p-2">
            <h1 class="text-capitalize text-center">เพิ่มรายการพิซซ่า</h1>
        </section>
        <div class="col-md-8 col-sm-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row g-3 mb-3">
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
                        <label for="form-label">ราคา</label>
                        <input type="text" class="form-control" name="price" required>
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