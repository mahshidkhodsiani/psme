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
                <form action="new_piece.php" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">
                                نام قطعه </label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">
                                سایز</label>
                            <input type="text" name="size" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">
                                قیمت </label>
                            <input type="text" name="price" class="form-control" placeholder="تومان">
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


    $name = $conn->real_escape_string($_POST['name']);
    $size = $conn->real_escape_string($_POST['size']);
    $price = $conn->real_escape_string($_POST['price']);
    // Construct the SQL query using placeholders
    $sql = "INSERT INTO pieces (name, size, price)
            VALUES ('$name', '$size', '$price')";

    // Execute the query
    $result = $conn->query($sql);

    if($result){
        echo "<h3>قطعه به درستی اضافه شد !</h3>" ;
    } else {
        echo "<h3>خطایی در افزودن قطعه پیش آمده!</h3>" ;
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
    
}
