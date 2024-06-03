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
    <title>ویرایش قطعه</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php'; 
    include 'config.php';
    include 'jalaliDate.php';
    $sdate = new SDate();
    // include 'PersianCalendar.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ویرایش قطعه : </h3>
                <?php
                if (isset($_GET['id_piece'])) {
                    $id_piece = $_GET['id_piece'];

                    $sql = "SELECT * FROM pieces WHERE id = $id_piece";

                    // echo $sql;
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    // var_dump($row);

                ?>
                <form id="newPieceForm" action="" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">نام قطعه</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?=$row['name']?>">
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">سایز قطعه</label>
                            <input type="text" name="size" id="size" class="form-control" value="<?=$row['size']?>">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">قیمت قطعه(تومان)</label>
                            <input type="number" name="price" id="price" placeholder="به انگلیسی وارد کنید" class="form-control" value="<?=$row['price']?>">
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label fw-semibold">زمان لازم برای تولید</label>
                            <input type="text" name="time" id="time" class="form-control" value="<?=$row['time_one']?>">
                            <input type="hidden" name="id_piece" value="<?=$row['id']?>">
                        </div>
                    </div>
                 
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="update" class="btn btn-outline-primary">ثبت</button>
                            <a href="new_piece" class="btn btn-outline-danger">انصراف</a>

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
</body>
</html>


<?php

if (isset($_POST['update'])) {

    $id_piece = $_POST['id_piece'];

    $name = $_POST['name'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $time_one = $_POST['time'];

    // check for duplicates :
        $sql1 = "SELECT * FROM pieces WHERE name = '$name' AND size = '$size' AND price = '$price' AND time_one = '$time_one'"; 
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
                        این قطعه قبلا به ثبت رسیده لطفا دستگاه جدید وارد کنید !
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

            $sql = "UPDATE pieces SET name = '$name', size = '$size' , price = '$price', time_one = '$time_one' 
                WHERE id = $id_piece";

   
    
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
                            قطعه با موفقیت بروزرسانی شد!
                        </div>
                    </div>
                        <script>
                        $(document).ready(function(){
                            $('#successToast').toast('show');
                            setTimeout(function(){
                                $('#successToast').toast('hide');
                                // Redirect after 3 seconds
                                setTimeout(function(){
                                    window.location.href = 'new_piece';
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
                            خطایی در بروزرسانی پیش آمده!
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
