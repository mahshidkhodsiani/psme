<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}



// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// trigger_error("Test error", E_USER_NOTICE);


?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش گیری از پرسنل</title>
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





                <div class="card m-2">
                    <div class="card-body">
                        <h5 class="card-title">اعمال فیلتر</h5>

                        <form method="GET" action="">


                            <div class="row">

                                <div class="col-md-6">
                                    <label for="personel" class="form-label">پرسنل:</label>
                                    <select class="form-select" name="personel">
                                        <option value="">همه</option>
                                        <?php
                                        $sql = "SELECT * FROM users";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { ?>

                                                <option value="<?= $row['id'] ?>" <?php if (isset($_GET['personel']) && $_GET['personel'] === $row['id']) echo 'selected'; ?>>
                                                    <?= $row['name'] . " " . $row['family'] ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="device_code" class="form-label">کد دستگاه:</label>
                                    <select class="form-select" name="device_code">
                                        <option value="">همه</option>
                                        <?php
                                        $sql = "SELECT * FROM devices";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { ?>

                                                <option value="<?= $row['id'] ?>" <?php if (isset($_GET['device_code']) && $_GET['device_code'] === $row['id']) echo 'selected'; ?>>
                                                    <?= $row['numbers'] ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>




                            </div>


                            <div class="row mt-2">

                                <div class="col-md-6">
                                    <label for="piece_name" class="form-label">نام قطعه:</label>
                                    <!-- <select class="form-select" id="piece_name" name="piece_name" onchange="getSizes()"> -->
                                    <select class="form-select" id="piece_name" name="piece_name" >
                                        <option value="">همه</option>
                                        <?php
                                        $sql = "SELECT DISTINCT name FROM pieces";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { ?>

                                                <option value="<?= $row['name'] ?>" <?php if (isset($_GET['piece_name']) && $_GET['piece_name'] === $row['name']) echo 'selected'; ?>>
                                                    <?= $row['name'] ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>



                                <!-- این برای وقتی که قطعه و سایز بهم مربوط بودند -->
                                <!-- <div class="col-md-6">
                                    <label for="piece_size" class="form-label">سایز قطعه:</label>
                                    <select class="form-select" name="piece_size" id="piece_size">
                                        <option value="" selected>ابتدا نام قطعه را وارد کنید</option>
                                    </select>
                                </div> -->





                                <div class="col-md-6">
                                    <label for="size" class="form-label fw-semibold">سایز قطعه</label>
                                    <!-- <select name="size" id="size_piece" class="form-select" aria-label="Default select example">
                                        <option value="" selected>یکی از سایزهای زیر را انتخاب کنید</option>
                                
                                    </select> -->
                                    <!-- <select name="size" id="size" class="form-select" aria-label="Default select example"> -->
                                    <select class="form-select" name="piece_size" id="piece_size">
                                        <option value="" >همه</option>
                                        <?php
                                        $sql = "SELECT * FROM piece_size";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['size'] ?></option>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>


                            </div>





                            <div class="row mt-2" style="margin-bottom: 180px;">


                                <div class="col-md-6" style="margin-bottom: 150px;">
                                    <label for="dates" class="form-label">از تاریخ:</label>
                                    <input id="pdpDark" type="text" name="dates" class="form-control" autocomplete="off" value="<?= (isset($_GET['dates']) ? htmlspecialchars($_GET['dates']) : ''); ?>">

                                </div>



                                <div class="col-md-6">
                                    <label for="until_date" class="form-label">تا تاریخ:</label>
                                    <input id="pdpLatoja" type="text" name="until_date" class="form-control" autocomplete="off" value="<?= (isset($_GET['until_date']) ? htmlspecialchars($_GET['until_date']) : ''); ?>">

                                </div>



                            </div>






                            <button type="submit" class="btn btn-outline-primary">اعمال فیلترها</button>

                        </form>
                    </div>
                </div>


                <br>


                <div class="row">
                    <div class="col-md-6">
                        <form action="export_exel.php" method="post">
                            <button class="btn btn-outline-success" name="get_excel">خروجی اکسل</button>
                        </form>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>






                <br>







                <div class="table-responsive">
                    <table class="table border border-4 ">
                        <!-- Select dropdown for number of rows per page -->
                        <select id="rowsPerPage" onchange="changeRowsPerPage()">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="100">100</option>
                        </select>

                        <script>
                            function changeRowsPerPage() {
                                var selectedValue = document.getElementById("rowsPerPage").value;
                                window.location.href = 'personnels_review.php?rows=' + selectedValue;
                            }
                        </script>


                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ردیف</th>
                                <th scope="col" class="text-center">نام شخص</th>
                                <th scope="col" class="text-center">کد دستگاه</th>
                                <th scope="col" class="text-center"> قطعه</th>
                                <th scope="col" class="text-center">سایز قطعه</th>
                                <th scope="col" class="text-center">شیفت</th>
                                <th scope="col" class="text-center">تاریخ</th>
                                <th scope="col" class="text-center">زمان تولید</th>
                                <th scope="col" class="text-center">زمان مجاز</th>
                                <th scope="col" class="text-center">میزان تاخیر</th>

                                <th scope="col" class="text-center">تعداد</th>
                                <th scope="col" class="text-center">قیمت واحد</th>
                                <th scope="col" class="text-center">قیمت(تومان)</th>

                            </tr>
                        </thead>


                        <tbody>
                            <?php
                       


                            $results_per_page = isset($_GET['rows']) ? intval($_GET['rows']) : 10; // Number of records per page, default is 10
                            $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Default page
                            $start_from = ($page - 1) * $results_per_page;



                            // $start_from = ($page - 1) * $results_per_page;




                            // Fetch records with filters
                            $sql = "SELECT * FROM products WHERE status = 1 AND user_confirm = 1";



                            if (
                                isset($_GET['personel']) && $_GET['personel'] !== ''
                                && $_GET['dates'] === '' && $_GET['device_code'] === ''
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $personel = $_GET['personel'];
                                $sql .= " AND user = $personel";
                            }
                            if (
                                isset($_GET['dates']) && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === ''
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d')";
                            }
                            if (
                                isset($_GET['until_date']) && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === ''
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                $until_date = $_GET['until_date'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                            }

                            if (
                                isset($_GET['device_code']) && $_GET['device_code'] !== ''
                                && $_GET['personel'] === ''  && $_GET['dates'] === ''
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $sql .= " AND device_number = $device_code";
                            }
                            if (
                                isset($_GET['piece_name']) && $_GET['piece_name'] !== ''
                                && $_GET['personel'] === ''  && $_GET['dates'] === ''
                                && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND piece_name = '$piece_name'";
                            }
                            if (
                                isset($_GET['piece_size']) && $_GET['piece_size'] !== ''
                                && $_GET['personel'] === ''  && $_GET['dates'] === ''
                                && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND size = '$piece_size'";
                            }




                            if (
                                isset($_GET['personel'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_name'] === ''
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $personel = $_GET['personel'];
                                $sql .= " AND user = $personel AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d')";
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['dates'] === '' && $_GET['piece_name'] === ''
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $personel = $_GET['personel'];
                                $sql .= " AND user = $personel AND device_number = '$device_code'";
                            }
                            if (
                                isset($_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['dates'] === '' &&  $_GET['device_code'] === ''
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $personel = $_GET['personel'];
                                $sql .= " AND user = $personel AND piece_name = '$piece_name'";
                            }
                            if (
                                isset($_GET['device_code'], $_GET['piece_name'])
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['dates'] === '' &&  $_GET['personel'] === ''
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $device_code = $_GET['device_code'];
                                $sql .= " AND device_number = '$device_code' AND piece_name = '$piece_name'";
                            }
                            if (
                                isset($_GET['dates'], $_GET['device_code'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_name'] === ''
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code'";
                            }
                            if (
                                isset($_GET['dates'], $_GET['piece_name'])
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === ''
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND piece_name = '$piece_name'";
                            }
                            if (
                                isset($_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === ''
                                && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND size = '$piece_size' AND piece_name = '$piece_name'";
                            }

                            if (
                                isset($_GET['until_date'], $_GET['personel'])
                                && $_GET['until_date'] !== '' && $_GET['personel'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['device_code'] === ''
                                && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                            ) {
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $sql .= " AND user = '$personel' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'])
                                && $_GET['until_date'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['personel'] === ''
                                && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                            ) {
                                $until_date = $_GET['until_date'];
                                $device_code = $_GET['device_code'];
                                $sql .= " AND device_number = '$device_code' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_name'])
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['device_code'] === '' && $_GET['personel'] === ''
                                && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                            ) {
                                $until_date = $_GET['until_date'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND piece_name = '$piece_name' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_size'])
                                && $_GET['until_date'] !== '' && $_GET['piece_size'] !== ''
                                && $_GET['device_code'] === '' && $_GET['personel'] === ''
                                && $_GET['dates'] === '' && $_GET['piece_name'] === ''
                            ) {
                                $until_date = $_GET['until_date'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND size = '$piece_size' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'])
                                && $_GET['until_date'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['personel'] === ''
                                && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                            ) {
                                $until_date = $_GET['until_date'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                            }







                            if (
                                isset($_GET['piece_name'], $_GET['device_code'], $_GET['personel'])
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['personel'] !== '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $piece_name = $_GET['piece_name'];
                                $personel = $_GET['personel'];
                                $sql .= " AND piece_name = '$piece_name' AND device_number = '$device_code' AND user = $personel ";
                            }

                            if (
                                isset($_GET['dates'], $_GET['device_code'], $_GET['personel'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $dates = $_GET['dates'];
                                $personel = $_GET['personel'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND user = $personel ";
                            }

                            if (
                                isset($_GET['dates'], $_GET['piece_name'], $_GET['personel'])
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] !== '' && $_GET['device_code'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['until_date'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $dates = $_GET['dates'];
                                $personel = $_GET['personel'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND piece_name = '$piece_name' AND user = $personel ";
                            }

                            if (
                                isset($_GET['dates'], $_GET['device_code'], $_GET['piece_name'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $dates = $_GET['dates'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND piece_name = '$piece_name' ";
                            }
                            if (
                                isset($_GET['personel'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['dates'] === '' 
                                && $_GET['device_code'] === ''  && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND user = $personel AND size = '$piece_size' AND piece_name = '$piece_name' ";
                            }
                            if (
                                isset($_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['dates'] === '' 
                                && $_GET['personel'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $device_code = $_GET['device_code'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND device_number = '$device_code' AND size = '$piece_size' AND piece_name = '$piece_name' ";
                            }
                            if (
                                isset($_GET['dates'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] === '' 
                                && $_GET['personel'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $dates = $_GET['dates'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND size = '$piece_size' AND piece_name = '$piece_name' ";
                            }

                            if (
                                isset($_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] === '' 
                                && $_GET['personel'] === '' && $_GET['dates'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $until_date = $_GET['until_date'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND size = '$piece_size' AND piece_name = '$piece_name' ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'])
                                && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['dates'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND device_number = '$device_code' AND user = $personel ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['personel'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['device_code'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND user = $personel ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['device_code'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['personel'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $device_code = $_GET['device_code'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND device_number = $device_code ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['piece_name'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['device_code'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND piece_name = $piece_name ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_name'], $_GET['personel'])
                                && $_GET['piece_name'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] !== '' && $_GET['device_code'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['dates'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND piece_name = '$piece_name' AND user = $personel ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_name'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] !== '' && $_GET['personel'] === '' 
                                && $_GET['piece_size'] === ''  && $_GET['dates'] === ''
                            ) {
                                $piece_name = $_GET['piece_name'];
                                $until_date = $_GET['until_date'];
                                $device_code = $_GET['device_code'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND piece_name = '$piece_name' AND device_number = '$device_code' ";
                            }









                            if (
                                isset($_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['personel'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                                && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $device_code = $_GET['device_code'];
                                $piece_name = $_GET['piece_name'];
                                $personel = $_GET['personel'];
                                $sql .= " AND device_number = '$device_code' AND size = '$piece_size' AND piece_name = '$piece_name' AND user = $personel ";
                            }
                            if (
                                isset($_GET['dates'], $_GET['piece_size'], $_GET['piece_name'], $_GET['personel'])
                                && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== ''
                                 && $_GET['device_code'] === '' && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $dates = $_GET['dates'];
                                $piece_name = $_GET['piece_name'];
                                $personel = $_GET['personel'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND size = '$piece_size' AND piece_name = '$piece_name' AND user = $personel ";
                            }
                            if (
                                isset($_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' 
                                && $_GET['personel'] === ''  && $_GET['until_date'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $device_code = $_GET['device_code'];
                                $piece_name = $_GET['piece_name'];
                                $dates = $_GET['dates'];
                                $sql .= " AND device_number = '$device_code' AND size = '$piece_size' AND piece_name = '$piece_name' AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') ";
                            }
                            if (
                                isset($_GET['dates'], $_GET['device_code'], $_GET['piece_name'], $_GET['personel'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                                && $_GET['until_date'] === '' && $_GET['piece_size'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $dates = $_GET['dates'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND piece_name = '$piece_name' AND user = $personel ";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['device_code'] === '' 
                                && $_GET['personel'] === ''
                            ) {
                                $piece_size = $_GET['piece_size'];
                                $until_date = $_GET['until_date'];
                                $piece_name = $_GET['piece_name'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                                AND piece_name = '$piece_name' AND size = '$piece_size'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['device_code'] === '' 
                                && $_GET['piece_size'] === ''
                            ) {
                                $personel = $_GET['personel'];
                                $until_date = $_GET['until_date'];
                                $piece_name = $_GET['piece_name'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                                AND piece_name = '$piece_name' AND user= '$personel'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['personel'] === '' 
                                && $_GET['piece_size'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $until_date = $_GET['until_date'];
                                $piece_name = $_GET['piece_name'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                                AND piece_name = '$piece_name' AND device_number= '$device_code'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], $_GET['dates'])
                                && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] !== '' && $_GET['dates'] !== '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $dates = $_GET['dates'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                                AND user = '$personel' AND device_number= '$device_code'";
                            }










                            if (
                                isset($_GET['dates'], $_GET['device_code'], $_GET['piece_name'], $_GET['personel'], $_GET['piece_size'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $dates = $_GET['dates'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND piece_name = '$piece_name' AND user = $personel AND size = '$piece_size'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_name'], $_GET['personel'], $_GET['piece_size'])
                                && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== ''
                                 && $_GET['piece_size'] !== '' && $_GET['dates'] === ''
                            ) {
                                $device_code = $_GET['device_code'];
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                                AND device_number = '$device_code' AND piece_name = '$piece_name' AND user = $personel AND size = '$piece_size'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['piece_name'], $_GET['personel'], $_GET['piece_size'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND piece_name = '$piece_name' AND user = $personel AND size = '$piece_size' AND piece_name = '$piece_name'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['piece_name'], $_GET['device_code'], $_GET['piece_size'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' 
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $device_code = $_GET['device_code'];
                                $piece_name = $_GET['piece_name'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND piece_name = '$piece_name' AND device_number = $device_code AND size = '$piece_size' AND piece_name = '$piece_name'";
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['personel'], $_GET['device_code'], $_GET['piece_name'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== '' 
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] === ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $device_code = $_GET['device_code'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND user = '$personel' AND device_number = $device_code AND piece_name = '$piece_name' AND piece_name = '$piece_name'";
                            }



                            if (
                                isset($_GET['until_date'], $_GET['dates'], $_GET['personel'], 
                                $_GET['device_code'], $_GET['piece_name'], $_GET['piece_size'])
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== '' 
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                            ) {
                                $dates = $_GET['dates'];
                                $until_date = $_GET['until_date'];
                                $device_code = $_GET['device_code'];
                                $personel = $_GET['personel'];
                                $piece_name = $_GET['piece_name'];
                                $piece_size = $_GET['piece_size'];
                                $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                                 AND user = '$personel' AND device_number = $device_code AND piece_name = '$piece_name' AND piece_name = '$piece_name' AND size = '$piece_size'";
                            }








                            $sql .= " ORDER BY id DESC LIMIT $start_from, $results_per_page";


                            $_SESSION['query'] = $sql;




                            // echo $sql;

                            $result = $conn->query($sql);

                         
                            if ($result->num_rows > 0) {
                                $a = $start_from + 1;
                                $totals = [];
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
                                            echo '<td class="text-center">کاربر خالی وارد کرده</td>';
                                        }
                                        ?>

                                        <td class="text-center">
                                            <?php
                                            if ($row['shift'] == 1) {
                                                echo 'روز';
                                            }
                                            if ($row['shift'] == 2) {
                                                echo 'عصر';
                                            }
                                            if ($row['shift'] == 3) {
                                                echo 'شب';
                                            }
                                            ?>
                                        </td>

                                        <td class="text-center"><?= $row['date'] ?></td>

                                        <?php
                                        $start_time = strtotime($row['start']);
                                        $finish_time = strtotime($row['stop']);

                                        $time_difference = $finish_time - $start_time;
                                        ?>

                                        <td class="text-center"><?= $time_difference ?> ثانیه </td>

                                        <?php
                                        $size_piece = $row['size'];
                                        $piece_name = $row['piece_name'];
                                        $level = $row['level'];
                                        $sqll = "SELECT * FROM pieces WHERE size = '$size_piece' AND name = '$piece_name' AND level = '$level'";
                                        $resultt = $conn->query($sqll);
                                        if ($resultt->num_rows > 0) {
                                            $roww = $resultt->fetch_assoc();
                                            $time_one = $roww['time_one'];
                                            $price = $roww['price'];
                                            $all_time = $time_one * $row['numbers'];
                                            $all_price = $price * $row['numbers'];
                                            $totals[] = $all_price;

                                            $delay = $all_time - $time_difference;

                                            if ($delay >= 0) {
                                                $delay_message = "تاخیر نداشته";
                                            } else {
                                                $delay_message = $delay;
                                            }

                                        } else {
                                            $all_time = "زمانی ثبت نشده";
                                            $delay_message = "زمانی ثبت نشده";
                                            $all_price = "قیمتی ثبت نشده";
                                            $price = "قیمتی ثبت نشده";
                                            $totals[] = 0;
                                        }
                                        ?>

                                        <td class="text-center"><?= $all_time ?> ثانیه </td>
                                        <td class="text-center"><?= $delay_message ?></td>
                                        <td class="text-center"><?= $row['numbers'] ?></td>
                                        <td class="text-center"><?= $price ?></td>
                                        <td class="text-center"><?= $all_price ?></td>
                                    </tr>

                                <?php
                                    $a++;
                                }

                                $totalSum = array_sum($totals);
                            } else {
                                $totalSum = 0;
                            }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="9" class="text-right">جمع کل این صفحه:</th>
                                    <th class="text-center"><?= number_format($totalSum) ?></th>
                                </tr>
                            </tfoot>


                    </table>


                </div>








                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&rows=' . $results_per_page;



                          

                            if (
                                isset($_GET['personel']) && $_GET['personel'] !== '' && $_GET['until_date'] === ''
                                && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&dates=' . '&device_code=' . '&piece_name=' . '&piece_size='.'$until_date=';
                            }

                            if (
                                isset($_GET['dates']) && $_GET['dates'] !== '' && $_GET['until_date'] === ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'$until_date=';
                            }
                            if (
                                isset($_GET['until_date']) && $_GET['until_date'] !== '' && $_GET['dates'] === ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'$dates=';
                            }

                            if (
                                isset($_GET['device_code']) && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . '&dates=' . '&piece_name=' . '&piece_size='.'$until_date=';
                            }
                            if (
                                isset($_GET['piece_name']) && $_GET['piece_name'] !== '' && $_GET['until_date'] === ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' . '&device_code=' . '&piece_size='.'$until_date=';
                            }







                            if (
                                isset($_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&dates=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['dates'], $_GET['device_code'])
                                && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                . '&dates='. '&until_date=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'])
                                && $_GET['until_date'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' 
                                . '&piece_size='. '&piece_name=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'])
                                && $_GET['until_date'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                . '&piece_size='. '&piece_name=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_name'])
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                            ) {
                                echo '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                . '&piece_size='. '&device_code=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'])
                                && $_GET['until_date'] !== '' && $_GET['personel'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . '&dates=' 
                                . '&piece_size='. '&device_code=';
                            }


                            




                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['dates'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['device_code'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&personel=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['personel'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['personel'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                . '&personel='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['personel'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' 
                                . '&dates='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['device_code'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&device_code=' . $_GET['device_code'] . '&personel=' 
                                . '&dates='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['dates'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                . '&device_code='. '&piece_size=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                . '&device_code='. '&dates=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['device_code'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                . '&piece_size='. '&dates=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['personel'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&device_code=' 
                                . '&piece_size='. '&dates=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['dates'], $_GET['until_date'])
                                && $_GET['personel'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                . '&device_code='. '&piece_size=';
                            }
                            if (
                                isset($_GET['device_code'], $_GET['dates'], $_GET['until_date'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['personel'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                . '&personel='. '&piece_size=';
                            }


                            





                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['dates'], $_GET['piece_name'])
                                && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&piece_size='. '&until_date';
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] === ''&& $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates='. '&until_date';
                            }
                            if (
                                isset($_GET['dates'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['personel'] === ''&& $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '
                                &personel='. '&until_date';
                            }
                            if (
                                isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] === ''&& $_GET['until_date'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&de
                                vice_code='. '&until_date';
                            }
                            if (
                                isset($_GET['dates'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] === '' && $_GET['personel'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code='. '&personel';
                            }
                            if (
                                isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code='. '&piece_size';
                            }
                            if (
                                isset($_GET['device_code'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] === '' && $_GET['personel'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates='. '&personel';
                            }
                            if (
                                isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['device_code'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['dates'] !== '' && $_GET['device_code'] !== '' 
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] 
                                . '&piece_name='. '&piece_size';
                            }
                            if (
                                isset($_GET['device_code'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates='. '&piece_size';
                            }
                           







                            if (
                                isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code=' . $_GET['device_code']. '&until_date=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code=' . $_GET['device_code']. '&dates=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['device_code'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&device_code=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['personel'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&personel=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&piece_size=';
                            }






                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], 
                                $_GET['piece_name'], $_GET['dates'], $_GET['piece_size'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['piece_size'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== '' && $_GET['piece_size'] !== ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&piece_size='.$_GET['piece_size'];
                            }






                            echo '">قبلی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>';
                        }

                        // Page numbers
                        $sql = "SELECT COUNT(*) AS total FROM products WHERE status = 1";







                        if (
                            isset($_GET['personel']) && $_GET['personel'] !== ''
                            && $_GET['dates'] === '' && $_GET['device_code'] === ''
                            && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $personel = $_GET['personel'];
                            $sql .= " AND user = $personel";
                        }
                        if (
                            isset($_GET['dates']) && $_GET['dates'] !== ''
                            && $_GET['personel'] === '' && $_GET['device_code'] === ''
                            && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d')";
                        }

                        if (
                            isset($_GET['until_date']) && $_GET['until_date'] !== ''
                            && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === ''
                            && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                        ) {
                            $until_date = $_GET['until_date'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                        }

                        if (
                            isset($_GET['device_code']) && $_GET['device_code'] !== ''
                            && $_GET['personel'] === ''  && $_GET['dates'] === ''
                            && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $sql .= " AND device_number = $device_code";
                        }
                        if (
                            isset($_GET['piece_name']) && $_GET['piece_name'] !== ''
                            && $_GET['personel'] === ''  && $_GET['dates'] === ''
                            && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND piece_name = '$piece_name'";
                        }
                        if (
                            isset($_GET['piece_size']) && $_GET['piece_size'] !== ''
                            && $_GET['personel'] === ''  && $_GET['dates'] === ''
                            && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND size = '$piece_size'";
                        }





                        if (
                            isset($_GET['personel'], $_GET['dates'])
                            && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                            && $_GET['device_code'] === '' && $_GET['piece_name'] === ''
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $personel = $_GET['personel'];
                            $sql .= " AND user = $personel AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d')";
                        }
                        if (
                            isset($_GET['personel'], $_GET['device_code'])
                            && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                            && $_GET['dates'] === '' && $_GET['piece_name'] === ''
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $personel = $_GET['personel'];
                            $sql .= " AND user = $personel AND device_number = '$device_code'";
                        }
                        if (
                            isset($_GET['personel'], $_GET['piece_name'])
                            && $_GET['personel'] !== '' && $_GET['piece_name'] !== ''
                            && $_GET['dates'] === '' &&  $_GET['device_code'] === ''
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $personel = $_GET['personel'];
                            $sql .= " AND user = $personel AND piece_name = '$piece_name'";
                        }
                        if (
                            isset($_GET['device_code'], $_GET['piece_name'])
                            && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                            && $_GET['dates'] === '' &&  $_GET['personel'] === ''
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $device_code = $_GET['device_code'];
                            $sql .= " AND device_number = '$device_code' AND piece_name = '$piece_name'";
                        }
                        if (
                            isset($_GET['dates'], $_GET['device_code'])
                            && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                            && $_GET['personel'] === '' && $_GET['piece_name'] === ''
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code'";
                        }
                        if (
                            isset($_GET['dates'], $_GET['piece_name'])
                            && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                            && $_GET['personel'] === '' && $_GET['device_code'] === ''
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND piece_name = '$piece_name'";
                        }
                        if (
                            isset($_GET['piece_size'], $_GET['piece_name'])
                            && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                            && $_GET['personel'] === '' && $_GET['device_code'] === ''
                            && $_GET['dates'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND size = '$piece_size' AND piece_name = '$piece_name'";
                        }

                        if (
                            isset($_GET['until_date'], $_GET['personel'])
                            && $_GET['until_date'] !== '' && $_GET['personel'] !== ''
                            && $_GET['piece_name'] === '' && $_GET['device_code'] === ''
                            && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                        ) {
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $sql .= " AND user = '$personel' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['device_code'])
                            && $_GET['until_date'] !== '' && $_GET['device_code'] !== ''
                            && $_GET['piece_name'] === '' && $_GET['personel'] === ''
                            && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                        ) {
                            $until_date = $_GET['until_date'];
                            $device_code = $_GET['device_code'];
                            $sql .= " AND device_number = '$device_code' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['piece_name'])
                            && $_GET['until_date'] !== '' && $_GET['piece_name'] !== ''
                            && $_GET['device_code'] === '' && $_GET['personel'] === ''
                            && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                        ) {
                            $until_date = $_GET['until_date'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND piece_name = '$piece_name' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['piece_size'])
                            && $_GET['until_date'] !== '' && $_GET['piece_size'] !== ''
                            && $_GET['device_code'] === '' && $_GET['personel'] === ''
                            && $_GET['dates'] === '' && $_GET['piece_name'] === ''
                        ) {
                            $until_date = $_GET['until_date'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND size = '$piece_size' AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'])
                            && $_GET['until_date'] !== '' && $_GET['dates'] !== ''
                            && $_GET['device_code'] === '' && $_GET['personel'] === ''
                            && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                        ) {
                            $until_date = $_GET['until_date'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')";
                        }








                        if (
                            isset($_GET['piece_name'], $_GET['device_code'], $_GET['personel'])
                            && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                            && $_GET['personel'] !== '' && $_GET['dates'] === '' 
                            && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $piece_name = $_GET['piece_name'];
                            $personel = $_GET['personel'];
                            $sql .= " AND piece_name = '$piece_name' AND device_number = '$device_code' AND user = $personel ";
                        }

                        if (
                            isset($_GET['dates'], $_GET['device_code'], $_GET['personel'])
                            && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                            && $_GET['personel'] !== '' && $_GET['piece_name'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $dates = $_GET['dates'];
                            $personel = $_GET['personel'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND user = $personel ";
                        }

                        if (
                            isset($_GET['dates'], $_GET['piece_name'], $_GET['personel'])
                            && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                            && $_GET['personel'] !== '' && $_GET['device_code'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['until_date'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $dates = $_GET['dates'];
                            $personel = $_GET['personel'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND piece_name = '$piece_name' AND user = $personel ";
                        }

                        if (
                            isset($_GET['dates'], $_GET['device_code'], $_GET['piece_name'])
                            && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $dates = $_GET['dates'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND piece_name = '$piece_name' ";
                        }
                        if (
                            isset($_GET['personel'], $_GET['piece_size'], $_GET['piece_name'])
                            && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['dates'] === '' 
                            && $_GET['device_code'] === ''  && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND user = $personel AND size = '$piece_size' AND piece_name = '$piece_name' ";
                        }
                        if (
                            isset($_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                            && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['dates'] === '' 
                            && $_GET['personel'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $device_code = $_GET['device_code'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND device_number = '$device_code' AND size = '$piece_size' AND piece_name = '$piece_name' ";
                        }
                        if (
                            isset($_GET['dates'], $_GET['piece_size'], $_GET['piece_name'])
                            && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['device_code'] === '' 
                            && $_GET['personel'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $dates = $_GET['dates'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND size = '$piece_size' AND piece_name = '$piece_name' ";
                        }

                        if (
                            isset($_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                            && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['device_code'] === '' 
                            && $_GET['personel'] === '' && $_GET['dates'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $until_date = $_GET['until_date'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND size = '$piece_size' AND piece_name = '$piece_name' ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'])
                            && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['personel'] !== '' && $_GET['piece_name'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['dates'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND device_number = '$device_code' AND user = $personel ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['personel'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['personel'] !== '' && $_GET['piece_name'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['device_code'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND user = $personel ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['device_code'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['device_code'] !== '' && $_GET['piece_name'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['personel'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $device_code = $_GET['device_code'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND device_number = $device_code ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['piece_name'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['piece_name'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['device_code'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND piece_name = $piece_name ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['piece_name'], $_GET['personel'])
                            && $_GET['piece_name'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['personel'] !== '' && $_GET['device_code'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['dates'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND piece_name = '$piece_name' AND user = $personel ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['piece_name'], $_GET['device_code'])
                            && $_GET['piece_name'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['device_code'] !== '' && $_GET['personel'] === '' 
                            && $_GET['piece_size'] === ''  && $_GET['dates'] === ''
                        ) {
                            $piece_name = $_GET['piece_name'];
                            $until_date = $_GET['until_date'];
                            $device_code = $_GET['device_code'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') AND piece_name = '$piece_name' AND device_number = '$device_code' ";
                        }









                        if (
                            isset($_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['personel'])
                            && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                            && $_GET['dates'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $device_code = $_GET['device_code'];
                            $piece_name = $_GET['piece_name'];
                            $personel = $_GET['personel'];
                            $sql .= " AND device_number = '$device_code' AND size = '$piece_size' AND piece_name = '$piece_name' AND user = $personel ";
                        }
                        if (
                            isset($_GET['dates'], $_GET['piece_size'], $_GET['piece_name'], $_GET['personel'])
                            && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] !== ''
                             && $_GET['device_code'] === '' && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $dates = $_GET['dates'];
                            $piece_name = $_GET['piece_name'];
                            $personel = $_GET['personel'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND size = '$piece_size' AND piece_name = '$piece_name' AND user = $personel ";
                        }
                        if (
                            isset($_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                            && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' 
                            && $_GET['personel'] === ''  && $_GET['until_date'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $device_code = $_GET['device_code'];
                            $piece_name = $_GET['piece_name'];
                            $dates = $_GET['dates'];
                            $sql .= " AND device_number = '$device_code' AND size = '$piece_size' AND piece_name = '$piece_name' AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') ";
                        }
                        if (
                            isset($_GET['dates'], $_GET['device_code'], $_GET['piece_name'], $_GET['personel'])
                            && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                            && $_GET['until_date'] === '' && $_GET['piece_size'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $dates = $_GET['dates'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND piece_name = '$piece_name' AND user = $personel ";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                            && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['device_code'] === '' 
                            && $_GET['personel'] === ''
                        ) {
                            $piece_size = $_GET['piece_size'];
                            $until_date = $_GET['until_date'];
                            $piece_name = $_GET['piece_name'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                            AND piece_name = '$piece_name' AND size = '$piece_size'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['personel'], $_GET['piece_name'], $_GET['dates'])
                            && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['device_code'] === '' 
                            && $_GET['piece_size'] === ''
                        ) {
                            $personel = $_GET['personel'];
                            $until_date = $_GET['until_date'];
                            $piece_name = $_GET['piece_name'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                            AND piece_name = '$piece_name' AND user= '$personel'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_name'], $_GET['dates'])
                            && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['personel'] === '' 
                            && $_GET['piece_size'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $until_date = $_GET['until_date'];
                            $piece_name = $_GET['piece_name'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                            AND piece_name = '$piece_name' AND device_number= '$device_code'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], $_GET['dates'])
                            && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['personel'] !== '' && $_GET['dates'] !== '' && $_GET['piece_name'] === '' 
                            && $_GET['piece_size'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $dates = $_GET['dates'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                            AND user = '$personel' AND device_number= '$device_code'";
                        }






                        if (
                            isset($_GET['dates'], $_GET['device_code'], $_GET['piece_name'], $_GET['personel'], $_GET['piece_size'])
                            && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                            && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $dates = $_GET['dates'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND device_number = '$device_code' AND piece_name = '$piece_name' AND user = $personel AND size = '$piece_size'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_name'], $_GET['personel'], $_GET['piece_size'])
                            && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] !== ''
                             && $_GET['piece_size'] !== '' && $_GET['dates'] === ''
                        ) {
                            $device_code = $_GET['device_code'];
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d') 
                            AND device_number = '$device_code' AND piece_name = '$piece_name' AND user = $personel AND size = '$piece_size'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['piece_name'], $_GET['personel'], $_GET['piece_size'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' 
                            && $_GET['piece_size'] !== '' && $_GET['device_code'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND piece_name = '$piece_name' AND user = $personel AND size = '$piece_size' AND piece_name = '$piece_name'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['piece_name'], $_GET['device_code'], $_GET['piece_size'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' 
                            && $_GET['piece_size'] !== '' && $_GET['device_code'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $device_code = $_GET['device_code'];
                            $piece_name = $_GET['piece_name'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND piece_name = '$piece_name' AND device_number = $device_code AND size = '$piece_size' AND piece_name = '$piece_name'";
                        }
                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['personel'], $_GET['device_code'], $_GET['piece_name'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['personel'] !== '' && $_GET['device_code'] !== '' 
                            && $_GET['piece_name'] !== '' && $_GET['piece_size'] === ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $device_code = $_GET['device_code'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND user = '$personel' AND device_number = $device_code AND piece_name = '$piece_name' AND piece_name = '$piece_name'";
                        }



                        if (
                            isset($_GET['until_date'], $_GET['dates'], $_GET['personel'], 
                            $_GET['device_code'], $_GET['piece_name'], $_GET['piece_size'])
                            && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                            && $_GET['personel'] !== '' && $_GET['device_code'] !== '' 
                            && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                        ) {
                            $dates = $_GET['dates'];
                            $until_date = $_GET['until_date'];
                            $device_code = $_GET['device_code'];
                            $personel = $_GET['personel'];
                            $piece_name = $_GET['piece_name'];
                            $piece_size = $_GET['piece_size'];
                            $sql .= " AND STR_TO_DATE(date, '%Y/%m/%d') >= STR_TO_DATE('$dates', '%Y/%m/%d') AND STR_TO_DATE(date, '%Y/%m/%d') < STR_TO_DATE('$until_date', '%Y/%m/%d')
                             AND user = '$personel' AND device_number = $device_code AND piece_name = '$piece_name' AND piece_name = '$piece_name' AND size = '$piece_size'";
                        }






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


                                if (
                                    isset($_GET['personel']) && $_GET['personel'] !== '' && $_GET['until_date'] === ''
                                    && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' 
                                    && $_GET['piece_size'] === ''
                                ) {
                                    // Ensure piece_name and piece_size are present, even if empty
                                    echo '&personel=' . $_GET['personel'] . '&dates=' . '&device_code=' . '&piece_name=' . '&piece_size='.'$until_date=';
                                }

                                if (
                                    isset($_GET['dates']) && $_GET['dates'] !== '' && $_GET['until_date'] === ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'$until_date=';
                                }
                                if (
                                    isset($_GET['until_date']) && $_GET['until_date'] !== '' && $_GET['dates'] === ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'$dates=';
                                }

                                if (
                                    isset($_GET['device_code']) && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . '&dates=' . '&piece_name=' . '&piece_size='.'$until_date=';
                                }
                                if (
                                    isset($_GET['piece_name']) && $_GET['piece_name'] !== '' && $_GET['until_date'] === ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' . '&device_code=' . '&piece_size='.'$until_date=';
                                }






                                if (
                                    isset($_GET['personel'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['piece_name'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&dates=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['dates'])
                                    && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['device_code'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['device_code'])
                                    && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['device_code'])
                                    && $_GET['piece_name'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                    . '&dates='. '&until_date=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['dates'])
                                    && $_GET['until_date'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' 
                                    . '&piece_size='. '&piece_name=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['device_code'])
                                    && $_GET['until_date'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                    . '&piece_size='. '&piece_name=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['piece_name'])
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                                ) {
                                    echo '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                    . '&piece_size='. '&device_code=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['personel'])
                                    && $_GET['until_date'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['dates'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . '&dates=' 
                                    . '&piece_size='. '&device_code=';
                                }







                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                                    && $_GET['dates'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['dates'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['device_code'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['personel'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&personel=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['personel'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['personel'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                    . '&personel='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['personel'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' 
                                    . '&dates='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['device_code'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&device_code=' . $_GET['device_code'] . '&personel=' 
                                    . '&dates='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['dates'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                    . '&device_code='. '&piece_size=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                    . '&device_code='. '&dates=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['device_code'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['personel'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                    . '&piece_size='. '&dates=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['personel'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&device_code=' 
                                    . '&piece_size='. '&dates=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['dates'], $_GET['until_date'])
                                    && $_GET['personel'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                    . '&device_code='. '&piece_size=';
                                }
                                if (
                                    isset($_GET['device_code'], $_GET['dates'], $_GET['until_date'])
                                    && $_GET['device_code'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['personel'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                    . '&personel='. '&piece_size=';
                                }





                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['dates'], $_GET['piece_name'])
                                    && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&piece_size='. '&until_date';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] === ''&& $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates='. '&until_date';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['personel'] === ''&& $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '
                                    &personel='. '&until_date';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] === ''&& $_GET['until_date'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&de
                                    vice_code='. '&until_date';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] === '' && $_GET['personel'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code='. '&personel';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code='. '&piece_size';
                                }
                                if (
                                    isset($_GET['device_code'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] === '' && $_GET['personel'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates='. '&personel';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['device_code'])
                                    && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['device_code'] !== '' 
                                    && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] 
                                    . '&piece_name='. '&piece_size';
                                }
                                if (
                                    isset($_GET['device_code'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates='. '&piece_size';
                                }





                                if (
                                    isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code=' . $_GET['device_code']. '&until_date=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code=' . $_GET['device_code']. '&dates=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['device_code'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&device_code=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                    && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['personel'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&personel=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], $_GET['piece_name'], $_GET['dates'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&piece_size=';
                                }






                                if (
                                    isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], 
                                    $_GET['piece_name'], $_GET['dates'], $_GET['piece_size'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['piece_size'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['until_date'] !== '' && $_GET['piece_size'] !== ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&piece_size='.$_GET['piece_size'];
                                }






                                echo '">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&rows=' . $results_per_page;






                                if (
                                    isset($_GET['personel']) && $_GET['personel'] !== '' && $_GET['until_date'] === ''
                                    && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' 
                                    && $_GET['piece_size'] === ''
                                ) {
                                    // Ensure piece_name and piece_size are present, even if empty
                                    echo '&personel=' . $_GET['personel'] . '&dates=' . '&device_code=' . '&piece_name=' . '&piece_size='.'&until_date=';
                                }

                                if (
                                    isset($_GET['dates']) && $_GET['dates'] !== '' && $_GET['until_date'] === ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'&until_date=';
                                }
                                if (
                                    isset($_GET['until_date']) && $_GET['until_date'] !== '' && $_GET['dates'] === ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'&dates=';
                                }

                                if (
                                    isset($_GET['device_code']) && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . '&dates=' . '&piece_name=' . '&piece_size='.'&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name']) && $_GET['piece_name'] !== '' && $_GET['until_date'] === ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' . '&device_code=' . '&piece_size='.'&until_date=';
                                }



                                if (
                                    isset($_GET['personel'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['piece_name'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&dates=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['dates'])
                                    && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['device_code'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['device_code'])
                                    && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['device_code'])
                                    && $_GET['piece_name'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                    . '&dates='. '&until_date=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['dates'])
                                    && $_GET['until_date'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' 
                                    . '&piece_size='. '&piece_name=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['device_code'])
                                    && $_GET['until_date'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                    . '&piece_size='. '&piece_name=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['piece_name'])
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                                ) {
                                    echo '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                    . '&piece_size='. '&device_code=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['personel'])
                                    && $_GET['until_date'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['dates'] === '' 
                                    && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . '&dates=' 
                                    . '&piece_size='. '&device_code=';
                                }





                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                                    && $_GET['dates'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['dates'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['device_code'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['personel'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&personel=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['personel'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                    . '&piece_size='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['dates'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['personel'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                    . '&personel='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['personel'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' 
                                    . '&dates='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['device_code'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&device_code=' . $_GET['device_code'] . '&personel=' 
                                    . '&dates='. '&until_date=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['dates'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                    . '&device_code='. '&piece_size=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['piece_size'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === ''
                                ) {
                                    echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                    . '&device_code='. '&dates=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['device_code'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['personel'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                    . '&piece_size='. '&dates=';
                                }
                                if (
                                    isset($_GET['piece_name'], $_GET['personel'], $_GET['until_date'])
                                    && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&device_code=' 
                                    . '&piece_size='. '&dates=';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['dates'], $_GET['until_date'])
                                    && $_GET['personel'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                    . '&device_code='. '&piece_size=';
                                }
                                if (
                                    isset($_GET['device_code'], $_GET['dates'], $_GET['until_date'])
                                    && $_GET['device_code'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['piece_name'] === '' && $_GET['personel'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                    . '&personel='. '&piece_size=';
                                }





                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['dates'], $_GET['piece_name'])
                                    && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&piece_size='. '&until_date';
                                }
                                if (
                                    isset($_GET['personel'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] === ''&& $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates='. '&until_date';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['personel'] === ''&& $_GET['until_date'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '
                                    &personel='. '&until_date';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] === ''&& $_GET['until_date'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&de
                                    vice_code='. '&until_date';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] === '' && $_GET['personel'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code='. '&personel';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code='. '&piece_size';
                                }
                                if (
                                    isset($_GET['device_code'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                    && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] === '' && $_GET['personel'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates='. '&personel';
                                }
                                if (
                                    isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['device_code'])
                                    && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['device_code'] !== '' 
                                    && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] 
                                    . '&piece_name='. '&piece_size';
                                }
                                if (
                                    isset($_GET['device_code'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                    && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                    && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates='. '&piece_size';
                                }







                                if (
                                    isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] !== '' && $_GET['until_date'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code=' . $_GET['device_code']. '&until_date=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&device_code=' . $_GET['device_code']. '&dates=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                    && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['device_code'] === ''
                                ) {
                                    echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&device_code=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                    && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['personel'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&personel=';
                                }
                                if (
                                    isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], $_GET['piece_name'], $_GET['dates'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['piece_size'] === ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&piece_size=';
                                }






                                if (
                                    isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], 
                                    $_GET['piece_name'], $_GET['dates'], $_GET['piece_size'])
                                    && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                    && $_GET['piece_size'] !== '' && $_GET['piece_name'] !== '' 
                                    && $_GET['dates'] !== '' && $_GET['until_date'] !== '' && $_GET['piece_size'] !== ''
                                ) {
                                    echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                    . '&dates=' . $_GET['dates']. '&piece_size='.$_GET['piece_size'];
                                }



                                echo '">' . $i . '</a></li>';
                            }
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&rows=' . $results_per_page;



                            if (
                                isset($_GET['personel']) && $_GET['personel'] !== '' && $_GET['until_date'] === ''
                                && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' 
                                && $_GET['piece_size'] === ''
                            ) {
                                // Ensure piece_name and piece_size are present, even if empty
                                echo '&personel=' . $_GET['personel'] . '&dates=' . '&device_code=' . '&piece_name=' . '&piece_size='.'&until_date=';
                            }

                            if (
                                isset($_GET['dates']) && $_GET['dates'] !== '' && $_GET['until_date'] === ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'&until_date=';
                            }
                            if (
                                isset($_GET['until_date']) && $_GET['until_date'] !== '' && $_GET['dates'] === ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' . '&piece_name=' . '&piece_size='.'&dates=';
                            }

                            if (
                                isset($_GET['device_code']) && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . '&dates=' . '&piece_name=' . '&piece_size='.'&until_date=';
                            }
                            if (
                                isset($_GET['piece_name']) && $_GET['piece_name'] !== '' && $_GET['until_date'] === ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' . '&device_code=' . '&piece_size='.'&until_date=';
                            }






                            if (
                                isset($_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&dates=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&device_code=' . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['dates'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['dates'], $_GET['device_code'])
                                && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_name'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&dates=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . '&device_code=' 
                                . '&dates='. '&until_date=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['dates'])
                                && $_GET['until_date'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&device_code=' 
                                . '&piece_size='. '&piece_name=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'])
                                && $_GET['until_date'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['piece_name'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                . '&piece_size='. '&piece_name=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['piece_name'])
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                            ) {
                                echo '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' . '&dates=' 
                                . '&piece_size='. '&device_code=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'])
                                && $_GET['until_date'] !== '' && $_GET['personel'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['dates'] === '' 
                                && $_GET['piece_size'] === '' && $_GET['device_code'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . '&dates=' 
                                . '&piece_size='. '&device_code=';
                            }





                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['piece_name'] !== ''
                                && $_GET['dates'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['device_code'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['dates'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&personel=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['personel'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_size'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                . '&piece_size='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['dates'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['dates'] !== ''
                                && $_GET['device_code'] === '' && $_GET['personel'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&dates=' . $_GET['dates'] . '&device_code=' 
                                . '&personel='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['personel'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['device_code'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&personel=' . $_GET['personel'] . '&device_code=' 
                                . '&dates='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['device_code'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] === '' && $_GET['dates'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&device_code=' . $_GET['device_code'] . '&personel=' 
                                . '&dates='. '&until_date=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['dates'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                . '&device_code='. '&piece_size=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['piece_size'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['device_code'] === '' && $_GET['dates'] === ''
                            ) {
                                echo '&piece_size=' . $_GET['piece_size'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                . '&device_code='. '&dates=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['device_code'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['device_code'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['personel'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&personel=' 
                                . '&piece_size='. '&dates=';
                            }
                            if (
                                isset($_GET['piece_name'], $_GET['personel'], $_GET['until_date'])
                                && $_GET['piece_name'] !== '' && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] === '' && $_GET['piece_size'] === '' && $_GET['dates'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] . '&until_date=' . $_GET['until_date'] . '&device_code=' 
                                . '&piece_size='. '&dates=';
                            }
                            if (
                                isset($_GET['personel'], $_GET['dates'], $_GET['until_date'])
                                && $_GET['personel'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                . '&device_code='. '&piece_size=';
                            }
                            if (
                                isset($_GET['device_code'], $_GET['dates'], $_GET['until_date'])
                                && $_GET['device_code'] !== '' && $_GET['dates'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['piece_name'] === '' && $_GET['personel'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' 
                                . '&personel='. '&piece_size=';
                            }








                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['dates'], $_GET['piece_name'])
                                && $_GET['dates'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['piece_size'] === '' && $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&dates=' . $_GET['dates'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&piece_size='. '&until_date';
                            }
                            if (
                                isset($_GET['personel'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['personel'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] === ''&& $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&personel=' . $_GET['personel'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates='. '&until_date';
                            }
                            if (
                                isset($_GET['dates'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['personel'] === ''&& $_GET['until_date'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '
                                &personel='. '&until_date';
                            }
                            if (
                                isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] === ''&& $_GET['until_date'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] . '&de
                                vice_code='. '&until_date';
                            }
                            if (
                                isset($_GET['dates'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] === '' && $_GET['personel'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code='. '&personel';
                            }
                            if (
                                isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code='. '&piece_size';
                            }
                            if (
                                isset($_GET['device_code'], $_GET['until_date'], $_GET['piece_size'], $_GET['piece_name'])
                                && $_GET['piece_size'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] === '' && $_GET['personel'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&piece_size=' . $_GET['piece_size'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates='. '&personel';
                            }
                            if (
                                isset($_GET['dates'], $_GET['until_date'], $_GET['personel'], $_GET['device_code'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['dates'] !== '' && $_GET['device_code'] !== '' 
                                && $_GET['piece_name'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&dates=' . $_GET['dates'] . '&device_code=' . $_GET['device_code'] 
                                . '&piece_name='. '&piece_size';
                            }
                            if (
                                isset($_GET['device_code'], $_GET['until_date'], $_GET['personel'], $_GET['piece_name'])
                                && $_GET['personel'] !== '' && $_GET['until_date'] !== ''
                                && $_GET['device_code'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] === '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&until_date=' . $_GET['until_date'] . '&personel=' . $_GET['personel'] . '&device_code=' . $_GET['device_code'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates='. '&piece_size';
                            }





                            if (
                                isset($_GET['dates'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['dates'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] !== '' && $_GET['until_date'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&dates=' . $_GET['dates'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code=' . $_GET['device_code']. '&until_date=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['device_code'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['device_code'] !== '' && $_GET['dates'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&device_code=' . $_GET['device_code']. '&dates=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['personel'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_size'] !== '' && $_GET['personel'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['device_code'] === ''
                            ) {
                                echo '&personel=' . $_GET['personel'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&device_code=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['piece_size'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['piece_size'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['personel'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&piece_size=' . $_GET['piece_size'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&personel=';
                            }
                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], $_GET['piece_name'], $_GET['dates'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['until_date'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['piece_size'] === ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&piece_size=';
                            }




                            if (
                                isset($_GET['until_date'], $_GET['device_code'], $_GET['personel'], 
                                $_GET['piece_name'], $_GET['dates'], $_GET['piece_size'])
                                && $_GET['personel'] !== '' && $_GET['device_code'] !== ''
                                && $_GET['piece_size'] !== '' && $_GET['piece_name'] !== '' 
                                && $_GET['dates'] !== '' && $_GET['until_date'] !== '' && $_GET['piece_size'] !== ''
                            ) {
                                echo '&device_code=' . $_GET['device_code'] . '&personel=' . $_GET['personel'] . '&until_date=' . $_GET['until_date'] . '&piece_name=' . $_GET['piece_name'] 
                                . '&dates=' . $_GET['dates']. '&piece_size='.$_GET['piece_size'];
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



    <script>
        function getSizes() {
            // Disable the piece size select element until a piece is selected
            $('#piece_size').prop('disabled', true);

            // Get the piece name entered by the user
            var pieceName = document.getElementById("piece_name").value;

            // Check if a piece name is provided
            if (pieceName.trim() !== '') {
                $.ajax({
                    type: 'GET',
                    url: 'get_sizes.php',
                    data: {
                        piece_name: pieceName
                    },
                    dataType: 'json', // Specify JSON data type
                    success: function(data) {
                        console.log("Received data:", data); // Log received data
                        var sizesHtml = '<option value="">Select a size</option>'; // Add a placeholder option

                        // Construct HTML for sizes
                        data.forEach(function(item) {
                            sizesHtml += '<option value="' + item.id + '">' + item.size + '</option>';
                        });

                        console.log("Generated HTML:", sizesHtml); // Log generated HTML

                        // Replace the default option with the sizes
                        $('#piece_size').html(sizesHtml);
                        // Enable the piece size select element
                        $('#piece_size').prop('disabled', false);
                    },
                    error: function() {
                        // Handle errors
                        alert("Error fetching sizes");
                        // Enable the piece size select element
                        $('#piece_size').prop('disabled', false);
                    }
                });
            } else {
                // If no piece name is provided, show a placeholder in the size select element
                $('#piece_size').html('<option value="">Select a piece first</option>');
                // Enable the piece size select element
                $('#piece_size').prop('disabled', true);
            }
        }
    </script>







</body>

</html>