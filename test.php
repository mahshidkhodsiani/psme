<?php


include 'config.php';

$sql = 'SELECT * from products WHERE id = 82 ';

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<pre>";
    var_dump($row);
}