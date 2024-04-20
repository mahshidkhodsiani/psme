<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>




</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="./">
      <img src="img/logo.png" height="50px">

    </a>
  
    <!-- <div>
        <h3 style="color: white;">شرکت پایا صنعت مانا</h3>
    </div> -->


    <button class="navbar-toggler position-absolute d-md-none " 
            type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" 
            aria-controls="sidebarMenu" 
            aria-expanded="false" >
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="#">Sign out</a>
        </div>
    </div>
</header>


<div id="sidebarMenu"  class="d-flex flex-column 
        flex-shrink-0 p-3 text-white bg-dark collapse" 
    style="width: 280px;">
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        
        <li>
            <a href="submit_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro') echo 'active'; ?>">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            ثبت محصول
            </a>
        </li>
        <li>
            <a href="test.php" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'test.php') echo 'active'; ?>">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
            Orders
            </a>
        </li>
        <li>
            <a href="test2.php" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'test2.php') echo 'active'; ?>">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            Dashboard
            </a>
        </li>
    

        
    </ul>
</div>




<p>
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-bs-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
  </div>
</div>
    
</body>
</html>