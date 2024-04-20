<?php
session_start();
if(isset($_POST['enter'])){

   include 'config.php';
   
   $username = $_POST['username'];
   $password = $_POST['password'];

   $sql = "SELECT * FROM  users WHERE username='$username' AND password='$password'";
   
   $result = $conn->query($sql);

   if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $_SESSION['all_data'] = $row;
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
