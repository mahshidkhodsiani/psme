<?php

include 'config.php';

$filename = "Webinfopen.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$user_query = $conn->query('SELECT * FROM users');

// Write data to file
$flag = false;
while ($row = $user_query->fetch_assoc()) {
    if (!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($row)) . "\r\n";
        $flag = true;
    }
    echo implode("\t", array_values($row)) . "\r\n";
}

$conn->close();
?>
