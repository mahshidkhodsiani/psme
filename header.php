
<header class="navbar sticky-top flex-md-nowrap p-0 shadow " style="background-color: #3e3838;">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 d-flex align-items-center" href="./">
    <img src="img/logo.png" height="50px" class="me-2">
    <h3 style="color: white;" class="mb-0">شرکت پایا صنعت مانا</h3>
  </a>

  
    <!-- <div>
        <h3 style="color: white;">شرکت پایا صنعت مانا</h3>
    </div> -->


    <!-- <button class="navbar-toggler position-absolute d-md-none " 
            type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" 
            aria-controls="sidebarMenu" 
            aria-expanded="false" >
        <span class="navbar-toggler-icon"></span>
    </button> -->
        <?php
          // // require_once 'path/to/source/jdatetime.class.php';
          // require_once 'jDateTime-master/jdatetime.class.php';
          // // D:\project\xamp\htdocs\project2\jDateTime-master\jdatetime.class.php
          // // Make sure the jDateTime extension is loaded
          // // Use the following line to load the extension if it's not autoloaded:
          // // include 'jdatetime.class.php';

          // $currentDate = date("Y-m-d"); // Get current Gregorian date
          // list($year, $month, $day) = explode('-', $currentDate);
          // $jdate = new jDateTime(); // Create an instance of jDateTime
          // $currentPersianDate = $jdate->date("d-m-y l", mktime(0, 0, 0, $month, $day, $year)); // Get Persian date and the name of the day

          // echo  "<h5>امروز: " . $currentPersianDate . "  </h5>"  ;



          include 'PersianCalendar.php';
          ?>
          
          <div style="display: flex; align-items: center; justify-content: space-between; color: white; padding: 10px;">
            <h6 style="margin-left: 20px;">امروز : <?php echo mds_date("l j F Y ", time(), 0); ?></h6>
            <a href="logout.php" >خروج</a>
          </div>
          
       

 
    
</header>