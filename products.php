<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت محصولات تولید شده</title>
    <?php 
    include 'includes.php';
    include 'config.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</style>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 d-flex">
                <?php
                include 'sidebar.php';
                ?>
                <button class="btn btn-primary bg-primary" onclick="showSidebar()" style="height: 50px;">
                ||| 
                </button>
            </div>

            <div class="col-md-8 col-sm-12">
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">مدیریت محصولات تولید شده : </h3>
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">نام دستگاه</th>
                            <th scope="col">کد دستگاه</th>
                            <th scope="col">اسم محصول</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Pagination
                        $results_per_page = 10; // Number of records per page
                        if (!isset($_GET['page'])) {
                            $page = 1; // Default page
                        } else {
                            $page = $_GET['page'];
                        }
                        $start_from = ($page - 1) * $results_per_page;

                        // Fetch records
                        $sql = "SELECT * FROM products LIMIT $start_from, $results_per_page";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = $start_from + 1;
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <th scope="row"><?= $a ?></th>
                                    <td><?= $row['device_name'] ?></td>
                                    <td><?= $row['device_number'] ?></td>
                                    <td><?= $row['piece_name'] ?></td>
                                </tr>
                        <?php
                                $a++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">قبلی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>';
                        }

                        // Page numbers
                        $sql = "SELECT COUNT(*) AS total FROM products";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_pages = ceil($row["total"] / $results_per_page);
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">بعدی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">بعدی</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>

        </div> 
    </div>
    

    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });

        function showSidebar() {
            var sidebar = document.getElementById('sidebarMenu');
            if (sidebar.style.display === 'none' || sidebar.style.display === '') {
                sidebar.style.display = 'block'; // Show the sidebar
            } else {
                console.log('close') ;
                // sidebar.style.display = 'none'; // Hide the sidebar
                sidebar.setAttribute('style', 'display: none !important;')
            }
        }

    </script>
</body>
</html>

