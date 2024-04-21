<?php
include 'config.php';

if (isset($_GET['name'])) {
    $selectedDeviceName = $_GET['name'];

    // Perform a database query to fetch device numbers associated with the selected device name
    $sql = "SELECT id, numbers FROM devices WHERE name = '$selectedDeviceName' ORDER BY numbers";

    $result = $conn->query($sql);

    // Output the results as JSON
    $deviceNumbers = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $deviceNumbers[] = array(
                'id' => $row['id'],
                'numbers' => $row['numbers']
            );
        }
    }
    echo json_encode($deviceNumbers);
} else {
    echo json_encode(array('error' => 'No device name provided'));
}
?>
