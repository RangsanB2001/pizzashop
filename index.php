<?php require 'haeder.php';
$sql = "SELECT * FROM pizza";
$result = $db_connection->query($sql);
?>
<!--Main Navigation-->
<header>
    <!-- Navbar -->
    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/Baner_1.jpg" class="d-md-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/Baner_2.jpg" class="d-md-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="images/Baner_3.jpg" class="d-md-block w-100" alt="...">
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
        <?php
        if ($result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-6">
                    <div class="p-2">
                        <div class="card">
                            <a class="text-decoration-none" href="detail.php?id=<?= $row['piza_id'] ?>">
                                <img src="images/<?= $row['piz_image'] ?>" class="card-img-top md-2" alt="...">
                                <div class="card-footer">
                                    <p class="card-text">
                                        <?= $row['piz_name'] ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
        } ?>

    </div>
</div>
<?php require 'footer.php' ?>