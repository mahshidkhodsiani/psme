<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}


// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش محصول</title>
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

    <!-- <div class="spinner-border text-warning" role="status">
        <span class="sr-only">Loading...</span>
    </div> -->
    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex ">
                <?php
                include 'sidebar.php';
                ?>

            </div>

            <div class="col-md-8">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت روزانه محصولات (ویرایش) : </h3>

                <?php
                if (isset($_GET['id_pro'])) {
                    $id_pro = $_GET['id_pro'];

                    $sql = "SELECT * FROM products WHERE id = $id_pro";

                    // echo $sql;
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    // var_dump($row);

                ?>
                    <form action="edit_pro.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                        <div class="row">
                            <p>نکات :</p>
                            <p style="color: red;">* شماره دستگاه و سایز قطعه را حتما از اول وارد کنید</p>
                            <div class="col-md-6">
                                <label for="shift" class="form-label fw-semibold">شیفت</label>
                                <select name="shift" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected>یکی از شیفت های زیر را انتخاب کنید</option>
                                    <option value="1" <?php if ($row['shift'] == 1) echo 'selected'; ?>>روز</option>
                                    <option value="2" <?php if ($row['shift'] == 2) echo 'selected'; ?>>عصر</option>
                                    <option value="3" <?php if ($row['shift'] == 3) echo 'selected'; ?>>شب</option>
                                </select>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-md-6">
                                <label for="device_name" class="form-label fw-semibold">نام دستگاه *</label>
                                <select name="device_name" id="device_name" class="form-select"  onchange="getNumbers()" required>
                                    <option value="" selected>یکی از دستگاه های زیر را انتخاب کنید</option>
                                    <?php
                                    $sql = "SELECT name, MIN(id) AS id FROM devices GROUP BY name ORDER BY name";

                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($device_row = $result->fetch_assoc()) {
                                            $selected = ($device_row['name'] == $row['device_name']) ? 'selected' : '';
                                    ?>
                                            <option id="<?= $device_row['id'] ?>" value="<?= $device_row['name'] ?>" <?= $selected ?>><?= $device_row['name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>





                            <div class="col-md-6">
                                <label for="device_number" class="form-label">کد دستگاه:</label>
                                <select class="form-select" name="device_number" id="device_number">
                                    <?php
                                    // Pre-select a size option if needed
                                    $selected_size = ($row['device_number']) ? $row['device_number'] : '';
                                    ?>
                                    <option value="<?= $selected_size ?>" selected><?= $selected_size ?></option>
                                    <option value="" disabled>ابتدا اسم دستگاه را وارد کنید</option>
                                </select>
                            </div>
                        </div>




















                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="piece_name" class="form-label">نام قطعه:</label>
                                <select class="form-select" id="piece_name" name="piece_name" onchange="getSizes()">
                                    <option value="">همه</option>
                                    <?php
                                    // $sql = "SELECT DISTINCT name FROM pieces";
                                    $sql = "SELECT name, MIN(id) AS id FROM pieces GROUP BY name";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($piece_row = $result->fetch_assoc()) {
                                            $selected = ($piece_row['name'] == $row['piece_name']) ? 'selected' : '';
                                    ?>
                                            <option id="<?= $piece_row['id'] ?>" value="<?= $piece_row['name'] ?>" <?= $selected ?>><?= $piece_row['name'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="piece_size" class="form-label">سایز قطعه:</label>
                                <select class="form-select" name="piece_size" id="piece_size">
                                    <?php
                                    // Pre-select a size option if needed
                                    $selected_size = ($row['piece_size']) ? $row['piece_size'] : '';
                                    ?>
                                    <option value="<?= $selected_size ?>" selected><?= $selected_size ?></option>
                                    <option value="" disabled>ابتدا نام قطعه را وارد کنید</option>
                                </select>
                            </div>
                        </div>






















                        <div class="row mt-3">

                            <div class="col-md-6">
                                <label for="level" class="form-label fw-semibold">مرحله</label>
                                <select name="level" class="form-select" aria-label="Default select example" required>
                                    <option value="" selected>یکی از مراحل زیر را انتخاب کنید</option>
                                    <option value="1" <?php if (isset($row['level']) && $row['level'] == '1') echo ' selected'; ?>>یک</option>
                                    <option value="2" <?php if (isset($row['level']) && $row['level'] == '2') echo ' selected'; ?>>دو</option>
                                    <option value="3" <?php if (isset($row['level']) && $row['level'] == '3') echo ' selected'; ?>>سه</option>
                                </select>
                            </div>


                            <div class="col-md-6">
                                <label for="numbers" class="form-label fw-semibold">تعداد</label>
                                <input type="number" name="numbers" class="form-control" value="<?php echo isset($row['numbers']) ? $row['numbers'] : ''; ?>" required>
                            </div>

                        </div>




                        <div class="row mt-3">

                            <div class="col-md-6">
                                <label for="had_stop" class="form-label fw-semibold">توقف (دقیقه)</label>
                                <select name="had_stop" id="had_stop" class="form-select" aria-label="Default select example">
                                    <option value="0" <?php if (isset($row['had_stop']) && $row['had_stop'] == '0') echo ' selected'; ?>>نداشتم</option>
                                    <option value="1" <?php if (isset($row['had_stop']) && $row['had_stop'] == '1') echo ' selected'; ?>>داشتم</option>
                                </select>
                            </div>

                        </div>



                        <div class="row mt-3" id="times_stop" style="display: none;">
                            <div class="col-md-6">
                                <label for="start_stop" class="form-label fw-semibold">از ساعت</label>
                                <input type="time" class="form-control input-md" name="start_stop" id="start_stop" value="<?php echo isset($row['start_stop']) ? $row['start_stop'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="finish_stop" class="form-label fw-semibold">تا ساعت</label>
                                <input type="time" class="form-control input-md" name="finish_stop" id="finish_stop" value="<?php echo isset($row['finish_stop']) ? $row['finish_stop'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="couse_stop" class="form-label fw-semibold">علت توقف</label>
                                <textarea type="text" name="couse_stop" class="form-control"><?php echo isset($row['couse_stop']) ? $row['couse_stop'] : ''; ?></textarea>
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
                                <label for="start" class="form-label fw-semibold">ساعت شروع تولید قطعه</label>
                                <input name="start" type="time" class="form-control input-md" required value="<?php echo isset($row['start']) ? $row['start'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="stop" class="form-label fw-semibold">ساعت پایان تولید قطعه</label>
                                <input name="stop" type="time" class="form-control input-md" required value="<?php echo isset($row['stop']) ? $row['stop'] : ''; ?>">
                            </div>
                        </div>



                        <div class="row mt-3" style="margin-bottom: 200px;">


                            <div class="col-md-6">
                                <label for="sub_date" class="form-label fw-semibold">
                                    تاریخ</label>
                                <input id="pdpDark" type="text" name="sub_date" class="form-control" autocomplete="off" value="<?php echo isset($row['date']) ? $row['date'] : ''; ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="extra_explanation" class="form-label fw-semibold">
                                    توضیحات اضافی</label>
                                <textarea name="extra_explanation" class="form-control"><?php echo isset($row['explanation']) ? $row['explanation'] : ''; ?></textarea>
                                <input type="hidden" name="id_pro" value="<?= $id_pro ?>">
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




    <script>
        $(document).ready(function() {
            // Call the function to get sizes with the initially selected piece name
            getNumbers();

            // Attach change event listener to the piece name select element
            $('#device_name').change(function() {
                // Call the function to get sizes whenever the piece name changes
                getNumbers();
            });
        });

        function getNumbers() {
            // Get the piece name entered by the user
            var pieceName = document.getElementById("device_name").value;

            // Check if a piece name is provided
            if (pieceName.trim() !== '') {
                $.ajax({
                    type: 'GET',
                    url: 'get_numbers.php',
                    data: {
                        device_name: pieceName
                    },
                    dataType: 'json', // Specify JSON data type
                    success: function(data) {
                        console.log("Received data:", data); // Log received data
                        var sizesHtml = '<option value="">Select a size</option>'; // Add a placeholder option

                        // Construct HTML for sizes
                        data.forEach(function(item) {
                            sizesHtml += '<option value="' + item.id + '">' + item.numbers + '</option>';
                        });

                        console.log("Generated HTML:", sizesHtml); // Log generated HTML

                        // Replace the default option with the sizes
                        $('#device_number').html(sizesHtml);
                    },
                    error: function() {
                        // Handle errors
                        alert("Error fetching sizes");
                    }
                });
            } else {
                // If no piece name is provided, show a placeholder in the size select element
                $('#device_number').html('<option value="">Select a piece first</option>');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Call the function to get sizes with the initially selected piece name
            getSizes();

            // Attach change event listener to the piece name select element
            $('#piece_name').change(function() {
                // Call the function to get sizes whenever the piece name changes
                getSizes();
            });
        });

        function getSizes() {
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
                    },
                    error: function() {
                        // Handle errors
                        alert("Error fetching sizes");
                    }
                });
            } else {
                // If no piece name is provided, show a placeholder in the size select element
                $('#piece_size').html('<option value="">Select a piece first</option>');
            }
        }
    </script>


</body>

</html>

<?php

if (isset($_POST['submit_go'])) {
    // Get the user ID from the session
    $user = $_SESSION['all_data']['id'];

    $id_pro = $_POST['id_pro'];

    if(empty($_POST['device_number'])){
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    کد دستگاه خالی وارد شده لطفا دوباره تلاش کنید!
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

    }

    // var_dump($_POST);

    // Escape and retrieve form data
    $shift = $conn->real_escape_string($_POST['shift']);
    $device_name = $conn->real_escape_string($_POST['device_name']);
    $device_number = $conn->real_escape_string($_POST['device_number']);
    $piece_name = $conn->real_escape_string($_POST['piece_name']);
    $piece_size = $conn->real_escape_string($_POST['piece_size']);
    $level = $conn->real_escape_string($_POST['level']);
    $numbers = $conn->real_escape_string($_POST['numbers']);
    $had_stop = $conn->real_escape_string($_POST['had_stop']);
    $start_stop = $conn->real_escape_string($_POST['start_stop']);
    $finish_stop = $conn->real_escape_string($_POST['finish_stop']);
    $couse_stop = $conn->real_escape_string($_POST['couse_stop']);
    $sub_date = $conn->real_escape_string($_POST['sub_date']);
    $start = $conn->real_escape_string($_POST['start']);
    $stop = $conn->real_escape_string($_POST['stop']);
    $explanation = $conn->real_escape_string($_POST['extra_explanation']);

    // Construct the SQL UPDATE query
    $sql = "UPDATE products SET
                device_name = '$device_name',
                device_number = '$device_number',
                piece_name = '$piece_name',
                shift = '$shift',
                size = '$piece_size',
                level = '$level',
                numbers = '$numbers',
                had_stop = '$had_stop',
                start_stop = '$start_stop',
                finish_stop = '$finish_stop',
                date = '$sub_date',
                start = '$start',
                stop = '$stop',
                couse_stop = '$couse_stop',
                explanation = '$explanation'
            WHERE id = $id_pro"; // Assuming $id_pro holds the ID of the product to be updated

    // Execute the query
    $result = $conn->query($sql);

    if ($result) {
        // Show success message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    محصول به درستی به‌روزرسانی شد!
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
        // Show error message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در به‌روزرسانی محصول پیش آمده!
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
