<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link rel="icon" href="img/logo.png" type="image/x-icon">


   <link rel="stylesheet" href="style.css">

   <?php
      include 'includes.php';
   ?>

   <style>
      body {
         background-color: #35324ae8; /* Set body background color */
         margin: 0;
         padding: 0;
         font-family: Arial, sans-serif;
      }

      .col-md-5 {
         background-color: #ffffff; /* Set login form background color to white */
        
      }

   </style>

      
      <link rel="stylesheet" href="styles.css">
      <script src="javascripts.js"></script>

</head>


<body>
   <div class="container">
        <div class="row mt-2">
         
            <div class="col-md-5 mx-auto ">
                <div id="first" class="">
                    <div class="logo mb-3">
                        <div class="col-md-12 text-center mt-2">
                            <h1>Login</h1>
                        </div>
                    </div>
                    <br><br>

                    <form action="login_proccess.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="username" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                        </div>
                     
                        <br>  <br><br>
                        <div class="col-md-12 text-center">
                            <button type="submit" name="enter" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                        </div>
                        <div class="col-md-12 p-3">
                            <div class="login-or">
                                <!-- Content for login-or -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>   
</body>





</html>


