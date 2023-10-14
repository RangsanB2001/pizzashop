<?php
require 'confing.php';
require 'google-api/vendor/autoload.php';
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);

$client->setRedirectUri('http://localhost/PizzaShop/Login.php');

$client->addScope("email");
$client->addScope("profile");
if (isset($_GET['code'])):
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token["error"])) {
        $client->setAccessToken($token['access_token']);
        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        // Storing data into database
        $id = mysqli_real_escape_string($db_connection, $google_account_info->id);
        $full_name = mysqli_real_escape_string($db_connection, trim($google_account_info->name));
        $email = mysqli_real_escape_string($db_connection, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);
        // checking user already exists or not
        $get_user = mysqli_query($db_connection, "SELECT `gg_id` FROM `user` WHERE `gg_id`='$id'");
        if (mysqli_num_rows($get_user) > 0) {
            $_SESSION['login_id'] = $id;
            echo "<script>
                alert('Login successful'); // Change the message
                window.location.href = 'index.php';
              </script>";
            exit;
        } else {
            // if user not exists we will insert the user
            $insert = mysqli_query($db_connection, "INSERT INTO `user` (`fullname`,`email`,`image`, `gg_id`) VALUES('$full_name','$email','$profile_pic','$id')");
            if ($insert) {
                $_SESSION['login_id'] = $id;
                echo "<script>
                alert('Login successful'); // Change the message
                window.location.href = 'index.php';
              </script>";
                exit;
            } else {
                echo "<script>
                alert('Login Not success!');
                window.location.href = 'index.php';
              </script>";
            }
        }
    }
    ;
else:
    ?>
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">SingIn with Google</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container text-center">
                    <h2 class="heading">Login</h2>
                </div>
                <div class="container text-center">
                    <a type="button" class="btn btn-primary" href="<?php echo $client->createAuthUrl(); ?>">
                        Sign in with Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
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
    <title>Login</title>
    <style>
    body {
        background-image: url('images/PANGKUNG.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    </style>
</head>

<body>

    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="container mt-5">
            <div class="row">
                <div class="card-header">
                    <h1 class="text-center text-light">เข้าสู่ระบบ</h1>
                </div>
                <div class="col-md-12 bs-emphasis-color">
                    <div class="card">
                        <div class="card body">
                            <a type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-whatever="@fat">Sign in</a>
                        </div>
                    </div>
                    <a href="index.php" class="h4 text-center text-warning mt-2">หน้าแสดงรายการ</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>