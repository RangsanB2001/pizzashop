<?php
require '../confing.php';
session_start(); // Start a session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the entered password for comparison with the stored password
    $hashedPassword = md5($password);

    // SQL query to check the username and hashed password
    $sql = "SELECT * FROM `seller` WHERE `sel_username` = '$username' AND `sel_password` = '$hashedPassword'";

    $result = $db_connection->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc(); // Fetch the seller's data
        $_SESSION["username"] = $row["sel_username"];
        $_SESSION["userid"] = $row["seller_id"];
        echo "<script>
        alert('เข้าสู่ระบบสำเร็จ'); // Change the message
        window.location.href = '$base_urls/index.php';
        </script>";
        exit();
    } else {
        echo "<script>
        alert('username หรือ รหัสผ่านไม่ถูกต้อง!!'); // Change the message
        window.location.href = '$base_urls/login.php';
      </script>";
    }
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
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Roboto:ital@1&family=Sarabun:wght@100&display=swap"
        rel="stylesheet">
    <title>เพิ่มรายการพิซซ่า</title>
</head>

<body style="background-image: url('../images/image_3.jpg'); background-size: cover;">
    <div class="container pt-5 mt-5">
        <section class="bg-success p-2">
            <h1 class="text-lowercase text-warning text-center">LOGIN SELLER</h1>
        </section>
        <div class="row justify-content-center mt-3">
            <div class="col-sm-6">
                <form action="login.php" method="post">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label text-warning h3" for="form2Example1">Username</label>
                        <input type="text" id="form2Example1" placeholder="enter username" name="username"
                            class="form-control" required />

                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label text-warning h3" for="form2Example2">Password</label>
                        <input type="password" id="form2Example2" placeholder="enter password" name="password"
                            class="form-control" required />

                    </div>
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4 w-100">Log in</button>

                    <!-- Register buttons -->
                    <!-- <div class="text-center">
                    <p>Not a member? <a href="#!">Register</a></p>
                    <p>or sign up with:</p>
                    <button type="button" class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-facebook-f"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-google"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-twitter"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-github"></i>
                    </button>
                </div> -->
                </form>
            </div>
        </div>
    </div>
</body>

</html>