<?php
require 'header.php';

if (isset($_GET['id'])) {
    $or_id = $_GET['id'];
    $sql = "SELECT * FROM `order` 
    JOIN user ON `order`.user_id = user.gg_id  
    WHERE `order`.order_id =  $or_id";
    $result = $db_connection->query($sql);
}

?>

<div class="container pt-5 mt-5">
    <div class="card">
        <div class="card-body">
            <div class="container mb-5">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-9">
                        <?php
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc(); // เรียกข้อมูลแรกจากผลลัพธ์
                            $orderref = $row['orderref'];
                            $total = $row['total_price'];
                            $uname = $row['fullname'];
                            $address = $row['address'];
                            $phone = $row['phone'];
                            $email = $row['email'];
                            $create = $row['create_order'];
                            $status = $row['status_order'];
                            $ord_id = $row['order_id'];
                            ?>
                            <p style="color: #7e8d9f; font-size: 20px;">OrderRef >> <strong>ID:
                                    <?= $orderref ?>
                                </strong></p>
                        </div>
                        <div class="col-xl-3 float-end">
                            <!-- <a class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i
                                    class="fas fa-print text-primary"></i> Print</a>
                            <a class "btn btn-light text-capitalize" data-mdb-ripple-color="dark"><i
                                    class="far fa-file-pdf text-danger"></i> Export</a> -->
                        </div>
                        <hr>
                    </div>

                    <div class="container">
                        <div class="col-md-12">
                            <div class="text-center">
                                <p class="navbar-brand fs-3 fw-700 text-warning fw-bold pt-0">PangKungPizza.com</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                                <ul class="list-unstyled">
                                    <li class="text-muted">To: <span style="color: #5d9fc5;">
                                            <?= $uname ?>
                                        </span></li>
                                    <li class="text-muted">address:
                                        <?= $address ?>
                                    </li>
                                    <li class="text-muted">email:
                                        <?= $email ?>
                                    </li>
                                    <li class="text-muted"><i class="fas fa-phone"></i>
                                        <?= $phone ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-4">
                                <p class="text-muted">OrderRef</p>
                                <ul class="list-unstyled">
                                    <li class="text-muted"><i class="fas fa-circle" style="color: #84B0CA;"></i> <span
                                            class="fw-bold">ID:</span>#
                                        <?= $orderref ?>
                                    </li>
                                    <li class="text-muted"><i class="fas fa-circle" style="color: #84B0CA;"></i> <span
                                            class="fw-bold">Creation Date: </span>
                                        <?= $create ?>
                                    </li>
                                    <li class="text-muted"><i class="fas fa-circle" style="color: #84B0CA;"></i> <span
                                            class="me-1 fw-bold">Status:</span><span
                                            class="badge bg-warning text-black fw-bold">
                                            <?= $status ?>
                                        </span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row my-2 mx-1 justify-content-center">
                            <table class="table table-striped table-borderless">
                                <thead style="background-color: #84B0CA;" class="text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                       $sql = "SELECT * FROM order_items WHERE order_items.order_id = ?";
                                       $stmt = $db_connection->prepare($sql);
                                       $stmt->bind_param("i", $ord_id);
                                       $stmt->execute();
                                       $result = $stmt->get_result();
                                       $orderItems = $result->fetch_all(MYSQLI_ASSOC);
                                       foreach ($orderItems as $item) {
                                    ?>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <?= $item['piz_name'] ?><span class="small">
                                                <?= $item['size'] ?>
                                            </span><span class="small">
                                                <?= $item['dough'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= $item['qtr_item'] ?>
                                        </td>
                                        <td>
                                            <?= $item['unit_price'] ?>
                                        </td>
                                        <td>
                                            <?= $item['sub_total'] ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xl-8">
                            </div>
                            <div class="col-xl-3">
                                <p class="h4 text-black float-start"><span class="text-black me-3"> Total Amount</span><span
                                        style="font-size: 25px;">
                                        <?= $total ?>
                                    </span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="../js/datatables.min.js"></script>
</body>

</html>