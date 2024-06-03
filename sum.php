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
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include 'config.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 d-flex">
                <?php
                include 'sidebar.php';
                ?>
               
            </div>

            <div class="col-md-8 col-sm-12">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">مدیریت محصولات تولید شده : </h3>






                <div class="row">
                    <div class="col-md-6 m-3">
                        <form method="GET" action="">
                            <label>بر اساس شخص :</label>
                            <select class="form-select" name="filter_person" id="filter_person">
                                <option value="">تنظیم جدول بر اساس</option>
                                <?php
                                $sql = "SELECT * FROM users";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . ' ' . $row['family'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <button class="btn btn-primary" type="submit">اعمال فیلتر</button>
                        </form>
                    </div>
                </div>


                <script>
                    // JavaScript to submit the form when a new option is selected
                    document.getElementById('filter_person').addEventListener('change', function() {
                        this.form.submit();
                    });
                </script>





                <div class="row">
                    <div class="col-md-10 col-sm-12">
                        <table class="table border">
                            <thead>
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col">اسم محصول</th>
                                    <th scope="col">سایز محصول</th>
                                    <th scope="col">قیمت</th>
                                    <th scope="col">تعداد یک روز</th>
                                    <th scope="col">جمع قیمت در یک روز</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                // Applying filters if they are set
                                $filter_person = isset($_GET['filter_person']) ? $_GET['filter_person'] : '';






                                // Pagination
                                $results_per_page = 10; // Number of records per page
                                if (!isset($_GET['page'])) {
                                    $page = 1; // Default page
                                } else {
                                    $page = $_GET['page'];
                                }
                                $start_from = ($page - 1) * $results_per_page;




                                if ($filter_person) {
                                    $sql = "SELECT p.*, pieces.price as price
                                    FROM products p
                                    LEFT JOIN pieces ON p.piece_name = pieces.name AND p.size = pieces.size
                                    WHERE p.user = '$filter_person'
                                    LIMIT $start_from, $results_per_page";
                                } else {
                                    $sql = "SELECT p.*, pieces.price as price
                                    FROM products p
                                    LEFT JOIN pieces ON p.piece_name = pieces.name AND p.size = pieces.size
                                    LIMIT $start_from, $results_per_page";
                                }




                                $result = $conn->query($sql);



                                if ($result->num_rows > 0) {
                                    $a = $start_from + 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $total_price_per_day = $row['price'] * $row['numbers'];
                                ?>
                                        <tr>
                                            <th scope="row"><?= $a ?></th>
                                            <td><?= $row['piece_name'] ?></td>
                                            <td><?= $row['size'] ?></td>
                                            <td><?= $row['price'] ?></td>
                                            <td><?= $row['numbers'] ?></td>
                                            <td><?= number_format($total_price_per_day) . " تومان" ?></td>
                                        </tr>
                                <?php
                                        $a++;
                                    }
                                }
                                ?>

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

        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });

      
    </script>
</body>

</html>