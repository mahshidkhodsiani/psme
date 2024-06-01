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

                if(isset($_GET['msg_id'])){
                    $id_msg = $_GET['msg_id'];
                    $sql1 = "SELECT * FROM messages WHERE id=$id_msg";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0){
                        $row1 = $result1->fetch_assoc();
                    }

                    $sql2 = "SELECT * FROM messages_comments WHERE msg_id = $id_msg order by id";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()) {
                            $comments[] = $row2['msg']; 
                        }
                    }
                    
                }else{
                    echo "آیدی پیام به درستی پیدا نشد!";
                }
                ?>
              
            </div>


            <div class="col-md-8 col-sm-12">
                <h3 style="background-color: #fcb321;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت پیام جدید :</h3>

                <form action="new_message" method="POST" enctype="multipart/form-data" class="p-3 border mt-4">
                    

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <label>پیام اولیه  :</label>
                        <br>
                        <br>
                        <textarea class="form-control" name="new_text" rows="3" readonly><?=$row1['text'] ?></textarea>
                
                        </div>
                        <br>

                        <div class="col-md-6">
                            <label for="">ارسال پاسخ : </label>
                            <textarea class="form-control" name="comment1" rows="3" required></textarea>

                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary" name="enter">ثبت</button>
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
