<?php
session_start();
if(isset($_POST['enter'])){

   include 'config.php';
   include 'PersianCalendar.php';
   
   $username = $_POST['username'];
   $password = $_POST['password'];

   $sql = "SELECT * FROM  users WHERE username='$username' AND password='$password'";
   
   $result = $conn->query($sql);

   if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $_SESSION['all_data'] = $row;


      // Log the successful login attempt
      $user_id = $row['id'];
      $login_time = mds_date("Y/m/d");
      $ip_address = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];



      $sql_log = "INSERT INTO logs (timestamp, user_id, ip_address, events) 
                  VALUES ('$login_time', '$user_id', '$ip_address', 'login')";
      $conn->query($sql_log);


      header("Location: index.php");
      exit();
   }else {
      echo 'نام کاربری یا رمز عبور درست نیست';
      $_SESSION['login_error'] = 'نام کاربری یا رمز عبور اشتباه است. دوباره امتحان کنید.';
      // header("Location: login.php"); // Redirect back to the login page
      // exit();
   }
}
?>
