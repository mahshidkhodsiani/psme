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
    <?php include 'includes.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت کارکنان جدید : </h3>
                <form action="new_user.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                نام </label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="family" class="form-label fw-semibold">
                                نام خانوادگی</label>
                            <input type="text" name="family" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">
                                یوزرنیم </label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                پسورد</label>
                            <input type="password" name="password" class="form-control">
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
</body>
</html>


<?php

if(isset($_POST['enter'])){

    include 'config.php';

    // Sanitize user inputs to prevent SQL injection
    $name = $conn->real_escape_string($_POST['name']);
    $family = $conn->real_escape_string($_POST['family']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $date = date('Y-m-d H:i:s');

    // Construct the SQL query using placeholders
    $sql = "INSERT INTO users (name, family, username, password, date)
            VALUES ('$name', '$family', '$username', '$password', '$date')";

    // Execute the query
    $result = $conn->query($sql);

    if($result){
        echo "<h3>کاربر به درستی اضافه شد !</h3>" ;
    } else {
        echo "<h3>خطایی در افزودن کاربر پیش آمده!</h3>" ;
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
    
}
