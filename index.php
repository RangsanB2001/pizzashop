<?php require 'haeder.php' ?>
<!--Main Navigation-->
<header>
    <!-- Navbar -->
    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/image_6.jpg" class="d-inline" alt="..." width="1500px" height="500px">
                <div class="carousel-caption d-none d-md-block">
                    <h5>PangKungPizza</h5>
                    <p>Welcome to welcome customers to Pang Kung Pizza.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/image_2.jpg" class="d-inline" alt="..." width="1500px" height="500px">
            </div>
            <div class="carousel-item">
                <img src="images/image_3.jpg" class="d-inline" alt="..." width="1500px" height="500px">
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
<section class="container-fluid text-center mt-3 bg-warning">
    <h1 class="text-white">List Menu</h1>
</section>
<div class="container text-center mt-3">
    <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2">
        <div class="col-md-6">
            <div class="p-2">
                <div class="card">
                    <a class="text-decoration-none" href="details.php">
                        <img src="images/pizza-1.jpg" class="card-img-top" alt="...">
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
                        <img src="images/pizza-1.jpg" class="card-img-top" alt="...">
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
<?php
require 'google-api/vendor/autoload.php';
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);

$client->setRedirectUri('http://localhost/PizzaShop/index.php');

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
    // Google Login Url = $client->createAuthUrl();
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
<?php require 'footer.php' ?>