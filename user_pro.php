<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["all_data"]['id'];

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مرور محصولات </title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include 'config.php';
    include 'functions.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link href="persianDate/css/prism.css" rel="stylesheet" />
    <link rel="stylesheet" href="persianDate/css/persianDatepicker-default.css" />
    <link rel="stylesheet" href="persianDate/css/persianDatepicker-dark.css" />
    <link rel="stylesheet" href="persianDate/css/persianDatepicker-latoja.css" />
    <link rel="stylesheet" href="persianDate/css/persianDatepicker-melon.css" />
    <link rel="stylesheet" href="persianDate/css/persianDatepicker-lightorang.css" />
    <script src="persianDate/js/prism.js"></script>
    <script src="persianDate/js/vertical-responsive-menu.min.js"></script>




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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم مرور محصولات : </h3>
                
          
                    


                <div class="card m-2" >
                    <div class="card-body">
                        <h5 class="card-title">اعمال فیلتر</h5>
                        
                        <form method="GET" action="">







                            <div class="row mt-2" style="margin-bottom: 180px;">


                            

                                <div class="col-md-6">
                                    <label for="from_date" class="form-label">از تاریخ:</label>
                                    <input id="pdpDark" type="text" name="from_date" 
                                    class="form-control" autocomplete="off" 
                                        value="<?=  (isset($_GET['from_date'])? htmlspecialchars($_GET['from_date']) : ''); ?>">

                                </div>
                                <div class="col-md-6">
                                    <label for="until_date" class="form-label">تا تاریخ:</label>
                                    <input id="pdpLatoja" type="text" name="until_date" 
                                    class="form-control" autocomplete="off" 
                                        value="<?=  (isset($_GET['until_date'])? htmlspecialchars($_GET['until_date']) : ''); ?>">

                                </div>



                            </div>



                   
                          

                                <button type="submit" class="btn btn-outline-primary">اعمال فیلترها</button>
                    
                        </form>
                    </div>
                </div>


                <br>






              
             
                
                <?php
                // Pagination and results per page
                $results_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : 10; // Number of records per page, default is 10
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Default page

                // Calculate the starting point for fetching records
                $start_from = ($page - 1) * $results_per_page;

                // Build the SQL query for counting total filtered records
                $sql_count = "SELECT COUNT(*) AS total FROM products WHERE user = $id_user";

                // Apply filters for from_date and until_date if set
                if(isset($_GET['from_date']) && $_GET['from_date'] !== '') {
                    $from_date = $_GET['from_date'];
                    // Properly escape $from_date to prevent SQL injection
                    $sql_count .= " AND date >= '$from_date'";
                }

                if(isset($_GET['until_date']) && $_GET['until_date'] !== '') {
                    $until_date = $_GET['until_date'];
                    // Properly escape $until_date to prevent SQL injection
                    $sql_count .= " AND date <= '$until_date'";
                }

                // Execute the query to get total number of filtered records
                $result_count = $conn->query($sql_count);
                $row_count = $result_count->fetch_assoc();
                $total_records = $row_count["total"];

                // Calculate total pages based on total records and results per page
                $total_pages = ceil($total_records / $results_per_page);

                // Build the main SQL query to fetch paginated records with filters
                $sql_data = "SELECT * FROM products WHERE user = $id_user";

                // Apply filters for from_date and until_date if set
                if(isset($_GET['from_date']) && $_GET['from_date'] !== '') {
                    $from_date = $_GET['from_date'];
                    $sql_data .= " AND date >= '$from_date'";
                }

                if(isset($_GET['until_date']) && $_GET['until_date'] !== '') {
                    $until_date = $_GET['until_date'];
                    $sql_data .= " AND date <= '$until_date'";
                }

                $sql_data .= " ORDER BY id DESC LIMIT $start_from, $results_per_page";

                // Store the SQL query in session for other uses
                $_SESSION['query'] = $sql_data;

                // Execute the main query to fetch paginated records
                $result_data = $conn->query($sql_data);
                ?>

                <!-- Table structure -->
                <div class="table-responsive">
                    <table class="table border border-4">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ردیف</th>
                                <th scope="col" class="text-center">نام شخص</th>
                                <th scope="col" class="text-center">کد دستگاه</th>
                                <th scope="col" class="text-center">نام قطعه</th>
                                <th scope="col" class="text-center">سایز قطعه</th>
                                <th scope="col" class="text-center">شیفت</th>
                                <th scope="col" class="text-center">تاریخ</th>
                                <th scope="col" class="text-center">تعداد</th>
                                <th scope="col" class="text-center">وضعیت محصول</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Display records in table rows
                            if ($result_data->num_rows > 0) {
                                $a = $start_from + 1;
                                while ($row = $result_data->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center">
                                            <a href="product.php?id_pro=<?= $row['id'] ?>" style="text-decoration: none; color: black">
                                                <?= givePerson($row['user']) ?>
                                            </a>
                                        </td>
                                        <td class="text-center"><?= giveDeviceCode($row['device_number']) ?></td>
                                        <td class="text-center"><?= $row['piece_name'] ?></td>
                                        <?php
                                        $nameData = giveName($row['size']);
                                        if (!empty($nameData) && is_array($nameData)) {
                                            echo '<td class="text-center">' . $nameData['size'] . '</td>';
                                        } else {
                                            echo '<td class="text-center">کاربر خالی وارد کرده</td>';
                                        }
                                        ?>
                                        <td class="text-center">
                                            <?php
                                            if ($row['shift'] == 1) {
                                                echo 'روز';
                                            } elseif ($row['shift'] == 2) {
                                                echo 'عصر';
                                            } elseif ($row['shift'] == 3) {
                                                echo 'شب';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?= $row['date'] ?></td>
                                        <td class="text-center"><?= $row['numbers'] ?></td>
                                        <td class="text-center" <?php if($row['status']==2){?> onclick="showReason(<?= $row['id'] ?>)" <?php } ?>>
                                            <?php
                                            if ($row['status'] == 0) {
                                                echo 'در انتظار تایید';
                                            } elseif ($row['status'] == 1) {
                                                echo 'تایید شده';
                                            } elseif ($row['status'] == 2) {
                                                echo 'رد شده';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $a++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&rows=' . $results_per_page;
                            if (isset($_GET['from_date']) && $_GET['from_date'] !== '') {
                                echo '&from_date=' . $_GET['from_date'];
                            }
                            if (isset($_GET['until_date']) && $_GET['until_date'] !== '') {
                                echo '&until_date=' . $_GET['until_date'];
                            }
                            echo '">قبلی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>';
                        }

                        // Page numbers
                        $direct_page_numbers = 3; // Number of direct page links to show
                        $start_page = max(1, $page - floor($direct_page_numbers / 2));
                        $end_page = min($total_pages, $start_page + $direct_page_numbers - 1);

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '&rows=' . $results_per_page;
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&rows=' . $results_per_page;
                            }
                            if (isset($_GET['from_date']) && $_GET['from_date'] !== '') {
                                echo '&from_date=' . $_GET['from_date'];
                            }
                            if (isset($_GET['until_date']) && $_GET['until_date'] !== '') {
                                echo '&until_date=' . $_GET['until_date'];
                            }
                            echo '">' . $i . '</a></li>';
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&rows=' . $results_per_page;
                            if (isset($_GET['from_date']) && $_GET['from_date'] !== '') {
                                echo '&from_date=' . $_GET['from_date'];
                            }
                            if (isset($_GET['until_date']) && $_GET['until_date'] !== '') {
                                echo '&until_date=' . $_GET['until_date'];
                            }
                            echo '">بعدی</a></li>';
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
    </script>


    <script>
        function showReason(){

        }
    </script>

    <script src="persianDate/js/persianDatepicker.js"></script>

    <script>
        $(function() {
            //usage
            $(".usage").persianDatepicker();

            //themes
            $("#pdpDefault").persianDatepicker({
                alwaysShow: true,
            });
            $("#pdpLatoja").persianDatepicker({
                theme: "latoja",
                alwaysShow: true,
            });
            $("#pdpLightorang").persianDatepicker({
                theme: "lightorang",
                alwaysShow: true,
            });
            $("#pdpMelon").persianDatepicker({
                theme: "melon",
                alwaysShow: true,
            });



            $("#pdpDark").persianDatepicker({
                theme: "dark",
                alwaysShow: true,
            });


            //size
            $("#pdpSmall").persianDatepicker({
                cellWidth: 14,
                cellHeight: 12,
                fontSize: 8
            });
            $("#pdpBig").persianDatepicker({
                cellWidth: 78,
                cellHeight: 60,
                fontSize: 18
            });

            //formatting
            $("#pdpF1").persianDatepicker({
                formatDate: "YYYY/MM/DD 0h:0m:0s:ms"
            });
            $("#pdpF2").persianDatepicker({
                formatDate: "YYYY-0M-0D"
            });
            $("#pdpF3").persianDatepicker({
                formatDate: "YYYY-NM-DW|ND",
                isRTL: !0
            });

            //startDate & endDate
            $("#pdpStartEnd").persianDatepicker({
                startDate: "1394/11/12",
                endDate: "1395/5/5"
            });
            $("#pdpStartToday").persianDatepicker({
                startDate: "today",
                endDate: "1410/11/5"
            });
            $("#pdpEndToday").persianDatepicker({
                startDate: "1397/11/12",
                endDate: "today"
            });

            //selectedBefor & selectedDate
            $("#pdpSelectedDate").persianDatepicker({
                selectedDate: "1404/1/1",
                alwaysShow: !0
            });
            $("#pdpSelectedBefore").persianDatepicker({
                selectedBefore: !0
            });
            $("#pdpSelectedBoth").persianDatepicker({
                selectedBefore: !0,
                selectedDate: "1395/5/5"
            });

            //jdate & gdate attributes
            $("#pdp-data-jdate").persianDatepicker({
                onSelect: function() {
                    alert($("#pdp-data-jdate").attr("data-gdate"));
                }
            });
            $("#pdp-data-gdate").persianDatepicker({
                showGregorianDate: true,
                onSelect: function() {
                    alert($("#pdp-data-gdate").attr("data-jdate"));
                }
            });


            //Gregorian date
            $("#pdpGregorian").persianDatepicker({
                showGregorianDate: true
            });



            //startDate is tomarrow
            var p = new persianDate();
            $("#pdpStartDateTomarrow").persianDatepicker({
                startDate: p.now().addDay(1).toString("YYYY/MM/DD"),
                endDate: p.now().addDay(4).toString("YYYY/MM/DD")
            });


        });
    </script>






   
</body>

</html>



