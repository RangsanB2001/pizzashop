<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!-- Create a styles.css file for your custom styles -->

    <title>PungKungPizza</title>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark" style="z-index: 2000;">
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
                                    <a class="btn btn-outline-warning" aria-current="page" href="SignIn.php">Sign in</a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Pizza Ordering Form -->
    <div class="container mt-5">
        <h1 class="text-center">Pizza Ordering System</h1>
        <form id="pizza-order-form" class="mt-4">
            <!-- Select Pizza Type -->
            <div class="mb-3">
                <label for="pizza-type" class="form-label">Select Pizza Type:</label>
                <select id="pizza-type" name="pizza-type" class="form-select">
                    <option value="margherita">Margherita</option>
                    <option value="pepperoni">Pepperoni</option>
                    <option value="veggie">Veggie</option>
                    <!-- Add more pizza options as needed -->
                </select>
            </div>

            <!-- Select Pizza Size -->
            <div class="mb-3">
                <label class="form-label">Select Pizza Size:</label>
                <div class="form-check">
                    <input type="radio" id="small" name="pizza-size" value="small" class="form-check-input">
                    <label for="small" class="form-check-label">Small</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="medium" name="pizza-size" value="medium" class="form-check-input">
                    <label for="medium" class="form-check-label">Medium</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="large" name="pizza-size" value="large" class="form-check-input">
                    <label for="large" class="form-check-label">Large</label>
                </div>
            </div>

            <!-- Select Pizza Crust -->
            <div class="mb-3">
                <label for="pizza-crust" class="form-label">Select Pizza Crust:</label>
                <select id="pizza-crust" name="pizza-crust" class="form-select">
                    <option value="thin">Thin Crust</option>
                    <option value="pan">Pan Crust</option>
                    <option value="stuffed">Stuffed Crust</option>
                    <!-- Add more crust options as needed -->
                </select>
            </div>

            <!-- Add to Cart Button -->
            <button type="button" onclick="addToCart()" class="btn btn-warning">Add to Cart</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/cart.js"></script>
</body>

</html>
