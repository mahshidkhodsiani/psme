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
                <?php
                if (isset($_GET['id_dev'])) {
                    $id_dev = $_GET['id_dev'];

                    $sql = "SELECT * FROM devices WHERE id = $id_dev";

                    // echo $sql;
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    // var_dump($row);

                ?>
                <form id="newPieceForm" action="" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">نام دستگاه</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?=$row['name']?>" >
                        </div>
                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">کد دستگاه</label>
                            <input type="text" name="size" id="size" class="form-control" value="<?=$row['numbers']?>" >
                            <input type="hidden" name="id_dev" id="id_dev" value="<?=$row['id']?>" >
                        </div>
                    </div>
                 
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button name="update" class="btn btn-outline-primary">ثبت</button>
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

    $id_dev = $_POST['id_dev'];

    $name = $_POST['name'];
    $size = $_POST['size'];

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

            $sql = "UPDATE devices SET name = '$name', numbers = '$size' WHERE id = $id_dev";

   
    
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
                            دستگاه با موفقیت بروزرسانی شد!
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
