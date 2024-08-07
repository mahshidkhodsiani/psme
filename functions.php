<?php

function givePerson($id)
{
    include 'config.php';
    $sql = "SELECT * FROM users WHERE id = $id";
    // echo $sql;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['deleted']==0)
            return $row['name'] . " " . $row['family'];
        else
            return $row['name'] . " " . $row['family'] ."(کاربر حذف شده)";
    } else {
        // Handle the case where no rows are found
        return "No user found";
    }
}



function giveDeviceCode($id)
{
    include 'config.php';
    
    // Check if $id is not empty
    if(!empty($id)) {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT * FROM devices WHERE id = '$id'";

        // echo $sql;
     
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['numbers'];
        } else {
            return 'کاربر خالی وارد کرده';
        }
    } else {
        return 'کاربر خالی وارد کرده';
    }
}




function giveName($id)
{
    include 'config.php';
    
    // Check if $id is not empty
    if (!empty($id)) {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT * FROM piece_size WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id); // Assuming id is an integer, change "i" if it's a different type
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row; // Return the whole row as an associative array
        } else {
            // Return an empty array if no row is found
            return [];
        }
    } else {
        // Return an empty array if $id is empty
        return [];
    }
}


function truncateText($text, $limit = 5) {
    $words = explode(' ', $text);
    if (count($words) > $limit) {
        $words = array_slice($words, 0, $limit);
        return implode(' ', $words) . '...';
    }
    return $text;
}



function giveReasonReject($id){
    include 'config.php';

    $sql = "SELECT * FROM messages WHERE product = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['text'];
    }
}


function giveTimePiece($id){
    include 'config.php';

    $sql = "SELECT * FROM pieces WHERE id = $id";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['time_one'];
    }
}