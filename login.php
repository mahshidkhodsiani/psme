<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>




   <?php
      include 'includes.php';
   ?>

      
      <link rel="stylesheet" href="styles.css">
      <script src="javascripts.js"></script>

</head>


<body>
    <div class="container">
        <div class="row">
			<div class="col-md-5 mx-auto">
			<div id="first">
				<div class="myform form ">
					 <div class="logo mb-3">
						 <div class="col-md-12 text-center">
							<h1>Login</h1>
						 </div>
					</div>
                  <form action="login_proccess.php" method="post">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="username" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
                     </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                     </div>
                     
                     <br>
                     <div class="col-md-12 text-center ">
                        <button type="submit" name="enter"
                           class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                     </div>
                     <div class="col-md-12 ">
                        <div class="login-or">
                           <hr class="hr-or">
                           
                        </div>
                     </div>
                          
                  </form>
                 
				</div>
			</div>
			
		</div>
      </div>   
         
</body>
</html>


