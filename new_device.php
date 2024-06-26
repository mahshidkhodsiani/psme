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
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php'; 
        include 'config.php';
    ?>
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
        .suggestions {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            background: #fff;
        }

        .suggestion {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion:hover {
            background: #f0f0f0;
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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت دستگاه جدید : </h3>



                <!-- Include jQuery library -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <form id="newPieceForm" action="new_device.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">نام دستگاه</label>
                            <input type="text" name="name" id="name" class="form-control" required autocomplete="off">
                            <div id="nameSuggestions" class="suggestions"></div> <!-- Suggestions dropdown for name -->
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">کد دستگاه</label>
                            <input type="text" name="size" id="size" class="form-control" required autocomplete="off">
                            <div id="sizeSuggestions" class="suggestions"></div> <!-- Suggestions dropdown for size -->
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="enter" class="btn btn-outline-primary">ثبت</button>
                        </div>
                    </div>
                </form>






                <div class="row mt-4">
                    <div class="col-md-10">
                        <div class="table-responsive">
                          

                            
                            <?php

                            // Pagination configuration
                            $items_per_page = 10; // Number of items per page
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                            // Calculate the offset for the SQL query
                            $offset = ($current_page - 1) * $items_per_page;

                            // SQL query to retrieve a subset of rows based on pagination
                            $sql = "SELECT * FROM devices ORDER BY name COLLATE utf8mb4_persian_ci LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);
                            
                            
                            if ($result->num_rows > 0) {
                                $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                            ?>
                            <table class="table border border-4">
                                <h4>نگاه کلی :</h4>
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">نام دستگاه</th>
                                        <th scope="col" class="text-center">کد</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= $row['name'] ?></td>
                                            <td class="text-center"><?= $row['numbers'] ?></td>
                                            <td class="text-center">
                                                <form action="" method="GET">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_dev">
                                                    <a href="edit_dev.php?id_dev=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm"> ویرایش</a>
                                                    <button type="submit" name="delete_dev" 
                                                        class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">حذف</button>
                                                </form>
                                            </td>
                                            <script>
                                                function confirmDelete() {
                                                    return confirm("آیا مطمئن هستید که می‌خواهید این مورد را رد کنید؟");
                                                }
                                            </script>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                                <?php
                            
                                // Pagination links
                                $sql = "SELECT COUNT(*) AS total FROM devices";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $total_items = $row['total'];
                                $total_pages = ceil($total_items / $items_per_page);
                            
                                // Display pagination links
                                ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            ?>
                                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                <?php
                                } else {
                                    echo "<p>هیچ مشابهی پیدا نشد.</p>";
                                }
                                ?>
                        </div>
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

    <script>
        $(document).ready(function() {
            // Handle input for name suggestions
            $('#name').on('input', function() {
                var input = $(this).val();
                if (input.length >= 2) {
                    $.ajax({
                        url: 'suggestions_device.php', // Replace with your backend endpoint
                        method: 'POST',
                        data: { input: input, type: 'name' }, // Send input and type to backend
                        success: function(response) {
                            $('#nameSuggestions').html(response); // Update suggestions dropdown
                        }
                    });
                } else {
                    $('#nameSuggestions').empty(); // Clear suggestions if input length is less than 2
                }
            });

            // Handle input for size suggestions
            $('#size').on('input', function() {
                var input = $(this).val();
                if (input.length >= 2) {
                    $.ajax({
                        url: 'suggestions_device.php', // Replace with your backend endpoint
                        method: 'POST',
                        data: { input: input, type: 'numbers' }, // Send input and type to backend
                        success: function(response) {
                            $('#sizeSuggestions').html(response); // Update suggestions dropdown
                        }
                    });
                } else {
                    $('#sizeSuggestions').empty(); // Clear suggestions if input length is less than 2
                }
            });

            // Click handler for name suggestions
            $(document).on('click', '#nameSuggestions .suggestion', function() {
                var name = $(this).text().trim(); // Extract name from suggestion text
                $('#name').val(name); // Populate name input
                $('#nameSuggestions').html(''); // Clear suggestions dropdown after selection
            });

            // Click handler for size suggestions
            $(document).on('click', '#sizeSuggestions .suggestion', function() {
                var numbers = $(this).text().trim(); // Extract numbers from suggestion text
                $('#size').val(numbers); // Populate size input
                $('#sizeSuggestions').html(''); // Clear suggestions dropdown after selection
            });
        });


    </script>

    <script>
       $(document).ready(function() {
            // Simulated list of previous entries (you should replace this with your actual data)
            var previousEntries = [
                { name: "Device1", size: "Size1" },
                { name: "Device2", size: "Size2" },
                { name: "Device3", size: "Size3" }
            ];

            // Function to populate suggestions based on previous entries
            function populateSuggestions(entries, type) {
                var suggestionsHtml = '';
                entries.forEach(function(entry) {
                    var value = type === 'name' ? entry.name : entry.size;
                    suggestionsHtml += `<div class="suggestion">${value}</div>`;
                });
                return suggestionsHtml;
            }

            // Function to handle suggestion click
            function handleSuggestionClick(value, type) {
                if (type === 'name') {
                    $('#name').val(value);
                    $('#nameSuggestions').html(''); // Clear suggestions after selection
                } else if (type === 'size') {
                    $('#size').val(value);
                    $('#sizeSuggestions').html(''); // Clear suggestions after selection
                }
            }

            // Handle input for name suggestions
            $('#name').on('input', function() {
                var input = $(this).val();
                var suggestionsHtml = '';

                if (input.length >= 2) {
                    var filteredEntries = previousEntries.filter(function(entry) {
                        return entry.name.toLowerCase().includes(input.toLowerCase());
                    });
                    suggestionsHtml = populateSuggestions(filteredEntries, 'name');
                }
                $('#nameSuggestions').html(suggestionsHtml);
            });

            // Handle input for size suggestions
            $('#size').on('input', function() {
                var input = $(this).val();
                var suggestionsHtml = '';

                if (input.length >= 2) {
                    var filteredEntries = previousEntries.filter(function(entry) {
                        return entry.size.toLowerCase().includes(input.toLowerCase());
                    });
                    suggestionsHtml = populateSuggestions(filteredEntries, 'size');
                }
                $('#sizeSuggestions').html(suggestionsHtml);
            });

            // Click handler for suggestions
            $(document).on('click', '.suggestion', function() {
                var value = $(this).text();
                var inputId = $(this).closest('.col-md-6').find('input').attr('id'); // Get input field ID
                var type = inputId === 'name' ? 'name' : 'size';
                handleSuggestionClick(value, type);
            });
        });

    </script>


    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    

</body>

</html>


<?php


if (isset($_POST['enter'])) {
    // include 'config.php';

    $name = $conn->real_escape_string($_POST['name']);
    $size = $conn->real_escape_string($_POST['size']);



    // check for duplicates :
    $sql1 = "SELECT * FROM devices WHERE name = '$name' AND numbers = '$size'";
    $result1 = $conn->query($sql1);
    if ($result1-> num_rows > 0) {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    این دستگاه قبلا به ثبت رسیده لطفا دستگاه جدید وارد کنید !
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
    }else{

        // Construct the SQL query using placeholders
        $sql = "INSERT INTO devices (name, numbers)
                VALUES ('$name', '$size')";

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
                        دستگاه به درستی اضافه شد!
                    </div>
                </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_device';
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
                        خطایی در افزودن دستگاه پیش آمده!
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
  

}


if(isset($_GET['delete_dev'])){

    $id_dev = $_GET['id_dev'];

    $sql = "DELETE FROM devices WHERE id = $id_dev";
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
                    دستگاه با موفقیت حذف شد!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_device';
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
                    خطایی در حذف دستگاه پیش آمده!
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

