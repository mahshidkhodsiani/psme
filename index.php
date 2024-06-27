<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
$admin = $_SESSION["all_data"]['admin'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خانه</title>


    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include 'config.php';
    include 'functions.php';
    // include 'PersianCalendar.php';
    ?>
    <!-- <link rel="stylesheet" href="styles.css"> -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex">
                <?php
                include 'sidebar.php';
                ?>
                <!-- <button class="btn btn-primary bg-primary" onclick="showSidebar()" style="height: 50px;">
                    |||
                </button> -->
            </div>

            <div class="col-md-8">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">صفحه اول : </h3>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                        if($admin == 1){
                                            ?>
                                            <h5 class="card-title">آخرین محصولات (از دیروز )  </h5>
                                            <?php
                                        }else{
                                            ?>
                                            <h5 class="card-title">آخرین محصولات من (از دیروز) </h5>
                                        <?php
                                        }
                               
                                ?>
                                <div class="table-responsive">
                                    <table class="table border">
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="col">ردیف</th>
                                                <?php
                                                if ($admin == 1) {?>
                                                <th class="text-center" scope="col">نام شخص</th>
                                                <?php
                                                }
                                                ?>
                                                <th class="text-center" scope="col">نام دستگاه</th>
                                                <th class="text-center" scope="col">کد دستگاه</th>
                                                <th class="text-center" scope="col">اسم محصول</th>
                                                <th class="text-center" scope="col">سایز محصول</th>
                                                <th class="text-center" scope="col">تعداد</th>
                                                <th class="text-center" scope="col">تاریخ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $a = 0;

                                            if ($admin == 1) {
                                                $sql = "SELECT * FROM products
                                                        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                                                        ORDER BY id DESC LIMIT 10"; 
                                            } else {
                                                $sql = "SELECT * FROM products
                                                        WHERE user = '$id' AND created_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)
                                                        ORDER BY id DESC LIMIT 10";
                                            }
                                            

                                            
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $a++;
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <th scope="row"><?= $a ?></th>
                                                        <?php
                                                        if ($admin == 1) {
                                                        ?>
                                                            <td class="text-center" >
                                                                <a href="product.php?id_pro=<?= $row['id'] ?>" style="text-decoration: none; color: black"><?= givePerson($row['user']) ?></a>
                                                            </td>
                                                        <?php
                                                        }?>
                                                          
                                                        <td class="text-center">
                                                            <a href="product.php?id_pro=<?= $row['id'] ?>" style="text-decoration: none; color: black"><?= $row['device_name'] ?></a>
                                                        </td>
                                                     
                                                        <td class="text-center"><?= giveDeviceCode($row['device_number']) ?></td>
                                                      
                                                        <td class="text-center"><?= $row['piece_name'] ?></td>
                                                        <?php
                                                            $nameData = giveName($row['size']);
                                                            if (!empty($nameData) && is_array($nameData)) {
                                                                echo '<td class="text-center" class="text-center">' . $nameData['size'] . '</td>';
                                                            } else {
                                                                // Handle the case where giveName returns an empty array or non-array
                                                                echo '<td class="text-center" class="text-center">کاربر خالی وارد کرده</td>';
                                                            }
                                                        ?>
                                                        <td class="text-center"><?= $row['numbers'] ?></td>
                                                        <td class="text-center"><?= $row['date'] ?></td>
                                                    </tr>
                                            <?php
                                                    $a++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                
                            </div>
                        </div>
                    </div>

                 
                </div>


                <div class="row mt-4">
                   

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">آخرین پیام ها </h5>
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">پیام</th>
                                            <th scope="col">فرستنده</th>
                                            <th scope="col">وضعیت</th>
                                            <th scope="col">تاریخ</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $a = 0;

                                        if($admin == 1){
                                           $sql = "SELECT * FROM messages WHERE status = 0
                                                ORDER BY id DESC LIMIT 10"; 
                                        }else{
                                            $sql = "SELECT * FROM messages 
                                                WHERE (to_user = '$id' OR from_user = '$id') 
                                                AND status = 0
                                                ORDER BY id DESC 
                                                LIMIT 10";
                                        }
                                       
                                        
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $a++;
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?= $a ?></th>
                                                    <?php
                                                    if($admin == 1){
                                                        if($row['rejected'] == 0){?>
                                                            <td><a href="messages" style="text-decoration: none; color: black;"> <?= truncateText($row['text']) ?></a></td>
                                                
                                                    <?php
                                                        } else {?>
                                                            <td><a title="محصول رد شده" href="messages" style="text-decoration: none; color: red;"> <?= truncateText($row['text']) ?></a></td>

                                                    <?php
                                                        }
                                                    }else{
                                                        if($row['rejected'] == 0){?>
                                                    
                                                    <td><a href="new_message" style="text-decoration: none; color: black;"> <?= truncateText($row['text']) ?></a></td>
                                                    <?php
                                                        } else {?>
                                                    <td><a title="محصول رد شده" href="new_message" style="text-decoration: none; color: red;"> <?= truncateText($row['text']) ?></a></td>

                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                    <td><?= givePerson($row['from_user']) ?></td>
                                                    <td >
                                                        <?php
                                                            if($row['status']==0){?>
                                                                <img src="img/eye-close.jpg" height="20px" width="20px" title="توسط گیرنده دیده نشده">
                                                            <?php
                                                            }else{?>
                                                                <img src="img/eye-open.jpg" height="20px" width="20px" title="توسط گیرنده دیده شده" style="color: green;">
                                                            <?php

                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?= $row['date'] ?></td>
                                                </tr> 
                                        <?php
                                                $a++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <?php
                    if ($admin == 1) {
                    ?>


                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                             
                                <h5 class="card-title">آخرین کاربران اضافه شده  </h5>
              
                              
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">نام </th>
                                            <th scope="col">کد خانوادگی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $a = 0;

                                       
                                        $sql = "SELECT * FROM users WHERE deleted = 0
                                        ORDER BY id DESC LIMIT 10";
                                         

                                        
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $a++;
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?= $a ?></th>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $row['family'] ?></td>
                                                </tr>
                                        <?php
                                                $a++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                
                            </div>
                        </div>
                    </div>

                    <?php
                    }
                    ?>

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

        // function showSidebar() {
        //     var sidebar = document.getElementById('sidebarMenu');
        //     if (sidebar.style.display === 'none' || sidebar.style.display === '') {
        //         sidebar.style.display = 'block'; // Show the sidebar
        //     } else {
        //         console.log('close');
        //         // sidebar.style.display = 'none'; // Hide the sidebar
        //         sidebar.setAttribute('style', 'display: none !important;')
        //     }
        // }
    </script>
</body>

</html>