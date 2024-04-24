<style>
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
    }

    .sidebar {
        margin: 0;
        padding: 0;
        /* width: 200px; */
        background-color: #f1f1f1;
        position: fixed;
        height: 100%;
        overflow: auto;
        right: 0;
    }

    .sidebar a {
        display: block;
        color: black;
        padding: 16px;
        text-decoration: none;
    }

    .sidebar a.active {
        background-color: #1681f7;
        color: white;
    }

    .sidebar a:hover:not(.active) {
        background-color: #555;
        color: white;
    }

    div.content {
        margin-left: 200px;
        padding: 1px 16px;
        height: 1000px;
    }

    @media screen and (max-width: 700px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .sidebar a {
            float: left;
        }

        div.content {
            margin-left: 0;
        }
    }

    @media screen and (max-width: 400px) {
        .sidebar a {
            text-align: center;
            float: none;
        }
    }
</style>


<?php
if ($_SESSION["all_data"]['admin'] == 1) {
?>

<div class="sidebar">
<h4><?= $_SESSION['all_data']['name']. " ".$_SESSION['all_data']['family']?></h4>
    <a href="personnels_review" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'personnels_review') echo 'active'; ?>">
        <img src="img/review.png" height="20px" width="20px">
        بررسی سوابق کارکرد پرسنل
    </a>
    <a href="new_device" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_device') echo 'active'; ?>">
        <img src="img/add_pro.png" height="20px" width="20px">
        ثبت دستگاه جدید
    </a>
  
</div>


<?php


} else {

?>

<div class="sidebar">
    <h4><?= $_SESSION['all_data']['name']. " ".$_SESSION['all_data']['family']?></h4>
    <a href="submit_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro') echo 'active'; ?>">
        <img src="img/add_pro.png" height="20px" width="20px">
        ثبت محصول جدید
    </a>
   
</div>


<?php

}

?>
