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
    <title>افزودن قطعه جدید</title>
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
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت قطعه جدید : </h3>



                <!-- Include jQuery library -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <!-- Your HTML form -->
                <form id="newPieceForm" action="new_piece.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">نام قطعه</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <div id="similarPiecesName"></div> <!-- Placeholder for similar pieces by name -->
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">سایز</label>
                            <input type="text" name="size" id="size" class="form-control" required>
                            <div id="similarPiecesSize"></div> <!-- Placeholder for similar pieces by size -->
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">قیمت</label>
                            <input type="number" name="price" class="form-control" placeholder="تومان" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time_one" class="form-label fw-semibold">زمان تولید</label>
                            <input type="number" name="time_one" class="form-control" placeholder="ثانیه" required>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="enter" class="btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </form>




                <script>
                    $(document).ready(function() {
                        $('#name').keyup(function() {
                            var name = $(this).val();
                            if (name !== '') {
                                // Remove any existing custom validity message
                                $(this)[0].setCustomValidity('');
                                $.ajax({
                                    url: 'search_similar_piece.php',
                                    method: 'POST',
                                    data: {
                                        name: name
                                    },
                                    success: function(data) {
                                        $('#similarPiecesName').html(data);
                                        // Add click event handler for each similar piece by name
                                        $('#similarPiecesName div').click(function() {
                                            var selectedPiece = $(this).text();
                                            $('#name').val(selectedPiece);
                                            $('#similarPiecesName').html('');
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            } else {
                                // Set a custom validity message when the field is empty
                                $(this)[0].setCustomValidity('Please provide a name.');
                                $('#similarPiecesName').html('');
                                $('#similarPiecesSize').html(''); // Clear the sizes when name is empty
                            }
                        });

                        // Add event listener to remove the custom validity message when the field is not empty
                        $('#name').on('input', function() {
                            if ($(this).val() !== '') {
                                $(this)[0].setCustomValidity('');
                            }
                        });

                        // Click event handler for selecting a similar piece by size
                        $('#similarPiecesSize').on('click', 'div', function() {
                            var selectedPiece = $(this).text();
                            $('#size').val(selectedPiece);
                            $('#similarPiecesSize').html('');
                        });

                        $('#size').keyup(function() {
                            var size = $(this).val();
                            if ($('#name').val() !== '' && size !== '') { // Check if name is filled before fetching sizes
                                $.ajax({
                                    url: 'search_similar_piece.php',
                                    method: 'POST',
                                    data: {
                                        size: size
                                    },
                                    success: function(data) {
                                        $('#similarPiecesSize').html(data);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            } else {
                                $('#similarPiecesSize').html('');
                            }
                        });
                    });






                    //   for entering name first:

                    function toggleSizeInput() {
                        var nameValue = $('#name').val().trim(); // Get value of name input
                        if (nameValue !== '') {
                            $('#size').prop('disabled', false); // Enable size input if name is not empty
                            $('#size').attr('placeholder', ''); // Remove placeholder text if name is not empty
                        } else {
                            $('#size').prop('disabled', true); // Disable size input if name is empty
                            $('#size').attr('placeholder', 'اول نام قطعه را وارد کنید'); // Set placeholder text if name is empty
                        }
                    }

                    // Call toggleSizeInput on keyup event for name input
                    $('#name').keyup(function() {
                        toggleSizeInput(); // Call the function to toggle size input
                    });

                    // Call toggleSizeInput on page load
                    toggleSizeInput(); // Call the function to toggle size input initially
                </script>



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


    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

</body>

</html>


<?php


if (isset($_POST['enter'])) {
    include 'config.php';

    $name = $conn->real_escape_string($_POST['name']);
    $size = $conn->real_escape_string($_POST['size']);
    $price = $conn->real_escape_string($_POST['price']);
    $time_one = $conn->real_escape_string($_POST['time_one']);
    // Construct the SQL query using placeholders
    $sql = "INSERT INTO pieces (name, size, price, time)
            VALUES ('$name', '$size', '$price', '$time_one')";

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
