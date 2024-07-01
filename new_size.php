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
    <title>افزودن سایز جدید</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php'; 
        include 'config.php';
        include 'jalaliDate.php';
        include 'functions.php';
        $sdate = new SDate();
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
            <div class="col-md-3 col-sm-12 d-flex">
                <?php
                include 'sidebar.php';
                ?>

            </div>

            <div class="col-md-8 col-sm-12">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت سایز جدید : </h3>



                <!-- Include jQuery library -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

             

                <div class="row mt-4">
                    
                        <h4>اضافه کردن سایز جدید</h4>
                        <div class="row">
                            <div class="col-md-6">
                            <form action="" method="post">
                                <label for="new_size" class="form-label fw-semibold">سایز جدید</label>
                                <input type="text" name="new_size" id="new_size" class="form-control" required autocomplete="off">
                                <div id="sizeSuggestions" class="suggestions"></div> <!-- Suggestions dropdown for size -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        
                                        <button name="submit_size" class="btn btn-outline-primary">ثبت سایز</button>
                                       
                                    </div>
                                </div>
                            </form>
                            </div>

                            <div class="col-md-5">
                                <div class="table-responsive">
                                    
                                        <?php
                                          // Pagination configuration
                                        $items_per_page = 5; // Number of items per page
                                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                                        // Calculate the offset for the SQL query
                                        $offset = ($current_page - 1) * $items_per_page;
                                        $sql1 = "SELECT * FROM piece_size ORDER BY size COLLATE utf8mb4_general_ci
                                        LIMIT $items_per_page OFFSET $offset";
                                        $result = $conn->query($sql1);
                                        if($result->num_rows > 0) {
                                            $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                                            ?>


                                            <table class="table border">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">ردیف</th>
                                                        <th scope="col" class="text-center">سایز</th>
                                                        <th scope="col" class="text-center">حذف</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row1 = $result->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <th scope="row" class="text-center"><?= $a ?></th>
                                                            <td class="text-center"><?= $row1['size'] ?></td>
                                                            <td class="text-center">
                                                                <form method="post" action="">
                                                                    <input type="hidden" name="id_size" value="<?= $row1['id']?>">
                                                                    <button onclick="confirmDelete()" class="btn btn-outline-danger btn-sm" name="delete_size">حذف</button>
                                                               
                                                                </form>
                                                            </td>
                                                        
                                                        </tr>
                                                        <?php
                                                        $a++;
                                                    }
                                                    ?>
                                                </tbody>
                                            
                                            </table>
                                            <script>
                                                function confirmDelete() {
                                                    return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
                                                }
                                            </script>
                                            

                                            <?php
                                    
                                            // Pagination links
                                            $sql = "SELECT COUNT(*) AS total FROM piece_size";
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
                                                
                                        }
            
                                        ?>
                                    
                                </div>
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
                        url: 'suggestions_piece.php', // Replace with your backend endpoint
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
                        url: 'suggestions_piece.php', // Replace with your backend endpoint
                        method: 'POST',
                        data: { input: input, type: 'size' }, // Send input and type to backend
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
                var size = $(this).text().trim(); // Extract size from suggestion text
                $('#size').val(size); // Populate size input
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#new_size").on("input", function(){
                let input = $(this).val();
                if(input.length > 0){
                    $.ajax({
                        url: "suggestions_piece.php",
                        method: "POST",
                        data: {input: input, type: 'size'},
                        success: function(data){
                            $("#sizeSuggestions").html(data).show();
                        }
                    });
                } else {
                    $("#sizeSuggestions").hide();
                }
            });

            $(document).on("click", ".suggestion", function(){
                $("#new_size").val($(this).text());
                $("#sizeSuggestions").hide();
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#new_size, #sizeSuggestions').length) {
                    $("#sizeSuggestions").hide();
                }
            });
        });
    </script>


</body>

</html>


<?php




if (isset($_POST['submit_size'])) {
    $size = $conn->real_escape_string($_POST['new_size']);

    $sql1 = "SELECT * FROM piece_size WHERE size = ?";
    $stmt = $conn->prepare($sql1);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Correct bind_param to match the number of placeholders
    $stmt->bind_param('s', $size); // Only one placeholder and one variable

    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

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
                    این سایز قبلا به ثبت رسیده لطفا سایز جدید وارد کنید !
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
        $sql = "INSERT INTO piece_size (size)
        VALUES ('$size');";
        // echo $sql;

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
                    سایز به درستی اضافه شد!
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_size';
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
                    خطایی در افزودن سایز پیش آمده!
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



if(isset($_POST['delete_size']) ){
    $id_size = $_POST['id_size'];
    
    $sql = "DELETE FROM piece_size WHERE id = $id_size";

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
                    سایز حذف شد!
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_size';
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
                    خطایی در حذف پیش آمده!
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