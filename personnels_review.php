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
    <title>مدیریت محصولات تولید شده</title>
    <?php
    include 'includes.php';
    include 'config.php';
    include 'functions.php';
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
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">مدیریت پرسنل : </h3>
                
          
                    


                <div class="card m-2" >
                    <div class="card-body">
                        <h5 class="card-title">اعمال فیلتر</h5>
                        
                        <form method="GET" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">وضعیت:</label>
                                    <select class="form-select" name="status">
                                        <option value="">همه</option>
                                        <option value="0" <?php if(isset($_GET['status']) && $_GET['status'] === '0') echo 'selected'; ?>>تایید نشده</option>
                                        <option value="1" <?php if(isset($_GET['status']) && $_GET['status'] === '1') echo 'selected'; ?>>تایید شده</option>
                                        <option value="2" <?php if(isset($_GET['status']) && $_GET['status'] === '2') echo 'selected'; ?>>رد شده</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">پرسنل:</label>
                                    <select class="form-select" name="personel">
                                    <option value="">همه</option>
                                    <?php
                                        $sql = "SELECT * FROM users";
                                        $result = $conn ->query($sql);
                                        if($result->num_rows >0){
                                            while($row = $result-> fetch_assoc()){?>

                                                <option value="<?=$row['id']?>" <?php if(isset($_GET['personel']) && $_GET['personel'] === $row['id']) echo 'selected'; ?>>
                                                    <?=$row['name']. " " .$row['family']?>
                                                </option>
                                        <?php
                                            }
                                        }
                                    ?>

                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">اعمال فیلترها</button>
                        </form>
                    </div>
                </div>


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



                                    <textarea name="text_reason" class="form-control"></textarea>
                                        
                                        
                                    </div>
                                    <div class="col-md-4 d-flex">
                                        <button name="send_message" class="btn btn-outline-warning">ارسال برای پرسنل</button>
                                        <br>
                                        <button name="inform_message" class="btn btn-outline-info">به پرسنل اطلاع می دهم</button>
                                    </div>

                                </div>
                            </form>


                        <?php
                        }
                        ?>
                        
                        

                    </div>
                </div>
                <!-- when admin reject a personel -->



 

              
             
                
                
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">نام شخص</th>
                            <th scope="col">شیفت</th>
                            <th scope="col">نام دستگاه</th>
                            <th scope="col">کد دستگاه</th>
                            <th scope="col">اسم محصول</th>
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
                        $sql = "SELECT * FROM products";

                        // Add WHERE clause based on filter values
                        if(isset($_GET['status']) && $_GET['status'] !== '' && $_GET['personel'] === '') {
                            $status = $_GET['status'];
                            $sql .= " WHERE status = $status";
                        }

                        if(isset($_GET['personel']) && $_GET['personel'] !== '' && $_GET['status'] === '') {
                            $personel = $_GET['personel'];
                            $sql .= " WHERE `user` = $personel ";
                        }

                        if(isset($_GET['personel'], $_GET['status']) && $_GET['personel'] !== '' && $_GET['status'] !== ''){
                            $personel = $_GET['personel'];
                            $status = $_GET['status'];
                            $sql .= " WHERE status = $status AND user= $personel";
                        }

                        // Add LIMIT clause for pagination
                        $sql .= " LIMIT $start_from, $results_per_page";

                        echo $sql;
                        
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = $start_from + 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <!-- Table rows -->
                                <tr>
                                    <th scope="row"><?= $a ?></th>
                                    <td><?= givePerson($row['user']) ?></td>
                                    <td>
                                        <?php

                                        ?>
                                    </td>
                                    <td><?= $row['device_name'] ?></td>
                                    <td><?= $row['device_number'] ?></td>
                                    <td><?= $row['piece_name'] ?></td>
                                    <td>
                                        <?php if($row['status'] == 0) { ?>
                                            <form action="" method="POST">
                                                <input type="hidden" value="<?=$row['id'] ?>" name="id_pro">
                                                <input type="hidden" value="<?=$row['user'] ?>" name="to_user">
                                                <button name="accept_product" class="btn btn-outline-success btn-sm">تایید</button>
                                                <!-- Change the type of the button to "button" -->
                                                <button name="reject_product"  id="reject_button"
                                                     class="btn btn-outline-danger btn-sm">رد</button>
                                            </form>
                                        <?php } elseif($row['status'] == 1) {
                                            echo "تایید شده";
                                        } elseif($row['status'] == 2) {
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



                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        // Previous page link
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1);
                            if(isset($_GET['status']) && $_GET['status'] !== '') {
                                echo '&status=' . $_GET['status'];
                            }
                            echo '">قبلی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">قبلی</a></li>';
                        }

                        // Page numbers
                        $sql = "SELECT COUNT(*) AS total FROM products";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_pages = ceil($row["total"] / $results_per_page);

                        // Define how many page numbers to display directly
                        $direct_page_numbers = 3;
                        $start_page = max(1, $page - floor($direct_page_numbers / 2));
                        $end_page = min($total_pages, $start_page + $direct_page_numbers - 1);

                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><a class="page-link" href="?page=' . $i;
                                if(isset($_GET['status']) && $_GET['status'] !== '') {
                                    echo '&status=' . $_GET['status'];
                                }
                                
                                echo '">' . $i . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i;
                                if(isset($_GET['status']) && $_GET['status'] !== '') {
                                    echo '&status=' . $_GET['status'];
                                }
                                echo '">' . $i . '</a></li>';
                            }
                        }

                        // Next page link
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1);
                            if(isset($_GET['status']) && $_GET['status'] !== '') {
                                echo '&status=' . $_GET['status'];
                            }
                            echo '">بعدی</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">بعدی</a></li>';
                        }
                        ?>
                    </ul>
                </nav>

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


    <!-- <script>
        // Function to show the "reason_reject" div
        function showReasonReject() {
            document.getElementById("reason_reject").style.display = "block";
        }
        
        // Event listener for the "رد" button
        document.getElementById("reject_button").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission behavior
            showReasonReject(); // Call the function to show the "reason_reject" div
        });
    </script> -->

   
</body>

</html>



<?php
if(isset($_POST['accept_product'])){

    $id = $_POST['id_pro']; 
    $sql = "UPDATE products SET status = 1 WHERE id = $id";
    $result = $conn->query($sql);

    if($result){

      echo "<meta http-equiv='refresh' content='0'>";
          
    }
}



if(isset($_POST['text_reason'], $_POST['send_message'])){

    $id = $_POST['id_pro2']; 
    $person = $_POST['to_user2'];
    $message =  $_POST['text_reason'];

    $sql = "UPDATE products SET status = 2 WHERE id = $id";
    $result = $conn->query($sql);

    if($result){

        $sql2 = "INSERT INTO messages (text, to_user)
                VALUES ('$message', '$person')" ;
                 $result2 = $conn->query($sql2);
                 if($result2){

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
                                }, 3000);
                            });
                        </script>";

                        $a = 1 ;
                    

                    
                 }

                 if($a == 1){
                    echo "<meta http-equiv='refresh' content='0'>";
                 }
                 

      
          
    }
}