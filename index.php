<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خانه</title>
    <?php
    include 'includes.php';
    include 'config.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex">
                <?php
                include 'sidebar.php';
                ?>
                <!-- <button class="btn btn-primary bg-primary" onclick="showSidebar()" style="height: 50px;">
                    |||
                </button> -->
            </div>

            <div class="col-md-8">
                <h3 style="background-color: #dbd50c;" class="d-flex justify-content-center mt-2 p-3">صفحه اول : </h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">آخرین محصولات شما </h5>
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">نام دستگاه</th>
                                            <th scope="col">کد دستگاه</th>
                                            <th scope="col">اسم محصول</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $a = 1;

                                        // Fetch records
                                        $sql = "SELECT * FROM products WHERE user = '$id'
                                                ORDER BY id DESC LIMIT 4";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $a++;
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?= $a ?></th>
                                                    <td><?= $row['device_name'] ?></td>
                                                    <td><?= $row['device_number'] ?></td>
                                                    <td><?= $row['piece_name'] ?></td>
                                                </tr>
                                        <?php
                                                $a++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">آخرین پیام ها </h5>
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">پیام</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $a = 1;

                                        // Fetch records
                                        $sql = "SELECT * FROM messages ";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            $a++;
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?= $a ?></th>
                                                    <td><?= $row['text'] ?></td>
                                                </tr>
                                        <?php
                                                $a++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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

        // function showSidebar() {
        //     var sidebar = document.getElementById('sidebarMenu');
        //     if (sidebar.style.display === 'none' || sidebar.style.display === '') {
        //         sidebar.style.display = 'block'; // Show the sidebar
        //     } else {
        //         console.log('close');
        //         // sidebar.style.display = 'none'; // Hide the sidebar
        //         sidebar.setAttribute('style', 'display: none !important;')
        //     }
        // }
    </script>
</body>

</html>