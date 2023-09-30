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

    <link rel="stylesheet" href="../css/style.css">
    <title>PungKungPizza</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary " data-bs-theme="dark" style="z-index: 2000;">
        <div class="container hstack gap-3">
            <!-- Navbar brand -->
            <a class="navbar-brand fs-3 fw-700 text-warning" href="#">PungKungPizza</a>
            <div class="p-2 ms-auto"><a href="cart.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-cart" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                    <span class="badge text-bg-secondary">4</span>
                </a>
            </div>
            <div class="p-2">
                <div class="collapse navbar-collapse" id="navbarExample01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="btn btn-outline-warning" aria-current="page" href="SingIn.php">Sign in</a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!--Main Navigation-->
    <header>
        <!-- Navbar -->
        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../images/image_6.jpg" class="d-inline" alt="..." width="1500px" height="600px">
                </div>
                <div class="carousel-item">
                    <img src="../images/image_2.jpg" class="d-inline" alt="..." width="1500px" height="600px">
                </div>
                <div class="carousel-item">
                    <img src="../images/image_3.jpg" class="d-inline" alt="..." width="1500px" height="600px">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>
    <!--Main Navigation-->
    <section class="container text-center mt-3">
        <h1>List Menu</h1>
    </section>
    <div class="container text-center mt-3">
        <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2">
            <div class="col-md-6">
                <div class="p-2">
                    <div class="card">
                        <a class="text-decoration-none" href="details.php">
                            <img src="../images/pizza-1.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">พิซซ่าหน้าฮาวายเอียน</p>
                            </div>
                            <div class="card-footer">
                                <p>ราคา</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-2">
                    <div class="card">
                        <a class="text-decoration-none" href="details.php">
                            <img src="../images/pizza-1.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-text">พิซซ่าหน้าฮาวายเอียน</p>
                            </div>
                            <div class="card-footer">
                                <p>ราคา</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/cart.js"></script>
</body>

</html>