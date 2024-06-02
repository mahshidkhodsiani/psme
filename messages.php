<?php
session_start();
if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit(); 
}

$id_from = $_SESSION["all_data"]["id"];
$admin = $_SESSION["all_data"]['admin'];

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن پیام جدید</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php';
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
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت پیام جدید :</h3>

                <form action="new_message" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    

                    <div class="row">
                        <div class="col-md-12">
                        <label>لطفا پیام را داخل کادر بنویسید :</label>
                        <br>
                        <br>
                        <textarea class="form-control" name="new_text" rows="3" required></textarea>
                
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-5">
                            <label>برای چه کسی ارسال شود</label>
                            <select class="form-control" name="to_user" required>

                                <option value="" selected>انتخاب کنید</option>
                                <?php
                                $sql = "SELECT * FROM users";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='". $row['id']. "'>". $row['name']." ". $row['family']. "</option>";
                                }
                               ?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary" name="enter">ثبت</button>
                        </div>
                    </div>
                   
                </form>







                <div class="row mt-4">
                   

                   <div class="col-md-12">
                       <div class="card">
                           <div class="card-body">
                               <h5 class="card-title">آخرین پیام ها </h5>
                               <table class="table border">
                                   <thead>
                                       <tr>
                                           <th scope="col">ردیف</th>
                                           <th scope="col">پیام</th>
                                           <th scope="col">فرستنده</th>
                                           <th scope="col">تاریخ</th>
                                           <th scope="col">دیدن پیام</th>


                                       </tr>
                                   </thead>
                                   <tbody>
                                       <?php

                                       $a = 0;

                                       if($admin == 1){
                                          $sql = "SELECT * FROM messages 
                                               ORDER BY id DESC LIMIT 10"; 
                                       }else{
                                            $sql = "SELECT * FROM messages WHERE to_user = '$id_from' OR from_user = '$id_from' 
                                               ORDER BY id DESC LIMIT 10";
                                       }
                                      
                                       
                                       $result = $conn->query($sql);

                                       if ($result->num_rows > 0) {
                                           $a++;
                                           while ($row = $result->fetch_assoc()) {
                                       ?>
                                               <tr>
                                                   <th scope="row"><?= $a ?></th>
                                                   <td> <?= $row['text']?></td>
                                                   <td><?= givePerson($row['from_user']) ?></td>
                                                   <td><?= $row['date'] ?></td>
                                                   <td>
                                                        <a href="messages_comments.php?msg_id=<?=$row['id']?>" class="btn btn-outline-dark">مشاهده</a>
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

if(isset($_POST['enter'])){

    include 'config.php';


    $text = $conn->real_escape_string($_POST['new_text']);
    $to_user = $conn->real_escape_string($_POST['to_user']);
    $date = mds_date("Y/m/d", "now", 1);

    // Construct the SQL query using placeholders
    $sql = "INSERT INTO messages (text, to_user, from_user, date)
            VALUES ('$text', '$to_user', '$id_from', '$date')";

    $result = $conn->query($sql);

    if($result){
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    پیام با موفقیت ثبت شد!
                </div>
              </div>
                <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        $('#successToast').toast('hide');
                        // Redirect after 3 seconds
                        setTimeout(function(){
                            window.location.href = 'new_message';
                        }, 1000);
                    }, 1000);
                });
                </script>";
    } else {
        echo "<h3 style='margin-right ; 100px'>خطایی در افزودن پیغام پیش آمده!</h3>" ;
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
    
}
