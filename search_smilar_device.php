<?php

include 'config.php';

if (isset($_POST['device_name_id'])) {
    $device_name_id = '%' . $_POST['device_name_id'] . '%'; // Adjust how you sanitize user input as needed

    // Perform database query
    $sql = "SELECT id, numbers FROM devices WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $device_name_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare array to hold results
    $device_numbers = array();
    while ($row = $result->fetch_assoc()) {
        $device_numbers[] = array(
            'id' => $row['id'],
            'number' => $row['numbers'] // Ensure this matches the column name in your database
        );
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($device_numbers);
    exit;
} else {
    // Handle invalid request
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid request'));
    exit;
}
?>
