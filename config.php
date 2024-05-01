<?php

// $servername = "217.144.104.114";
// $username = "kjbyasyr_admin";
// $password = "32pGVS2]}LI)";
// $dbname = "kjbyasyr_psm";

// $cfg['Lang'] = 'fa';
// $cfg['Charset'] = 'utf8mb4';


// $conn = mysqli_connect($servername, $username, $password, $dbname);


// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $conn->set_charset("utf8");



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}