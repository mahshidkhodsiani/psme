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
                            <label for="device_name" class="form-label fw-semibold">
                                نام دستگاه</label>
                            <select name="device_name" id="device_name" class="form-select" aria-label="Default select example" required>
                                <option value="" selected>یکی از دستگاه های زیر را انتخاب کنید</option>
                                <?php
                               $sql = "SELECT name, MIN(id) AS id FROM devices GROUP BY name ORDER BY name";


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
                            <select name="device_number" id="device_number" class="form-select" aria-label="Default select example" required>
                                <option value="" selected disabled>ابتدا اسم دستگاه را وارد کنید</option>
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




                    <!-- <script>
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
                    </script> -->




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



                
                    <div class="row mt-3">
                      
                        <div class="col-md-6">
                            <label for="had_stop" class="form-label fw-semibold">
                                توقف (دقیقه)</label>
                            <!-- <input type="text" name="had_stop" class="form-control"> -->
                            <select name="had_stop" id="had_stop" class="form-select" aria-label="Default select example" >
                                
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



    
                    <br>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="start" class="form-label fw-semibold">
                                ساعت شروع تولید قطعه</label>
                            <input name="start" type="time" class="form-control input-md" required>
                        </div>
                        <div class="col-md-6">
                            <label for="stop" class="form-label fw-semibold">
                                ساعت پایان تولید قطعه</label>
                            <input name="stop" type="time" class="form-control input-md" required>
                        </div>
                    </div>
                    <div class="row mt-3" style="margin-bottom: 200px;">
                       

                        <div class="col-md-6">
                            <label for="sub_date" class="form-label fw-semibold">
                                تاریخ</label>
                            <input id="pdpDark" type="text" name="sub_date" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-6">
                            <label for="extra_explanation" class="form-label fw-semibold">
                                توضیحات اضافی</label>
                            <textarea name="extra_explanation" class="form-control" ></textarea>
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
    $had_stop = $conn->real_escape_string($_POST['had_stop']);
    if($had_stop == 1){
        $start_stop = $conn->real_escape_string($_POST['start_stop']);
        $finish_stop = $conn->real_escape_string($_POST['finish_stop']);
        $couse_stop = $conn->real_escape_string($_POST['couse_stop']);
    }else{
        $start_stop = NULL;
        $finish_stop = NULL;
        $couse_stop = NULL;
    }
    
   

    $sub_date = $conn->real_escape_string($_POST['sub_date']);
 
    $start = $conn->real_escape_string($_POST['start']);
    $stop = $conn->real_escape_string($_POST['stop']);
   
   
   
    $explanation = $conn->real_escape_string($_POST['extra_explanation']);



    $sql = "INSERT INTO products (device_name, device_number, piece_name, shift, 
                    size, level, numbers, had_stop, start_stop, finish_stop,
                    date,start,stop,
                    couse_stop, explanation, user)
            VALUES ('$device_name', '$device_number', '$piece_name', '$shift', 
                    '$size', '$level', '$numbers', '$had_stop', '$start_stop', '$finish_stop', 
                     '$sub_date', '$start', '$stop',
                    '$couse_stop', '$explanation', '$user')";

    // Execute the query
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
                    قطعه به درستی اضافه شد!
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
                    خطایی در افزودن قطعه پیش آمده!
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



