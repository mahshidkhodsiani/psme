<?php




function givePerson($id){

    include 'config.php';
    $sql = "SELECT * FROM users WHERE id = $id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    return $row['name']." ".$row['family'];
}


function giveDeviceCode($id){

    include 'config.php';
    $sql = "SELECT * FROM devices WHERE id = $id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    return $row['numbers'];
}


function giveName($id){

    include 'config.php';
    $sql = "SELECT * FROM pieces WHERE id = $id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    return $row['size'];
}