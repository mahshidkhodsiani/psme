<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}

$id_from = $_SESSION["all_data"]['id'];




?>




<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تایید محصولات</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include 'config.php';
    include 'functions.php';
    ?>


    <link rel="stylesheet" href="style.css">

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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم تایید محصولات :</h3>
                
          
                    




                <br>



                <!-- when admin reject a personel -->
                <div class="card m-2"  id="reason_reject">
                    <div class="card-body">
                        

                        <?php
                        if(isset($_POST['reject_product'])) {
                            $id = $_POST['id_pro']; 
                            $to_user = $_POST['to_user']; 
                            ?>

                        

                            <h5 class="card-title">علت عدم تایید محصول را بنویسید</h5>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-6 p-2 ">
                                
                                    <input type="hidden" value="<?= $id ?>" name="id_pro2">
                                    <input type="hidden" value="<?= $to_user ?>" name="to_user2">



                                    <textarea name="text_reason" class="form-control" ></textarea>
                                        
                                        
                                    </div>
                                    <div class="col-md-4 d-flex">
                                        <button name="send_message" class="btn btn-outline-warning" onclick="return confirmDelete()">ارسال برای پرسنل</button>
                                        <br>
                                        <button name="inform_message" class="btn btn-outline-info" onclick="return confirmDelete()">به پرسنل اطلاع می دهم</button>
                                    </div>

                                </div>
                            </form>


                        <?php
                        }
                        ?>
                        
                        

                    </div>
                </div>
                <!-- when admin reject a personel -->



 

              
             
                
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th scope="col">ردیف</th>
                                <th scope="col">نام شخص</th>
                                <th scope="col">شیفت</th>
                                <th scope="col">دستگاه</th>
                                <th scope="col">کد دستگاه</th>
                                <th scope="col">قطعه</th>
                                <th scope="col">سایز قطعه</th>
                                <th scope="col">تعداد</th>
                                <th scope="col">توقف</th>
                                <th scope="col">تاریخ</th>
                                <th scope="col">تایید یا رد</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Pagination
                            $results_per_page = 10; // Number of records per page
                            if (!isset($_GET['page'])) {
                                $page = 1; // Default page
                            } else {
                                $page = $_GET['page'];
                            }
                            $start_from = ($page - 1) * $results_per_page;

                            // Fetch records with filters
                            $sql = "SELECT * FROM products WHERE status = 0 AND user_confirm = 1";

                            // Add LIMIT clause for pagination
                            $sql .= " ORDER BY id DESC LIMIT $start_from, $results_per_page";

                            // echo $sql;

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $a = $start_from + 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <!-- Table rows -->
                                    <tr>
                                        <th scope="row"><?= $a ?></th>
                                        <td><a href="product.php?id_pro=<?= $row['id'] ?>" style="text-decoration: none; color: black"><?= givePerson($row['user']) ?></a></td>
                                        <td>
                                            <?php
                                            if ($row['shift'] == 1) {
                                                echo 'روز';
                                            }
                                            if ($row['shift'] == 2) {
                                                echo 'عصر';
                                            }
                                            if ($row['shift'] == 3) {
                                                echo 'شب';
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['device_name']) ?></td>
                                        <td><?= htmlspecialchars($row['device_number']) ?></td>
                                        <td><?= htmlspecialchars($row['piece_name']) ?></td>
                                        <?php
                                        $nameData = giveName($row['size']);
                                        if (!empty($nameData) && is_array($nameData)) {
                                            echo '<td class="">' . htmlspecialchars($nameData['size']) . '</td>';
                                        } else {
                                            // Handle the case where giveName returns an empty array or non-array
                                            echo '<td class="">کاربر خالی وارد کرده</td>';
                                        }
                                        ?>
                                        <td><?= htmlspecialchars($row['numbers']) ?></td>
                                        <td>
                                            <?php
                                            if ($row['had_stop'] == 1) {
                                                echo 'داشته';
                                            } else {
                                                echo 'نداشته';
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['date']) ?></td>
                                        <td>
                                            <?php if ($row['status'] == 0) { ?>
                                                <form action="" method="POST">
                                                    <input type="hidden" value="<?= htmlspecialchars($row['id']) ?>" name="id_pro">
                                                    <input type="hidden" value="<?= htmlspecialchars($row['user']) ?>" name="to_user">
                                                    <button name="accept_product" class="btn btn-outline-success btn-sm" onclick="return confirmAccept()">تایید</button>
                                                    <button  name="reject_product" class="btn btn-outline-danger btn-sm" >رد</button>
                                                </form>
                                            <?php } elseif ($row['status'] == 1) {
                                                echo "تایید شده";
                                            } elseif ($row['status'] == 2) {
                                                echo "رد شده";
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $a++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <script>
                        function confirmDelete() {
                            return confirm("آیا مطمئن هستید که می‌خواهید این مورد را رد کنید؟");
                        }
                        function confirmAccept() {
                            return confirm("آیا مطمئن هستید که می‌خواهید این مورد را تایید کنید؟");
                        }
                    </script>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">قبلی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>';
                        }

                        // Page numbers
                        $sql = "SELECT COUNT(*) AS total FROM products WHERE status = 0";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_pages = ceil($row["total"] / $results_per_page);

                        // Define how many page numbers to display directly
                        $direct_page_numbers = 3;
                        $start_page = max(1, $page - floor($direct_page_numbers / 2));
                        $end_page = min($total_pages, $start_page + $direct_page_numbers - 1);

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">بعدی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">بعدی</a></li>';
                        }
                        ?>
                    </ul>
                </nav>







                <br>

                
                <div class="row mt-4">
                   

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">آخرین فعالیت ها  </h5>
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">اسم قطعه</th>
                                            <th scope="col">اسم شخص</th>
                                            <th scope="col">وضعیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM products WHERE user_confirm = 1
                                        ORDER BY id DESC LIMIT 10";
                                        $result = $conn->query($sql);
                                        $a = 1; // Initialize $a

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?= $a ?></th>
                                                    <td><?= htmlspecialchars($row['piece_name']) ?></td>
                                                    <td>
                                                        <a href="product.php?id_pro=<?= $row['id'] ?>" style="text-decoration: none; color: black"><?= htmlspecialchars(givePerson($row['user'])) ?></a>
                                                    </td>
                                                    <td style="
                                                    <?php
                                                        if ($row['status'] == 0) {
                                                            echo 'background-color: yellow;';
                                                        } elseif ($row['status'] == 1) {
                                                            echo 'background-color: green; color: white;';
                                                        } else {
                                                            echo 'background-color: red; color: white;';
                                                        }
                                                    ?>
                                                    ">
                                                        <?php
                                                        if ($row['status'] == 0) {
                                                            echo "هنوز تایید نشده";
                                                        } elseif ($row['status'] == 1) {
                                                            echo "تایید کردید";
                                                        } else {
                                                            echo "ردکردید";
                                                        }
                                                        ?>
                                                    </td>
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
if(isset($_POST['accept_product'])){

    $id = $_POST['id_pro']; 
    $sql = "UPDATE products SET status = 1 WHERE id = $id";
    $result = $conn->query($sql);

    if($result){

        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
        <div class='toast-header bg-success text-white'>
            <strong class='mr-auto'>Success</strong>
            <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>
            <div class='toast-body'>
                این محصول تایید شد!
            </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#successToast').toast('show');
            setTimeout(function(){
                $('#successToast').toast('hide');
                // Redirect after 3 seconds
                setTimeout(function(){
                    window.location.href = 'confirmations';
                }, 1000);
            }, 1000);
        });
        </script>";
          
    }
}



if(isset($_POST['text_reason'], $_POST['send_message'])){

    $id = $_POST['id_pro2']; 
    $person = $_POST['to_user2'];
    $message =  $_POST['text_reason'];

    $sql = "UPDATE products SET status = 2 WHERE id = $id";
    $result = $conn->query($sql);

    $date = mds_date("Y/m/d", "now", 1);

    if($result){

        $sql2 = "INSERT INTO messages (text, to_user, from_user, date, rejected)
                VALUES ('$message', '$person', '$id_from', '$date', 1)"; ;
                 $result2 = $conn->query($sql2);
                 if($result){

                    echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                    <div class='toast-header bg-success text-white'>
                        <strong class='mr-auto'>Success</strong>
                        <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>
                        <div class='toast-body'>
                            پیام به درستی ارسال شد!
                        </div>
                    </div>
                    <script>
                    $(document).ready(function(){
                        $('#successToast').toast('show');
                        setTimeout(function(){
                            $('#successToast').toast('hide');
                            // Redirect after 3 seconds
                            setTimeout(function(){
                                window.location.href = 'confirmations';
                            }, 1000);
                        }, 1000);
                    });
                    </script>";
                      
                }

      
          
    }
}


if(isset($_POST['inform_message'])){

    $id = $_POST['id_pro2']; 
    $person = $_POST['to_user2']; 
    $sql = "UPDATE products SET status = 2 WHERE id = $id";
    $result = $conn->query($sql);

    if($result){

      echo "<meta http-equiv='refresh' content='0'>";
          
    }
}