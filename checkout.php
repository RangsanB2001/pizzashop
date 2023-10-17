<?php ob_start();
require 'haeder.php'; ?>

<?php
if (isset($_SESSION['gg_id'])) {
    $user_id = $_SESSION['gg_id'];
    $sql = "SELECT DISTINCT `order`.*, user.fullname, user.address, user.email, user.phone 
    FROM `order` JOIN `order_items` ON `order`.`order_id` = `order_items`.`order_id` 
    JOIN `user` ON `order`.`user_id` = `user`.`gg_id` 
    WHERE `order`.`status_order` = 'ยังไม่ชำระเงิน' AND `order`.`user_id` = '$user_id'";
    $result = $db_connection->query($sql);
}
?>

<section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <h1 class="text-primary">Payments CheckOut</h1>
        <div class="row d-flex justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container py-5">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col">
                                            <form id="my-custom-checkout-form" action="process_checkout.php"
                                                method="post">
                                                <?php if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $amount_in_baht = $row['total_price'];
                                                        $amount_in_satangs = (int) $amount_in_baht * 100;
                                                        ?>
                                                        <div class="row g-0">
                                                            <div class="card col-xl-6 d-xl-block bg-image p-2">
                                                                <div class="card-body mt-5">
                                                                    <h3 class="mb-4 text-uppercase">Delivery Info</h3>
                                                                    <input type="hidden" name="order_id"
                                                                        value="<?= $row['order_id'] ?>">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-4">
                                                                            <div class="form-outline">
                                                                                <label class="form-label"
                                                                                    for="form3Example1m">Full Name</label>
                                                                                <input type="text" id="form3Example1m"
                                                                                    value="<?= $user['fullname'] ?>"
                                                                                    class="form-control form-control-lg"
                                                                                    disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-outline mb-4">
                                                                        <label class="form-label"
                                                                            for="form3Example8">Address</label>
                                                                        <textarea type="text" id="form3Example8" name="address"
                                                                            aria-valuemax="<?= $user['address'] ?>"
                                                                            class="form-control form-control-lg"><?= $user['address'] ?></textarea>
                                                                    </div>
                                                                    <div class="form-outline mb-4">
                                                                        <label class="form-label"
                                                                            for="form3Example2">Phone</label>
                                                                        <input type="text" id="form3Example2"
                                                                            value="<?= $user['phone'] ?>" name="phone"
                                                                            class="form-control form-control-lg" />
                                                                    </div>
                                                                    <div class="form-outline mb-4">
                                                                        <label class="form-label"
                                                                            for="form3Example2">Email</label>
                                                                        <input type="text" id="form3Example2"
                                                                            value="<?= $user['email'] ?>"
                                                                            class="form-control form-control-lg" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card col-xl-5 bg-info mx-1">
                                                                <div class="card-body p-md-5 text-black">
                                                                    <h3 class="mb-2 text-uppercase">Order Total :
                                                                        <?= $row['total_price'] ?> THB
                                                                    </h3>
                                                                    <p class="small mb-3 h4">Order Ref :
                                                                        <?= $row['orderref'] ?>
                                                                    </p>
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-4">
                                                                            <div class="form-outline">
                                                                                <?php
                                                                                $order = $row['order_id'];
                                                                                $user_id = $_SESSION['login_id'];
                                                                                $sql = "SELECT `order_items`.* FROM `order` 
                                                                                JOIN `order_items` ON `order`.`order_id` = `order_items`.`order_id` 
                                                                                WHERE `order`.`status_order` = 'ยังไม่ชำระเงิน' AND `order_items`.`order_id` = $order";

                                                                                $result = $db_connection->query($sql);
                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        ?>
                                                                                        <div class="card mb-3">
                                                                                            <div class="card-body">
                                                                                                <div
                                                                                                    class="d-flex justify-content-between">
                                                                                                    <div
                                                                                                        class="d-flex flex-row align-items-center">
                                                                                                        <div class="ms-3">
                                                                                                            <h5>
                                                                                                                <?= $row['piz_name'] ?>
                                                                                                            </h5>
                                                                                                            <p class="small mb-0">
                                                                                                                <?= $row['size'] ?>
                                                                                                            </p>
                                                                                                            <p class="small mb-0">
                                                                                                                <?= $row['dough'] ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="d-flex flex-row align-items-center">
                                                                                                        <div style="width: 50px;">
                                                                                                            <h5 class="fw-normal mb-0">
                                                                                                                <?= $row['qtr_item'] ?>
                                                                                                            </h5>
                                                                                                        </div>
                                                                                                        <div style="width: 80px;">
                                                                                                            <h5 class="mb-0">
                                                                                                                <?= $row['sub_total'] ?>THB
                                                                                                            </h5>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    <?php }
                                                                                } else { ?>
                                                                                    <h1>ไม่มีรายการออเดอร์</h1>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <div class="card col-md-12">
                                                                                <input type="hidden" name="amount"
                                                                                    value="<?= (int) $amount_in_satangs ?>">
                                                                                <input type="hidden" name="omiseToken"
                                                                                    value="pkey_test_5vypcwpstt2o4dnch50"
                                                                                    id="omiseTokenField">
                                                                                <script type="text/javascript"
                                                                                    src="https://cdn.omise.co/omise.js"
                                                                                    data-key="pkey_test_5vypcwpstt2o4dnch50"
                                                                                    data-image="http://bit.ly/customer_image"
                                                                                    data-frame-label="Merchant site name"
                                                                                    type="submit" data-button-label="ชำระเงิน"
                                                                                    data-submit-label="Submit"
                                                                                    data-location="no"
                                                                                    data-amount="<?= (int) $amount_in_satangs ?>"
                                                                                    data-currency="thb"
                                                                                    data-botton-color="omise-button btn btn-primary w-100">
                                                                                        </script>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    header("Location: $base_url/index.php");
                                                    exit;
                                                } ?>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<?php require 'footer.php'; ?>