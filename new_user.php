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
    <title>افزودن کاربر جدید</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php'; 
    include 'config.php';
    include 'jalaliDate.php';
    $sdate = new SDate();
    // include 'PersianCalendar.php';
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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت کارکنان جدید : </h3>
                <form action="new_user.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                نام
                            </label>
                            <input type="text" name="name" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="family" class="form-label fw-semibold">
                                نام خانوادگی
                            </label>
                            <input type="text" name="family" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                   
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                یوزرنیم
                            </label>
                            <input type="text" name="username" class="form-control" required autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                پسوورد(عدد)
                            </label>
                            <input type="number" name="password" class="form-control" required autocomplete="off">
                        </div>
                    </div>

                    <div class="row mt-2">
                        
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="isAdmin" name="isAdmin">
                                <label class="form-check-label" for="isAdmin" >
                                    ادمین
                                </label>
                            </div>
                        </div>
                        <div class="col-md-10">
                            
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="enter" class="btn btn-outline-primary">ثبت</button>
                        </div>
                    </div>
                </form>


                <script>
                    document.getElementById('userForm').addEventListener('submit', function(event) {
                        // Prevent the form from actually submitting for demonstration purposes
                        event.preventDefault();
                        
                        // Perform the actual form submission here (e.g., using AJAX)

                        // Clear the form fields
                        document.getElementById('userForm').reset();
                    });
                </script>

                <div class="row mt-4">
                    <div class="col-md-10">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10; // Number of items per page
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                        // Calculate the offset for the SQL query
                        $offset = ($current_page - 1) * $items_per_page;

                        // SQL query to retrieve a subset of rows based on pagination
                        $sql = "SELECT * FROM users ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        // Display the table
                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                            ?>
                            <div class="table-responsive">
                                <table class="table border border-4">
                                    <h4>نگاه کلی :</h4>
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ردیف</th>
                                            <th scope="col" class="text-center">نام</th>
                                            <th scope="col" class="text-center">نام خانوادگی</th>
                                            <th scope="col" class="text-center">تاریخ ثبت نام</th>
                                            <th scope="col" class="text-center">وضعیت</th>
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
                                                <td class="text-center"><?= $row['family'] ?></td>
                                                <td class="text-center"><?= $sdate->toShaDate($row['date']) ?></td>
                                                <td class="text-center">
                                                    <?= $row['status'] == 1 ? 'فعال' : 'غیرفعال' ?>
                                                </td>
                                                <td class="text-center">
                                                    <form action="" method="GET">
                                                        <input type="hidden" value="<?= $row['id'] ?>" name="id_user">
                                                        <a href="edit_user.php?id_user=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm"> ویرایش</a>
                                                        <?php if ($row['status'] == 1) { ?>
                                                            <button name="deactive_user" class="btn btn-outline-secondary btn-sm" onclick="return confirmInActive()">غیرفعال کردن</button>
                                                        <?php } else { ?>
                                                            <button name="active_user" class="btn btn-outline-secondary btn-sm" onclick="return confirmActive()">فعال کردن</button>
                                                        <?php } ?>
                                                        <button name="delete_user" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">حذف</button>
                                                    </form>
                                                </td>
                                                <script>
                                                    function confirmDelete() {
                                                        return confirm("آیا مطمئن هستید که می‌خواهید این یوزر را حذف کنید؟");
                                                    }
                                                    function confirmActive() {
                                                        return confirm("آیا مطمئن هستید که می‌خواهید این یوزر را فعال کنید؟");
                                                    }
                                                    function confirmInActive() {
                                                        return confirm("آیا مطمئن هستید که می‌خواهید این یوزر را غیرفعال کنید؟");
                                                    }
                                                </script>


                                            </tr>
                                            <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php

                            // Pagination links
                            $sql = "SELECT COUNT(*) AS total FROM users";
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
                            echo "<p>No records found.</p>";
                        }
                        ?>

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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
    <script>
        $(document).ready(function() {
            // Regular expression to match English alphabet
            const englishRegex = /^[A-Za-z\s]+$/;

            // Function to validate input
            function validateInput(input) {
                const value = input.value;
                if (!englishRegex.test(value)) {
                    input.setCustomValidity("Please use only English letters.");
                } else {
                    input.setCustomValidity("");
                }
            }

            // Attach input event listeners for validation
            $('input[name="username"]').on('input', function() {
                validateInput(this);
            });

            // Prevent paste event if the content is not in English
            $('input[name="username"]').on('paste', function(e) {
                const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
                const pastedData = clipboardData.getData('text');
                if (!englishRegex.test(pastedData)) {
                    e.preventDefault();
                }
            });

            // Prevent non-English characters from being entered
            $('input[name="username"]').on('keypress', function(e) {
                const key = String.fromCharCode(e.which);
                if (!englishRegex.test(key)) {
                    e.preventDefault();
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function() {
            // Regular expression to match Persian alphabet
            const persianRegex = /^[\u0600-\u06FF\s]+$/;

            // Function to validate input
            function validateInput(input) {
                const value = input.value;
                if (!persianRegex.test(value)) {
                    input.setCustomValidity("لطفاً فقط از حروف فارسی استفاده کنید.");
                } else {
                    input.setCustomValidity("");
                }
            }

            // Attach input event listeners for validation
            $('input[name="name"], input[name="family"]').on('input', function() {
                validateInput(this);
            });

            // Prevent paste event if the content is not in Persian
            $('input[name="name"], input[name="family"]').on('paste', function(e) {
                const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
                const pastedData = clipboardData.getData('text');
                if (!persianRegex.test(pastedData)) {
                    e.preventDefault();
                }
            });

            // Prevent non-Persian characters from being entered
            $('input[name="name"], input[name="family"]').on('keypress', function(e) {
                const key = String.fromCharCode(e.which);
                if (!persianRegex.test(key)) {
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>


<?php

if(isset($_POST['enter'])){

    // die();
    $name = $_POST['name'];
    $family = $_POST['family'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(isset($_POST['isAdmin'])){
        $isAdmin = 1 ;
    }else{
        $isAdmin = 0 ;
    }

  


    $SQL1 = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result1 = $conn->query($SQL1);
    if ($result1->num_rows > 0) {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    این یوزرنیم و پسورد قبلا به ثبت رسیده! !
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
       $sql = "INSERT INTO users (name, family, username, password, admin, date) 
            VALUES ('$name', '$family', '$username', '$password', '$isAdmin', NOW())";
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
                        یوزر با موفقیت اضافه شد!
                    </div>
                  </div>
                    <script>
                    $(document).ready(function(){
                        $('#successToast').toast('show');
                        setTimeout(function(){
                            $('#successToast').toast('hide');
                            // Redirect after 3 seconds
                            setTimeout(function(){
                                window.location.href = 'new_user';
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
                        خطایی در افزودن یوزر پیش آمده!
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

    
    
}




if(isset($_GET['delete_user'])){

    $id_user = $_GET['id_user'];

    $sql = "DELETE FROM users WHERE id = $id_user";
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
                    یوزر با موفقیت حذف شد!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_user';
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
                    خطایی در حذف یوزر پیش آمده!
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


if(isset($_GET['deactive_user'])){

    $id_user = $_GET['id_user'];

    $sql = "UPDATE users set status = 0 WHERE id = $id_user";
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
                    یوزر با موفقیت غیرفعال گردید!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_user';
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
                    خطایی در بروزرسانی یوزر پیش آمده!
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


if(isset($_GET['active_user'])){

    $id_user = $_GET['id_user'];

    $sql = "UPDATE users set status = 1 WHERE id = $id_user";
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
                    یوزر با موفقیت فعال گردید!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_user';
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
                    خطایی در بروزرسانی یوزر پیش آمده!
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
