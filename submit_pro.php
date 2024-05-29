<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}


$id = $_SESSION["all_data"]['id'];
// $show_table_for_user = 0;
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت محصول جدید</title>
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


        input[type="time"] {
            position: relative;
        }

        input[type="time"]::-webkit-calendar-picker-indicator {
            display: block;
            top: 0;
            right: 0;
            height: 100%;
            width: 100%;
            position: absolute;
            background: transparent;
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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت روزانه محصولات : </h3>
                <form action="submit_pro.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="shift" class="form-label fw-semibold">
                                شیفت</label>
                            <select name="shift" class="form-select" aria-label="Default select example" required>
                                <option value="" selected>یکی از شیفت های زیر را انتخاب کنید</option>
                                <option value="1">روز</option>
                                <option value="2">عصر</option>
                                <option value="3">شب</option>
                            </select>
                        </div>
                    </div>






                    <div class="row">
                        <div class="col-md-6">
                            <label for="device_name" class="form-label fw-semibold">نام دستگاه</label>
                            <select name="device_name" id="device_name" class="form-select" aria-label="Default select example" required>
                                <option value="" selected>یکی از دستگاه های زیر را انتخاب کنید</option>
                                <?php
                                $sql = "SELECT name, MIN(id) AS id FROM devices GROUP BY name ORDER BY name";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="device_number" class="form-label fw-semibold">شماره دستگاه</label>
                            <select name="device_number" id="device_number" class="form-select" aria-label="Default select example" required>
                                <option value="" selected disabled>ابتدا اسم دستگاه را وارد کنید</option>
                                <?php
                                // Initially, PHP renders empty options; these will be populated dynamically by JavaScript/jQuery.
                                ?>
                            </select>
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#device_name').change(function() {
                                var deviceNameId = $(this).val();

                                $.ajax({
                                    url: 'search_smilar_device.php',
                                    method: 'POST',
                                    data: { device_name_id: deviceNameId },
                                    dataType: 'json', // Ensure expected data type is JSON
                                    success: function(data) {
                                        console.log(data);
                                        $('#device_number').empty();
                                        $.each(data, function(index, device) {
                                            $('#device_number').append('<option value="' + device.id + '">' + device.number + '</option>');
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error fetching device numbers:', error);
                                    }
                                });
                            });
                        });



                    </script>



                  











                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="piece_name" class="form-label fw-semibold">نام قطعه</label>
                            <select name="piece_name" id="piece_name" class="form-select" aria-label="Default select example" required>
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
                            <!-- <select name="size" id="size_piece" class="form-select" aria-label="Default select example">
                                <option value="" selected>یکی از سایزهای زیر را انتخاب کنید</option>
                           
                            </select> -->
                            <select name="size" id="size" class="form-select" aria-label="Default select example" required>
                                <option value="" selected disabled>ابتدا اسم قطعه را وارد کنید</option>
                                <?php
                                $sql = "SELECT * FROM pieces";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option id="<?= $row['id'] ?>" value="<?= $row['size'] ?>"><?= $row['size'] ?></option>
                                <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>




                    </div>







                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var pieceNameSelect = document.getElementById('piece_name');
                            var sizeSelect = document.getElementById('size');

                            // Disable size select initially
                            sizeSelect.disabled = true;

                            pieceNameSelect.addEventListener('change', function() {
                                var selectedPieceName = this.value;

                                // Clear previous options
                                sizeSelect.innerHTML = '<option value="" selected>در حال بارگذاری...</option>';

                                // Make AJAX request
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            var sizes = JSON.parse(xhr.responseText);

                                            // Ensure sizes is not empty
                                            if (sizes.length > 0) {
                                                // Update size select options
                                                sizeSelect.innerHTML = '<option value="" selected>یکی از سایزهای زیر را انتخاب کنید</option>';
                                                sizes.forEach(function(size) {
                                                    var option = document.createElement('option');
                                                    option.value = size.id; // Assuming 'id' is the ID from the database
                                                    option.textContent = size.size; // Assuming 'size' is the size name from the database
                                                    sizeSelect.appendChild(option);
                                                });

                                                // Enable size select
                                                sizeSelect.disabled = false;
                                            } else {
                                                // If sizes array is empty, display a message
                                                sizeSelect.innerHTML = '<option value="" selected>هیچ سایزی یافت نشد</option>';
                                                sizeSelect.disabled = true;
                                            }
                                        } else {
                                            console.error('Request failed: ' + xhr.status);
                                        }
                                    }
                                };

                                // Adjust the URL according to your server endpoint
                                xhr.open('GET', 'get_sizes.php?piece_name=' + encodeURIComponent(selectedPieceName), true);
                                xhr.send();
                            });
                        });
                    </script>













                    <div class="row mt-3">

                        <div class="col-md-6">
                            <label for="level" class="form-label fw-semibold">
                                مرحله</label>
                            <select name="level" class="form-select" aria-label="Default select example" required>
                                <option value="" selected>یکی از مراحل زیر را انتخاب کنید</option>
                                <option value="1">یک</option>
                                <option value="2">دو</option>
                                <option value="3">سه</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="numbers" class="form-label fw-semibold">
                                تعداد</label>
                            <input type="number" name="numbers" class="form-control" required>
                        </div>
                    </div>









                    <br>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="start" class="form-label fw-semibold">
                                ساعت شروع تولید قطعه</label>
                            <input id="startTime" name="start" type="time" class="form-control input-md" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stop" class="form-label fw-semibold">
                                ساعت پایان تولید قطعه</label>
                            <input id="stopTime" name="stop" type="time" class="form-control input-md" required>
                            <div id="error" style="color: red;"></div>
                        </div>
                    </div>

                    <script>
                        var startTimeInput = document.getElementById("startTime");
                        var stopTimeInput = document.getElementById("stopTime");
                        var errorDiv = document.getElementById("error");

                        // Function to check if stop time is less than start time
                        function checkTimeValidity() {
                            var startTime = startTimeInput.valueAsNumber;
                            var stopTime = stopTimeInput.valueAsNumber;

                            if (stopTime <= startTime) {
                                errorDiv.textContent = "* ساعت پایان باید بیشتر از ساعت شروع باشد";
                            } else {
                                errorDiv.textContent = "";
                            }
                        }

                        // Add event listeners to both input fields
                        startTimeInput.addEventListener("change", checkTimeValidity);
                        stopTimeInput.addEventListener("change", checkTimeValidity);
                    </script>






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
                            <div id="error2" style="color: red;"></div>


                        </div>

                        <div class="col-md-6">
                            <label for="couse_stop" class="form-label fw-semibold">
                                علت توقف</label>
                            <textarea type="text" name="couse_stop" class="form-control"></textarea>
                        </div>
                    </div>


                    <script>
                        var startTimeInput2 = document.getElementById("start_stop");
                        var stopTimeInput2 = document.getElementById("finish_stop");
                        var errorDiv2 = document.getElementById("error2");

                        // Function to check if stop time is less than start time
                        function checkTimeValidity2() {
                            var startTime = startTimeInput2.valueAsNumber;
                            var stopTime = stopTimeInput2.valueAsNumber;

                            if (stopTime <= startTime) {
                                errorDiv2.textContent = " * ساعت دوم باید بیشتر از ساعت اول باشد";
                            } else {
                                errorDiv2.textContent = "";
                            }
                        }

                        // Add event listeners to both input fields
                        startTimeInput2.addEventListener("change", checkTimeValidity2);
                        stopTimeInput2.addEventListener("change", checkTimeValidity2);
                    </script>




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





                    <div class="row mt-3" style="margin-bottom: 200px;">


                        <div class="col-md-6">
                            <label for="sub_date" class="form-label fw-semibold">
                                تاریخ</label>
                            <input id="pdpDark" type="text" name="sub_date" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-6">
                            <label for="extra_explanation" class="form-label fw-semibold">
                                توضیحات اضافی</label>
                            <textarea name="extra_explanation" class="form-control"></textarea>
                        </div>


                    </div>




                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="submit_go" class="btn btn-primary">ثبت و ادامه</button>
                        </div>

                        <div class="col-md-4"></div>

                        <div class="col-md-2 mt-3">
                            <button name="final_submit" class="btn btn-primary ">ثبت نهایی</button>
                        </div>

                    </div>




                </form>




                <?php

                if ($show_table_for_user = 1) { ?>
                    <div class="row mt-5">

                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table class="table border border-4">
                                    <h4>نگاه کلی :</h4>
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ردیف</th>
                                            <th scope="col" class="text-center">نام دستگاه</th>
                                            <th scope="col" class="text-center">کد </th>
                                            <th scope="col" class="text-center">نام قطعه</th>
                                            <th scope="col" class="text-center">سایز </th>
                                            <th scope="col" class="text-center">شیفت</th>
                                            <th scope="col" class="text-center">تاریخ</th>
                                            <th scope="col" class="text-center">تعداد</th>
                                            <th scope="col" class="text-center">از ساعت</th>
                                            <th scope="col" class="text-center">تا ساعت</th>
                                            <th scope="col" class="text-center">تایید و ادامه</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        $sql = "SELECT * FROM products WHERE user= $id AND status =0 AND user_confirm =0 
                                                ORDER BY id DESC LIMIT 10";
                                        // echo $sql;

                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $a = 1;
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <!-- Table rows -->
                                                <tr>
                                                    <th scope="row" class="text-center"><?= $a ?></th>
                                                    <td class="text-center"><?= $row['device_name'] ?></td>
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
                                                    <td class="text-center"><?= $row['numbers'] ?></td>
                                                    <td class="text-center"><?= $row['start'] ?></td>
                                                    <td class="text-center"><?= $row['stop'] ?></td>
                                                    <td class="text-center">

                                                        <form action="" method="GET">
                                                            <input type="hidden" value="<?= $row['id'] ?>" name="id_pro">
                                                            <input type="hidden" value="<?= $row['user'] ?>" name="to_user">
                                                            <button name="accept_user" class="btn btn-outline-success btn-sm">تایید میکنم</button>
                                                            <!-- Change the type of the button to "button" -->
                                                            <!-- <button name="edit_user" id="reject_button" class="btn btn-outline-warning btn-sm">نیاز به ویرایش</button> -->
                                                            <!-- <a href="edit_pro.php?id_pro=<?= $row['id'] ?>" name="" id="reject_button" class="btn btn-outline-warning btn-sm">نیاز به ویرایش</a> -->
                                                            <button name="delete_user" class="btn btn-outline-danger btn-sm">حذف</button>

                                                        </form>

                                                    </td>






                                                </tr>
                                        <?php
                                                $a++;
                                            }
                                        }
                                        ?>
                                    </tbody>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

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



            // $("#pdpDark").persianDatepicker({
            //     theme: "dark",
            //     alwaysShow: true,
            // });



            // Initialize PersianDatepicker with desired options
            $("#pdpDark").persianDatepicker({
                theme: "dark",
                alwaysShow: false, // Datepicker will appear only when the input field is clicked
                onSelect: function(selectedDate) {
                    this.destroy(); // Close the datepicker after a date is selected
                }
            });

            // Add event listener to the input field to reinitialize PersianDatepicker when clicked
            $("#pdpDark").on('click', function() {
                $(this).persianDatepicker('show');
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





    <!-- To avoid entering Persian letters  -->
    <script>
        // Function to alert when Persian numbers are entered in input fields
        document.addEventListener('DOMContentLoaded', function() {
            var textInputs = document.querySelectorAll('input[type="text"]');
            textInputs.forEach(function(input) {
                input.addEventListener('input', function(event) {
                    var persianNumbers = /[۰-۹]/g;
                    if (persianNumbers.test(this.value)) {
                        alert('Please enter only English numbers.');
                        // Clear the input value
                        this.value = '';
                    }
                });
            });
        });
    </script>



</body>

</html>


<?php

if (isset($_POST['submit_go'])) {

    $user = $_SESSION['all_data']['id'];

    $shift = $conn->real_escape_string($_POST['shift']);
    $device_name = $conn->real_escape_string($_POST['device_name']);
    $device_number = $conn->real_escape_string($_POST['device_number']);
    $piece_name = $conn->real_escape_string($_POST['piece_name']);
    // $piece_id = $conn->real_escape_string($_POST['piece_id']);
    $size = $conn->real_escape_string($_POST['size']);
    $level = $conn->real_escape_string($_POST['level']);
    $numbers = $conn->real_escape_string($_POST['numbers']);
    $had_stop = $conn->real_escape_string($_POST['had_stop']);
    if ($had_stop == 1) {
        $start_stop = $conn->real_escape_string($_POST['start_stop']);
        $finish_stop = $conn->real_escape_string($_POST['finish_stop']);
        $couse_stop = $conn->real_escape_string($_POST['couse_stop']);
    } else {
        $start_stop = NULL;
        $finish_stop = NULL;
        $couse_stop = NULL;
    }



    $sub_date = $conn->real_escape_string($_POST['sub_date']);

    $start = $conn->real_escape_string($_POST['start']);
    $stop = $conn->real_escape_string($_POST['stop']);



    $explanation = $conn->real_escape_string($_POST['extra_explanation']);



    $sql1 = "SELECT * FROM products WHERE date = ? AND device_name = ? AND start = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("sss", $sub_date, $device_name, $start);
    $stmt->execute();
    $result1 = $stmt->get_result();



    if ($result1->num_rows > 0) {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
        <div class='toast-header bg-danger text-white'>
            <strong class='mr-auto'>Error</strong>
            <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='toast-body'>
            این محصول را قبلا وارد کردید!
        </div>
      </div>
      <script>
        $(document).ready(function(){
            $('#errorToast').toast('show');
            setTimeout(function(){
                $('#errorToast').toast('hide');
            }, 3000);
        });
      </script>";
        exit;
    }


    $sql = "INSERT INTO products (device_name, device_number, piece_name, shift, 
                    size, level, numbers, had_stop, start_stop, finish_stop,
                    date,start,stop,
                    couse_stop, explanation, user, created_at)
            VALUES ('$device_name', '$device_number', '$piece_name', '$shift', 
                    '$size', '$level', '$numbers', '$had_stop', '$start_stop', '$finish_stop', 
                     '$sub_date', '$start', '$stop',
                    '$couse_stop', '$explanation', '$user', NOW())";

    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        $show_table_for_user = 1;
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    محصول به درستی اضافه شد!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'submit_pro';
                        }, 1000);
                    }, 1000);
                });
            </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در افزودن محصول پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 3000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['final_submit'])) {

    $user = $_SESSION['all_data']['id'];

    $shift = $conn->real_escape_string($_POST['shift']);
    $device_name = $conn->real_escape_string($_POST['device_name']);
    $device_number = $conn->real_escape_string($_POST['device_number']);
    $piece_name = $conn->real_escape_string($_POST['piece_name']);
    // $piece_id = $conn->real_escape_string($_POST['piece_id']);
    $size = $conn->real_escape_string($_POST['size']);
    $level = $conn->real_escape_string($_POST['level']);
    $numbers = $conn->real_escape_string($_POST['numbers']);
    $had_stop = $conn->real_escape_string($_POST['had_stop']);
    if ($had_stop == 1) {
        $start_stop = $conn->real_escape_string($_POST['start_stop']);
        $finish_stop = $conn->real_escape_string($_POST['finish_stop']);
        $couse_stop = $conn->real_escape_string($_POST['couse_stop']);
    } else {
        $start_stop = NULL;
        $finish_stop = NULL;
        $couse_stop = NULL;
    }



    $sub_date = $conn->real_escape_string($_POST['sub_date']);

    $start = $conn->real_escape_string($_POST['start']);
    $stop = $conn->real_escape_string($_POST['stop']);



    $explanation = $conn->real_escape_string($_POST['extra_explanation']);


    $sql1 = "SELECT * FROM products WHERE date = ? AND device_name = ? AND start = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("sss", $sub_date, $device_name, $start);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result1->num_rows > 0) {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
        <div class='toast-header bg-danger text-white'>
            <strong class='mr-auto'>Error</strong>
            <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='toast-body'>
            این محصول را قبلا وارد کردید!
        </div>
      </div>
      <script>
        $(document).ready(function(){
            $('#errorToast').toast('show');
            setTimeout(function(){
                $('#errorToast').toast('hide');
            }, 3000);
        });
      </script>";
        exit;
    }


    $sql = "INSERT INTO products (device_name, device_number, piece_name, shift, 
                    size, level, numbers, had_stop, start_stop, finish_stop,
                    date,start,stop,
                    couse_stop, explanation, user , user_confirm, created_at)
            VALUES ('$device_name', '$device_number', '$piece_name', '$shift', 
                    '$size', '$level', '$numbers', '$had_stop', '$start_stop', '$finish_stop', 
                     '$sub_date', '$start', '$stop',
                    '$couse_stop', '$explanation', '$user', 1, NOW())";

    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        $show_table_for_user = 0;
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    محصول به درستی اضافه شد!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                    }, 3000);
                });
              </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در افزودن محصول پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 3000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}






if (isset($_GET['accept_user'])) {

    $id_pro = $_GET['id_pro'];


    $sql = "UPDATE products SET user_confirm = 1 WHERE id = $id_pro";
    $result = $conn->query($sql);
    if ($result) {
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    محصول با موفقیت تایید شد!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'submit_pro';
                        }, 1000);
                    }, 1000);
                });
                </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در تایید محصول پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 1000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_GET['delete_user'])) {
    $id_pro = $_GET['id_pro'];

    $sql = "DELETE FROM products WHERE id = $id_pro";

    $result = $conn->query($sql);
    if ($result) {
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    محصول با موفقیت حذف شد!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'submit_pro';
                        }, 1000);
                    }, 1000);
                });
                </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در حذف محصول پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 1000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
