<?php
if ($_SESSION["all_data"]['admin'] == 1) {
?>
    <div id="sidebarMenu" style="display : none !important; width: 300px !important" 
        class="d-flex flex-column flex-shrink-0 p-3 text-white border collapse">

        <h5 style="color: black;"><?= $_SESSION["all_data"]['name'] . " " . $_SESSION["all_data"]['family'] ?></h5>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto" style="padding-right: 10px;">

            <!-- <li>
                <a href="submit_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro') echo 'active'; ?>">
                    <img src="img/products.png" height="20px" width="20px">
                    ثبت محصول
                </a>
            </li> -->

            <li>
                <a class="nav-link  <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro' || basename($_SERVER['REQUEST_URI']) === 'products') echo 'active'; ?>" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#newProduct" aria-expanded="false">

                    <img src="img/point.png" height="20px" width="20px">
                    محصولات
                </a>
                <ul id="newProduct" class="collapse first-level" aria-expanded="false">
                    <li>
                        <a href="submit_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro') echo 'active'; ?>">
                            <!-- <img src="img/add-user.png" height="20px" width="20px"> -->

                            ثبت محصول
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="products" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'products') echo 'active'; ?>">
                            <!-- <img src="img/users.png" height="20px" width="20px"> -->
                            مدیریت محصولات
                        </a>
                    </li>
                </ul>
            </li>



            <li>
                <a class="nav-link  <?php if (basename($_SERVER['REQUEST_URI']) === 'new_user' || basename($_SERVER['REQUEST_URI']) === 'users') echo 'active'; ?>" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#newUser" aria-expanded="false">

                    <img src="img/point.png" height="20px" width="20px">
                    کاربران سیستم
                </a>
                <ul id="newUser" class="collapse first-level" aria-expanded="false">
                    <li>
                        <a href="new_user" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_user') echo 'active'; ?>">
                            <!-- <img src="img/add-user.png" height="20px" width="20px"> -->

                            افزودن کاربر
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="users" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'users') echo 'active'; ?>">
                            <!-- <img src="img/users.png" height="20px" width="20px"> -->
                            مدیریت کاربران
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_device' || basename($_SERVER['REQUEST_URI']) === 'devices') echo 'active'; ?>" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#newDevice" aria-expanded="false">

                    <img src="img/point.png" height="20px" width="20px">
                    دستگاه ها
                </a>
                <ul id="newDevice" class="collapse first-level" aria-expanded="false">
                    <li>
                        <a href="new_device" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_device') echo 'active'; ?>">


                            افزودن دستگاه جدید
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="devices" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'devices') echo 'active'; ?>">

                            مدیریت دستگاه ها
                        </a>
                    </li>
                </ul>
            </li>


            <li>
                <a class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_piece' || basename($_SERVER['REQUEST_URI']) === 'pieces') echo 'active'; ?>" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#newPiece" aria-expanded="false">

                    <img src="img/point.png" height="20px" width="20px">
                    قطعات
                </a>
                <ul id="newPiece" class="collapse first-level" aria-expanded="false">
                    <li>
                        <a href="new_piece" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_piece') echo 'active'; ?>">


                            افزودن قطعه جدید
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="pieces" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'pieces') echo 'active'; ?>">

                            مدیریت قطعات
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="new_message" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'new_message') echo 'active'; ?>">
                    <img src="img/message.png" height="20px" width="20px">
                    ارسال پیام
                </a>
            </li>

            <li>
                <a href="sum" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'sum') echo 'active'; ?>">
                    <img src="img/plus.png" height="20px" width="20px">
                    جمع مبالغ هر ماه
                </a>
            </li>





           


        </ul>
    </div>

<?php


} else {

?>

    <div id="sidebarMenu" style="display : none !important; width: 300px !important" 
        class="d-flex flex-column flex-shrink-0 p-3 text-white border collapse">

        <h5 style="color: black;"><?= $_SESSION["all_data"]['name'] . " " . $_SESSION["all_data"]['family'] ?></h5>
        <hr>

        <ul class="nav nav-pills flex-column mb-auto" style="padding-right: 10px;">
            <li>
                <a href="submit_pro" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'submit_pro') echo 'active'; ?>">
                    <img src="img/products.png" height="20px" width="20px">
                    ثبت محصول
                </a>
            </li>

            <li>
                <a href="sum" class="nav-link <?php if (basename($_SERVER['REQUEST_URI']) === 'sum') echo 'active'; ?>">
                    <img src="img/plus.png" height="20px" width="20px">
                    جمع مبالغ هر ماه
                </a>
            </li>
        </ul>
    </div>


<?php

}

?>