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
    <title>Document</title>
    <?php
    include 'includes.php';
    include 'config.php';
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


    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> -->




    <style>
        /* Hide the up and down arrows */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>


</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex ">
                <?php
                include 'sidebar.php';
                ?>
               
            </div>

            <div class="col-md-8">
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت روزانه محصولات : </h3>
                <form action="submit_pro.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="shift" class="form-label fw-semibold">
                                شیفت</label>
                            <select name="shift" class="form-select" aria-label="Default select example">
                                <option selected>یکی از شیفت های زیر را انتخاب کنید</option>
                                <option value="1">روز</option>
                                <option value="2">عصر</option>
                                <option value="3">شب</option>
                            </select>
                        </div>
                      
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <label for="device_name" class="form-label fw-semibold">
                                نام دستگاه</label>
                            <select name="device_name" id="device_name" class="form-select" aria-label="Default select example">
                                <option selected>یکی از دستگاه های زیر را انتخاب کنید</option>
                                <?php
                               $sql = "SELECT name, MIN(id) AS id FROM devices GROUP BY name";


                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option id="<?= $row['id'] ?>" value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label for="device_number" class="form-label fw-semibold">
                                شماره دستگاه</label>
                            <select name="device_number" id="device_number" class="form-select" aria-label="Default select example">
                                <option selected disabled>ابتدا اسم دستگاه را وارد کنید</option>
                                <?php
                                $sql = "SELECT * FROM devices";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option id="<?= $row['id'] ?>" value="<?= $row['numbers'] ?>"><?= $row['numbers'] ?></option>
                                <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    
           

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var deviceNameSelect = document.getElementById('device_name');
                            var deviceNumberSelect = document.getElementById('device_number');

                            // Disable device number select initially
                            deviceNumberSelect.disabled = true;

                            deviceNameSelect.addEventListener('change', function() {
                                var selectedDeviceName = this.value;

                                // Clear previous options
                                deviceNumberSelect.innerHTML = '<option value="" selected>در حال بارگذاری...</option>';

                                // Make AJAX request
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            var deviceNumbers = JSON.parse(xhr.responseText);
                                            // Update device number select options
                                            deviceNumberSelect.innerHTML = '<option value="" selected>یکی از شماره های زیر را انتخاب کنید</option>';
                                            deviceNumbers.forEach(function(device) {
                                                var option = document.createElement('option');
                                                option.value = device.id; // Assuming 'id' is the device id
                                                option.textContent = device.numbers; // Assuming 'numbers' is the device number
                                                deviceNumberSelect.appendChild(option);
                                            });
                                            // Enable device number select
                                            deviceNumberSelect.disabled = false;
                                        } else {
                                            console.error('Request failed: ' + xhr.status);
                                        }
                                    }
                                };
                                xhr.open('GET', 'search_smilar_device.php?name=' + encodeURIComponent(selectedDeviceName), true);
                                xhr.send();
                            });
                        });
                    </script>





                    <div class="row mt-3">
                        
                        <div class="col-md-6">
                            <label for="piece_name" class="form-label fw-semibold">نام قطعه</label>
                            <select name="piece_name" id="piece_name" class="form-select" aria-label="Default select example">
                                <option value="" selected>یکی از قطعه های زیر را انتخاب کنید</option>
                                <?php

                                $sql = "SELECT name, MIN(id) AS id FROM pieces GROUP BY name";

                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option id="<?= $row['id'] ?>" value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>


                            <!-- <input type="hidden" name="piece_id" id="piece_id">


                            <script>
                                // Function to update the hidden input with the selected piece ID
                                document.getElementById('piece_name').addEventListener('change', function() {
                                    var selectedPieceId = this.value;
                                    document.querySelector('input[name="piece_id"]').value = selectedPieceId;
                                });
                            </script> -->

                        </div>

                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">سایز قطعه</label>
                            <select name="size" id="size_piece" class="form-select" aria-label="Default select example">
                                <option value="" selected>یکی از سایزهای زیر را انتخاب کنید</option>
                                <!-- Other options here -->
                            </select>
                        </div>




                    </div>




                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var pieceNameSelect = document.getElementById('piece_name');
                            var sizeSelect = document.getElementById('size_piece');

                            // Add initial option and disable size select
                            sizeSelect.innerHTML = '<option value="" selected>ابتدا اسم قطعه را وارد کنید</option>';
                            sizeSelect.disabled = true;

                            pieceNameSelect.addEventListener('change', function() {
                                var pieceName = this.value;

                                // Clear previous options
                                sizeSelect.innerHTML = '<option value="" selected>در حال بارگذاری...</option>';

                                // Make AJAX request
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            var sizes = JSON.parse(xhr.responseText);
                                            // Update size select options
                                            sizeSelect.innerHTML = '<option value="" selected>یکی از سایزهای زیر را انتخاب کنید</option>';
                                            sizes.forEach(function(size) {
                                                var option = document.createElement('option');
                                                option.value = size;
                                                option.textContent = size;
                                                sizeSelect.appendChild(option);
                                            });
                                            // Enable size select
                                            sizeSelect.disabled = false;
                                        } else {
                                            console.error('Request failed: ' + xhr.status);
                                        }
                                    }
                                };
                                xhr.open('GET', 'get_sizes.php?piece_name=' + encodeURIComponent(pieceName), true);
                                xhr.send();
                            });
                        });
                    </script>





                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="level" class="form-label fw-semibold">
                                مرحله</label>
                            <select name="level" class="form-select" aria-label="Default select example">
                                <option selected>یکی از مراحل زیر را انتخاب کنید</option>
                                <option value="1">یک</option>
                                <option value="2">دو</option>
                                <option value="3">سه</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="numbers" class="form-label fw-semibold">
                                تعداد</label>
                            <input type="number" name="numbers" class="form-control">
                        </div>
                    </div>



                
                    <div class="row mt-3">
                      
                        <div class="col-md-6">
                            <label for="had_stop" class="form-label fw-semibold">
                                توقف (دقیقه)</label>
                            <!-- <input type="text" name="had_stop" class="form-control"> -->
                            <select name="had_stop" id="had_stop" class="form-select" aria-label="Default select example">
                                
                                <option value="0">نداشتم</option>
                                <option value="1">داشتم</option>
                            
                            </select>
                        </div>
                    </div>



                    <div class="row mt-3" id="times_stop" style="display: none;">
                        <div class="col-md-6">
                            <label for="start_stop" class="form-label fw-semibold">
                                از ساعت</label>
                            <input type="time" class="form-control input-md" name="start_stop" id="start_stop">
                        </div>
                        <div class="col-md-6">
                            <label for="finish_stop" class="form-label fw-semibold">
                                تا ساعت</label>
                            <input type="time" class="form-control input-md" name="finish_stop" id="finish_stop">

                        </div>

                        <div class="col-md-6">
                            <label for="couse_stop" class="form-label fw-semibold">
                                علت توقف</label>
                            <textarea type="text" name="couse_stop" class="form-control"></textarea>
                        </div>
                    </div>



                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var timeStopSelect = document.getElementById("had_stop");
                            var nextDiv = document.getElementById('times_stop');

                            timeStopSelect.addEventListener('change', function() {
                                var selectedValue = this.value;
                                if (selectedValue === '1') {
                                    nextDiv.style.display = '';
                                } else {
                                    nextDiv.style.display = 'none';
                                }
                            });
                        });
                    </script>



                    <!-- <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="sub_date" class="form-label fw-semibold">
                                تاریخ</label>
                            <input id="pdpDefault" type="text" name="sub_date" class="form-control">
                        </div>

                    </div> -->
                    <br>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="hour" class="form-label fw-semibold">
                                ساعت شروع تولید قطعه</label>
                            <input type="text" name="hour" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="hour" class="form-label fw-semibold">
                                ساعت پایان تولید قطعه</label>
                            <input type="text" name="hour" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3" style="margin-bottom: 200px;">
                       

                        <div class="col-md-6">
                            <label for="sub_date" class="form-label fw-semibold">
                                تاریخ</label>
                            <input id="pdpDark" type="text" name="sub_date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="sub_date" class="form-label fw-semibold">
                                توضیحات اضافی</label>
                            <textarea class="form-control" ></textarea>
                        </div>

                     
                    </div>




                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="enter" class="btn btn-primary">ثبت</button>
                        </div>

                    </div>




                </form>
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



    <!-- JavaScript code -->
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var pieceNameSelect = document.getElementById('piece_name');
            var sizeSelect = document.getElementsByName('size')[0];

            pieceNameSelect.addEventListener('change', function() {
                var pieceName = this.value;

                // Clear previous options
                sizeSelect.innerHTML = '<option selected>در حال بارگذاری...</option>';

                // Make AJAX request
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var sizes = JSON.parse(xhr.responseText);
                            // Update size select options
                            sizeSelect.innerHTML = '<option selected>یکی از سایزهای زیر را انتخاب کنید</option>';
                            sizes.forEach(function(size) {
                                var option = document.createElement('option');
                                option.value = size;
                                option.textContent = size;
                                sizeSelect.appendChild(option);
                            });
                        } else {
                            console.error('Request failed: ' + xhr.status);
                        }
                    }
                };
                xhr.open('GET', 'get_sizes.php?piece_name=' + encodeURIComponent(pieceName), true);
                xhr.send();
            });
        });
    </script> -->

</body>

</html>


<?php

if (isset($_POST['enter'])) {

    $user = $_SESSION['all_data']['id'];

    $shift = $conn->real_escape_string($_POST['shift']);
    $device_name = $conn->real_escape_string($_POST['device_name']);
    $device_number = $conn->real_escape_string($_POST['device_number']);
    $piece_name = $conn->real_escape_string($_POST['piece_name']);
    // $piece_id = $conn->real_escape_string($_POST['piece_id']);
    $size = $conn->real_escape_string($_POST['size']);
    $level = $conn->real_escape_string($_POST['level']);
    $numbers = $conn->real_escape_string($_POST['numbers']);
    $time_one = $conn->real_escape_string($_POST['time_one']);
    $price = $conn->real_escape_string($_POST['price']);
    $time_stop = $conn->real_escape_string($_POST['time_stop']);
    $sub_date = $conn->real_escape_string($_POST['sub_date']);
    $hour = $conn->real_escape_string($_POST['hour']);
    $couse_stop = $conn->real_escape_string($_POST['couse_stop']);
    $explanation = $conn->real_escape_string($_POST['explanation']);



    $sql = "INSERT INTO products (device_name, device_number, piece_name, shift, 
                    size, level, numbers, time_one, price, time_stop, date, 
                    hour, couse_stop, explanation, user)
            VALUES ('$device_name', '$device_number', '$piece_name', '$shift', 
                    '$size', '$level', '$numbers', '$time_one', '$price', '$time_stop', '$sub_date', 
                    '$hour', '$couse_stop', '$explanation', '$user')";

    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        echo '<h3>محصول به درستی اضافه شد</h3>';
    } else { ?>
        <h3>خطایی در افزودن محصول پیش آمده!</h3>
<?php echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
