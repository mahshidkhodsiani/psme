<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}


$id = $_SESSION["all_data"]['id'];
$admin = $_SESSION["all_data"]['admin'];
// $show_table_for_user = 0;
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاهده محصول</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include 'config.php';
    include 'functions.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>






</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex ">
                <?php
                include 'sidebar.php';

                if (isset($_GET['id_pro'])) {
                    $id_pro = $_GET['id_pro'];
                    $sql = "SELECT * FROM products WHERE id = $id_pro";
                
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        // $shift = $row['shift'];
                    } else {
                        echo "No product found with id: $id_pro";
                    }
                } else {
                    echo "No product id provided.";
                }
                ?>

            </div>

            <div class="col-md-8">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم مشاهده محصول : </h3>
                <form action="submit_pro.php" method="POST" id="myForm" 
                    enctype="multipart/form-data" class="p-3 border mt-4">


                    <?php
                    if($admin == 1){?>

                    

                    <div class="row mt-3" >
                        <div class="col-md-6">
                            <h5 class="p-4 shadow"><?= givePerson($row['user'])?></h5>

                        </div>

                       
                    </div>

                    <?php
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="shift" class="form-label fw-semibold">
                                شیفت</label>
                            <input type="text" class="form-control" value="<?php 
                                if ($row['shift'] == 1) {
                                    echo 'روز';
                                } elseif ($row['shift'] == 2) {
                                    echo 'عصر';
                                } elseif ($row['shift'] == 3) {
                                    echo 'شب';
                                }
                            ?>" readonly>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <label for="shift" class="form-label fw-semibold">
                                نام دستگاه</label>
                            <input type="text" class="form-control" value="<?= $row['device_name']?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="shift" class="form-label fw-semibold">
                                کد دستگاه</label>
                            <input type="text" class="form-control" value="<?= giveDeviceCode($row['device_number'])?>" readonly>
                        </div>
                    </div>

                    


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="piece_name" class="form-label fw-semibold">نام قطعه</label>
                            <input type="text" name="piece_name" id="piece_name" class="form-control" value="<?= htmlspecialchars($row['piece_name'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="size" class="form-label fw-semibold">سایز قطعه</label>
                            <input type="text" name="size" id="size" class="form-control" value="<?= htmlspecialchars(giveName($row['size'])['size'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>
                    </div>


           
                 



                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="level" class="form-label fw-semibold">مرحله</label>
                            <input type="text" name="level" id="level" class="form-control" value="<?php
                                if ($row['level'] == 1) {
                                    echo 'یک';
                                } elseif ($row['level'] == 2) {
                                    echo 'دو';
                                } elseif ($row['level'] == 3) {
                                    echo 'سه';
                                }
                            ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="numbers" class="form-label fw-semibold">تعداد</label>
                            <input type="number" name="numbers" class="form-control" value="<?= htmlspecialchars($row['numbers'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>
                    </div>










                    <br>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="start" class="form-label fw-semibold">ساعت شروع تولید قطعه</label>
                            <input id="startTime" name="start" type="time" class="form-control input-md" value="<?= htmlspecialchars($row['start'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="stop" class="form-label fw-semibold">ساعت پایان تولید قطعه</label>
                            <input id="stopTime" name="stop" type="time" class="form-control input-md" value="<?= htmlspecialchars($row['stop'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                            <div id="error" style="color: red;"></div>
                        </div>
                    </div>


                    


              


                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="had_stop" class="form-label fw-semibold">توقف (دقیقه)</label>
                            <input type="text" name="had_stop" id="had_stop" class="form-control" value="<?php
                                if ($row['had_stop'] == 0) {
                                    echo 'نداشتم';
                                } elseif ($row['had_stop'] == 1) {
                                    echo 'داشتم';
                                }
                            ?>" readonly>
                        </div>
                    </div>

                    <?php if ($row['had_stop'] == 1): ?>
                    <div class="row mt-3" id="times_stop">
                        <div class="col-md-6">
                            <label for="couse_stop" class="form-label fw-semibold">علت توقف</label>
                            <input type="text" name="couse_stop" class="form-control" value="<?= htmlspecialchars($row['couse_stop'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>
                    </div>
                    <?php endif; ?>



                  






                    <div class="row mt-3" style="margin-bottom: 100px;">
                        <div class="col-md-6">
                            <label for="sub_date" class="form-label fw-semibold">تاریخ</label>
                            <input id="pdpDark" type="text" name="sub_date" class="form-control" value="<?= htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="extra_explanation" class="form-label fw-semibold">توضیحات اضافی</label>
                            <input type="text" name="extra_explanation" class="form-control" value="<?= htmlspecialchars($row['explanation'], ENT_QUOTES, 'UTF-8') ?>" readonly>
                        </div>
                    </div>



                    <?php
                    if($row['status'] == 2){?>

                    

                    <div class="row mt-3" >
                        <div class="col-md-6">
                            <h6 class="p-2" style="background-color: red;">علت رد کردن این محصول:</h6>
                            
                            <span style="background-color: red;"><?= giveReasonReject($row['id'])?></span>

                        </div>

                       
                    </div>

                    <?php
                    }elseif($row['status'] == 0){?>
                    <div class="row mt-3" >
                        <div class="col-md-6">
                            <h6 class="p-2" style="background-color: #fcb321;">در انتظار تایید</h6>
                        </div>

                       
                    </div>
                    <?php
                    }elseif($row['status'] == 1){?>
                    <div class="row mt-3" >
                        <div class="col-md-6">
                            <h6 class="p-2" style="background-color: green;">تایید شده</h6>
                        </div>

                        
                    </div>
                    <?php
                    }
                    ?>
                    



                   




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
