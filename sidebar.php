<style>
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
        /* font-family: 'thahoma' ; */
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
<h5 class="p-4 shadow"><?= $_SESSION['all_data']['name']. " ".$_SESSION['all_data']['family']?></h5>
    <a href="index" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'index') echo 'active'; ?>">
        <img src="img/home.png" height="20px" width="20px">
        صفحه اول
    </a>
    <a href="personnels_review" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'personnels_review') echo 'active'; ?>">
        <img src="img/review.png" height="20px" width="20px">
        گزارش گیری
    </a>
    <a href="confirmations" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'confirmations') echo 'active'; ?>">
        <img src="img/confirm.png" height="20px" width="20px">
        تایید محصولات
    </a>
    <a href="new_device" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_device') echo 'active'; ?>">
        <img src="img/new_d.png" height="20px" width="20px">
        ثبت دستگاه جدید
    </a>
    <a href="new_piece" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_piece') echo 'active'; ?>">
        <img src="img/new_p.png" height="20px" width="20px">
        ثبت قطعه جدید
    </a>
    <a href="new_user" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_user') echo 'active'; ?>">
        <img src="img/new_u.png" height="20px" width="20px">
        ثبت یوزر جدید
    </a>
    <a href="messages" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'messages') echo 'active'; ?>">
        <img src="img/message.png" height="20px" width="20px">
        پیامها
    </a>
  
</div>


<?php


} else {

?>

<div class="sidebar">
    <h5 class="p-4 shadow"><?= $_SESSION['all_data']['name']. " ".$_SESSION['all_data']['family']?></h5>
    <a href="index" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'index') echo 'active'; ?>">
        <img src="img/home.png" height="20px" width="20px">
        صفحه اول
    </a>
    <a href="submit_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro') echo 'active'; ?>">
        <img src="img/add_pro.png" height="20px" width="20px">
        ثبت محصول جدید
    </a>

    <a href="new_message" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_message') echo 'active'; ?>">
        <img src="img/message.png" height="20px" width="20px">
        پیام برای ادمین
    </a>
    <a href="user_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'user_pro') echo 'active'; ?>">
        <img src="img/products.png" height="20px" width="20px">
        مرور محصولات اخیر من 
    </a>
   
</div>


<?php

}

?>
