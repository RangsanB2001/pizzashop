<?php
ob_start();
require 'confing.php';
require_once('LineLogin.php');
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
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <link href="js/datatables.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Roboto:ital@1&family=Sarabun:wght@100&display=swap" rel="stylesheet">
    <title>PungKungPizza</title>

    <style>
        /* CSS Styles for the Cart Table */
        /* .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cart-table th,
        .cart-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .cart-table th {
            background-color: #f2f2f2;
        }

        .cart-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .cart-table img {
            max-width: 100px;
            height: auto;
        } */

        /* กำหนดสีพื้นหลัง */
        /* .omise-button {
            background-color: blueviolet;
            color: #FFFFFF;
        } */

        /* กำหนดขนาดของปุ่ม */
        /* .omise-button {
            width: 300px;
            height: 40px;
        }*/
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-danger navbar-expand bg-body-danger text-warning" data-bs-theme="dark" style="z-index: 2000;">
        <div class="container hstack gap-3">
            <!-- Navbar brand -->
            <a class="navbar-brand fs-3 fw-700 text-warning fw-bold" href="<?= $base_url ?>/index.php">PangKungPizza</a>
            <?php if (isset($_SESSION['profile']) && isset($_SESSION['pro']) || isset($_SESSION['login_id'])) {

                if (isset($_SESSION['profile']) && isset($_SESSION['pro'])) {
                    $pro = $_SESSION['profile'];
                    $id = $pro->userId;
                } else {
                    $id = $_SESSION['login_id'];
                }
                $get_user = mysqli_query($db_connection, "SELECT * FROM `user` WHERE `gg_id`='$id'");
                if (mysqli_num_rows($get_user) > 0) {
                    $user = mysqli_fetch_assoc($get_user);
                    $_SESSION['gg_id'] = $user['gg_id'];
                } else {
                    header('Location: logout.php');
                    exit;
                }
                ?>
                <div class="p-1 ms-auto mt-2"><a href="cart.php">
                        <?php $stmt = $db_connection->prepare('SELECT COUNT(cart_id) as cart_count FROM cart WHERE cart.user_id = ?');
                        $stmt->bind_param('i', $_SESSION['gg_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        ?>
                        <ul class="navbar-right">
                            <?php if ($result) {
                                $row = $result->fetch_assoc();
                                $cartCount = $row['cart_count']; ?>
                                <li><a href="<?= $base_url ?>/carts.php" id="cart"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                                            <path
                                                d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                                        </svg> Cart <span class="badge ms-2">
                                            <?= $cartCount ?>
                                        <?php } else { ?>
                                            0
                                        <?php } ?>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!--end navbar-right -->
                        <?php ?>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="<?= $user['image']; ?>" class="rounded-circle" alt="" width="25px" height="25px">
                        <?php echo $user['fullname']; ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= $base_url ?>/profile.php">profile</a></li>
                        <li><a class="dropdown-item" href="<?= $base_url ?>/orderhistory.php">OrderHistory</a></li>
                        <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">logout</a></li>
                    </ul>
                </div>
            </div>
        <?php } else { ?>
            <div class="p-1">
                <div class="collapse navbar-collapse" id="navbarExample01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <!-- <a type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-bs-whatever="@fat">Sign in</a> -->
                                    <a type="button" class="btn btn-outline-warning" href="Login.php">Sign in</a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        <?php } ?>
        </div>
    </nav>