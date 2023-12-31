<?php
require '../confing.php';
session_start();
if (!isset($_SESSION["userid"])) {
    header("Location: $base_urls/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link href="../js/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Roboto:ital@1&family=Sarabun:wght@100&display=swap"
        rel="stylesheet">
    <title>เพิ่มรายการพิซซ่า</title>
</head>

<body>
    <header class="navbar navbar-expand-lg bg-dark ">
        <div class="container text-warning">
            <a class="navbar-brand fs-3 fw-700 text-warning fw-bold"
                href="<?= $base_url ?>/seller/index.php">PungKungPizza</a>
            <button class="navbar-toggler text-warning bg-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-warning" aria-current="page"
                            href="showproduct.php">จัดการพิซซ่า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="order.php">จัดการออเดอร์</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link text-warning" href="#">ตรวจการชำเงิน</a>
                    </li> -->
                </ul>
                <span class="navbar-text text-warning">
                    <div class="dropdown">
                        <a class="btn btn-outline-warning dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['username'] ?>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="logout.php">logout</a></li>
                        </ul>
                    </div>
                </span>
            </div>
        </div>
    </header>