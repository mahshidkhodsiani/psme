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
    <title>افزودن پیام جدید</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php';
        include 'config.php'; 
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
            <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">فرم ثبت پیام جدید :</h3>

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
                                $sql = "SELECT * FROM users WHERE admin = 1";
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

    // Construct the SQL query using placeholders
    $sql = "INSERT INTO messages (text, to_user)
            VALUES ('$text', '$to_user')";

    $result = $conn->query($sql);

    if($result){
        echo "<h3>پیغام به درستی ثبت شد !</h3>" ;
    } else {
        echo "<h3>خطایی در افزودن پیغام پیش آمده!</h3>" ;
        echo "Error: " . $sql . "<br>" . $conn->error; 
    }
    
}
