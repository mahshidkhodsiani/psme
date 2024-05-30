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
    <title>گزارش گیری </title>
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

            </div>

            <div class="col-md-8 col-sm-12">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">گزارش گیری : </h3>
                
          
                    


                <div class="card m-2" >
                    <div class="card-body">
                        <h5 class="card-title">اعمال فیلتر</h5>
                        
                        <form method="GET" action="">







                            <div class="row mt-2" style="margin-bottom: 180px;">


                            

                                <div class="col-md-6">
                                    <label for="dates" class="form-label">تاریخ:</label>
                                    <input id="pdpDark" type="text" name="dates" 
                                    class="form-control" autocomplete="off" 
                                        value="<?=  (isset($_GET['dates'])? htmlspecialchars($_GET['dates']) : ''); ?>">

                                </div>



                            </div>



                   
                          

                                <button type="submit" class="btn btn-outline-primary">اعمال فیلترها</button>
                    
                        </form>
                    </div>
                </div>


                <br>






              
             
                
                <div class="table-responsive">
                    <table class="table border border-4 ">
                    
                     


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
                                
                            </tr>
                        </thead>

                        
                        <tbody>
                            <?php
                            // Pagination
                            // $results_per_page = 10; // Number of records per page
                            // if (!isset($_GET['page'])) {
                            //     $page = 1; // Default page
                            // } else {
                            //     $page = $_GET['page'];
                            // }


                            $results_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : 10; // Number of records per page, default is 10
                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Default page
                            $start_from = ($page - 1) * $results_per_page;



                            // $start_from = ($page - 1) * $results_per_page;


                            

                            // Fetch records with filters
                            $sql = "SELECT * FROM products WHERE user = $id_user";



                         
                            if(isset($_GET['dates']) && $_GET['dates'] !== '' ) {
                                $dates = $_GET['dates'];
                                $sql .= " AND date = '$dates'";
                            }
                            
                            
                            $sql .= " ORDER BY id DESC LIMIT $start_from, $results_per_page";


                            $_SESSION['query'] = $sql;




                            // echo $sql;
                            
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $a = $start_from + 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <!-- Table rows -->
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= givePerson($row['user']) ?></td>
                                        <td class="text-center"><?= giveDeviceCode($row['device_number']) ?></td>

                                        <td class="text-center"><?= $row['piece_name'] ?></td>

                                        <?php
                                            $nameData = giveName($row['size']);
                                            if (!empty($nameData) && is_array($nameData)) {
                                                echo '<td class="text-center">' . $nameData['size'] . '</td>';
                                            } else {
                                                // Handle the case where giveName returns an empty array or non-array
                                                echo '<td class="text-center">کاربر خالی وارد کرده</td>';
                                            }
                                        ?>

                                        <td class="text-center">
                                            <?php
                                            if($row['shift']==1){
                                                echo 'روز' ;
                                            }
                                            if($row['shift']==2){
                                                echo 'عصر' ;
                                            }
                                            if($row['shift']==3){
                                                echo 'شب' ;
                                            }
                                            ?>
                                        </td>
                                   
                                        <td class="text-center"><?= $row['date'] ?></td>
                                        <td class="text-center"><?= $row['numbers'] ?></td>
                                 





                                    </tr>
                                    <?php
                                    $a++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>


                </div>








                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1). '&rows=' . $results_per_page;


                    
                          

                            if(isset($_GET['dates']) && $_GET['dates'] !== '' ) {
                                echo '&dates=' . $_GET['dates'];
                            }
                          





                          
                            echo '">قبلی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>';
                        }

                        // Page numbers
                        $sql = "SELECT COUNT(*) AS total FROM products";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_pages = ceil($row["total"] / $results_per_page);

                        // Define how many page numbers to display directly
                        $direct_page_numbers = 3;
                        $start_page = max(1, $page - floor($direct_page_numbers / 2));
                        $end_page = min($total_pages, $start_page + $direct_page_numbers - 1);

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '&rows=' . $results_per_page;
                                
                           
                                if(isset($_GET['dates']) && $_GET['dates'] !== '' ) {
                                    echo '&dates=' . $_GET['dates'];
                                }
                               



                                echo '">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&rows=' . $results_per_page;


                              
                                if(isset($_GET['dates']) && $_GET['dates'] !== '' ) {
                                    echo '&dates=' . $_GET['dates'];
                                }
                               


                                echo '">' . $i . '</a></li>';
                            }
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&rows=' . $results_per_page;



                            if(isset($_GET['dates']) && $_GET['dates'] !== '' ) {
                                echo '&dates=' . $_GET['dates'];
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



