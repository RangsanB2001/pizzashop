<?php
require 'header.php';
?>
<div class="container">
    <div class="row justify-content-center mt-5 row-cols-2 row-cols-lg-5">
        <div class="col-sm-3">
            <a href="order.php" class="text-decoration-none">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="60" fill="currentColor"
                                    class="bi bi-bookmarks-fill text-white" viewBox="0 0 16 16">
                                    <path
                                        d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4z" />
                                    <path
                                        d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1H4.268z" />
                                </svg>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                $today = date('Y-m-d');
                                $sql = "SELECT COUNT(order_id) as total_order 
                                FROM `order` 
                                WHERE create_order BETWEEN '$today 00:00:00' AND '$today 23:59:59' 
                                AND status_order NOT IN ('ยกเลิก');";
                                $result = $db_connection->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $totalOrderPrice = $row['total_order'];
                                    ?>
                                <p class="text-warning h6">ยอดออเดอร์วันนี้</p>
                                <p class="text-white">
                                    <?= $totalOrderPrice ?> ออเดอร์
                                </p>
                                <?php } else { ?>
                                <p class="text-white h3">ไม่มีออเดอร์</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="60" fill="currentColor"
                                class="bi bi-currency-bitcoin text-white" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 13v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.5v1.25c0 .138.112.25.25.25h1a.25.25 0 0 0 .25-.25V13h.084c1.992 0 3.416-1.033 3.416-2.82 0-1.502-1.007-2.323-2.186-2.44v-.088c.97-.242 1.683-.974 1.683-2.19C11.997 3.93 10.847 3 9.092 3H9V1.75a.25.25 0 0 0-.25-.25h-1a.25.25 0 0 0-.25.25V3h-.573V1.75a.25.25 0 0 0-.25-.25H5.75a.25.25 0 0 0-.25.25V3l-1.998.011a.25.25 0 0 0-.25.25v.989c0 .137.11.25.248.25l.755-.005a.75.75 0 0 1 .745.75v5.505a.75.75 0 0 1-.75.75l-.748.011a.25.25 0 0 0-.25.25v1c0 .138.112.25.25.25L5.5 13zm1.427-8.513h1.719c.906 0 1.438.498 1.438 1.312 0 .871-.575 1.362-1.877 1.362h-1.28V4.487zm0 4.051h1.84c1.137 0 1.756.58 1.756 1.524 0 .953-.626 1.45-2.158 1.45H6.927V8.539z" />
                            </svg>
                        </div>
                        <div class="col-sm-10">
                            <?php
                            $today = date('Y-m-d');
                            $sql = "SELECT SUM(total_price) as total 
                            FROM `order` 
                            WHERE create_order BETWEEN '$today 00:00:00' AND '$today 23:59:59' 
                            AND status_order = 'ออเดอร์เรียบร้อย';";

                            $result = $db_connection->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totalOrderPrice = $row['total'];
                                ?>
                            <p class="text-primary h6">ยอดเงินรวม</p>
                            <p class="text-white">
                               <?= $totalOrderPrice != 0 ? $totalOrderPrice . ' บาท' : '0 บาท' ?>
                            </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <a href="showproduct.php" class="text-decoration-none">
                <div class="card bg-primary-subtle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="60" fill="currentColor"
                                    class="bi bi-card-checklist text-white" viewBox="0 0 16 16">
                                    <path
                                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                    <path
                                        d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                                </svg>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                // $today = date('Y-m-d');
                                $sql = "SELECT COUNT(piza_id) as total FROM `pizza`";
                                $result = $db_connection->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $totalOrderPrice = $row['total'];
                                    ?>
                                <p class="text-primary h6">รายการพิซซ่า</p>
                                <p class="text-primary">
                                    <?= $totalOrderPrice ?> แบบ
                                </p>
                                <?php } else { ?>
                                <p class="text-white h3">ไม่มี</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="showsize.php" class="text-decoration-none">
                <div class="card bg-warning-subtle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 text-wraning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="60" fill="currentColor"
                                    class="bi bi-list-stars text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z" />
                                    <path
                                        d="M2.242 2.194a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.256-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53zm0 4a.27.27 0 0 1 .516 0l.162.53c.035.115.14.194.258.194h.551c.259 0 .37.333.164.493l-.468.363a.277.277 0 0 0-.094.3l.173.569c.078.255-.213.462-.423.3l-.417-.324a.267.267 0 0 0-.328 0l-.417.323c-.21.163-.5-.043-.423-.299l.173-.57a.277.277 0 0 0-.094-.299l-.468-.363c-.206-.16-.095-.493.164-.493h.55a.271.271 0 0 0 .259-.194l.162-.53z" />
                                </svg>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                $sql = "SELECT COUNT(size_id) as total FROM `size`";
                                $result = $db_connection->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $totalOrderPrice = $row['total'];
                                    ?>
                                <p class="text-primary h6">ขนาด</p>
                                <p class="text-primary">
                                    <?= $totalOrderPrice ?> แบบ
                                </p>
                                <?php } else { ?>
                                <p class="text-primary h3">ไม่มี</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="showcrust.php" class="text-decoration-none">
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="60" fill="currentColor"
                                    class="bi bi-blockquote-right text-warning" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6zm0 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11zm10.113-5.373a6.59 6.59 0 0 0-.445-.275l.21-.352c.122.074.272.17.452.287.18.117.35.26.51.428.156.164.289.351.398.562.11.207.164.438.164.692 0 .36-.072.65-.216.873-.145.219-.385.328-.721.328-.215 0-.383-.07-.504-.211a.697.697 0 0 1-.188-.463c0-.23.07-.404.211-.521.137-.121.326-.182.569-.182h.281a1.686 1.686 0 0 0-.123-.498 1.379 1.379 0 0 0-.252-.37 1.94 1.94 0 0 0-.346-.298zm-2.168 0A6.59 6.59 0 0 0 10 6.352L10.21 6c.122.074.272.17.452.287.18.117.35.26.51.428.156.164.289.351.398.562.11.207.164.438.164.692 0 .36-.072.65-.216.873-.145.219-.385.328-.721.328-.215 0-.383-.07-.504-.211a.697.697 0 0 1-.188-.463c0-.23.07-.404.211-.521.137-.121.327-.182.569-.182h.281a1.749 1.749 0 0 0-.117-.492 1.402 1.402 0 0 0-.258-.375 1.94 1.94 0 0 0-.346-.3z" />
                                </svg>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                $sql = "SELECT COUNT(pizdough_id) as total FROM `pizzadough`";
                                $result = $db_connection->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $totalOrderPrice = $row['total'];
                                    ?>
                                <p class="text-white h6">ประเภทแป้ง</p>
                                <p class="text-white ">
                                    <?= $totalOrderPrice ?> แบบ
                                </p>
                                <?php } else { ?>
                                <p class="text-white h3">ไม่มี</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="container-sm mt-3">
    <div class="row p-5">
        <div class="col-sm-12">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
<?php
$sql = "SELECT DATE(create_order) AS sales_date, SUM(total_price) AS daily_sales 
FROM `order`
WHERE status_order = 'ออเดอร์เรียบร้อย' 
GROUP BY DATE(create_order) 
ORDER BY DATE(create_order);
";

$result = $db_connection->query($sql);

if ($result->num_rows > 0) {
    $sales_data = [];
    while ($row = $result->fetch_assoc()) {
        $sales_data[] = [
            'date' => $row['sales_date'],
            'sales' => $row['daily_sales']
        ];
    }
} ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($sales_data, 'date')); ?>,
        datasets: [{
            label: 'ยอดขายรายวัน',
            data: <?php echo json_encode(array_column($sales_data, 'sales')); ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.5)', // สีสำหรับวันที่ 1
                'rgba(255, 99, 132, 0.5)', // สีสำหรับวันที่ 2
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>

</html>