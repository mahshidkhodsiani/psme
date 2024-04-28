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
    <title>افزودن دستگاه جدید</title>
    <?php include 'includes.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <div class="col-md-3 col-sm-12 d-flex">
                <?php
                include 'sidebar.php';
                ?>

            </div>

            <div class="col-md-8 col-sm-12">
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت دستگاه جدید : </h3>



                <!-- Include jQuery library -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <!-- Your HTML form -->
                <form id="newPieceForm" action="new_device.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">نام قطعه</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">سایز قطعه</label>
                            <input type="text" name="size" id="size" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">قیمت قطعه(تومان)</label>
                            <input type="number" name="price" id="price" placeholder="به انگلیسی وارد کنید" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label fw-semibold">زمان لازم برای تولید</label>
                            <input type="number" name="time" id="time" placeholder="به انگلیسی وارد کنید" class="form-control" required>
                        </div>
                    </div>
                 
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="enter" class="btn btn-outline-primary">ثبت</button>
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


    <script>
        // Function to prevent Persian numbers from being entered
        function preventPersianNumbers(event) {
            var persianNumbersRegex = /[\u06F0-\u06F9]/; // Range of Persian numbers in Unicode
            var inputKey = String.fromCharCode(event.keyCode);
            if (persianNumbersRegex.test(inputKey)) {
                event.preventDefault();
            }
        }

        // Attach the preventPersianNumbers function to input fields
        document.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('keypress', preventPersianNumbers);
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</body>

</html>


<?php


if (isset($_POST['enter'])) {
    include 'config.php';

    $name = $conn->real_escape_string($_POST['name']);
    $size = $conn->real_escape_string($_POST['size']);
    $price = $conn->real_escape_string($_POST['price']);
    $time = $conn->real_escape_string($_POST['time']);


  

    // Construct the SQL query using placeholders
    $sql = "INSERT INTO pices (name, size, price, time_one)
            VALUES ('$name', '$size', '$price', '$time')";

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
    }
}
?>
