<?php
include 'config.php';

// Check if the piece name is provided
if (isset($_GET['piece_name'])) {
    // Retrieve the piece name from the GET parameters
    $pieceName = $_GET['piece_name'];
    
    // Prepare and execute SQL query to fetch sizes related to the selected piece name
    $sql = "SELECT id, size FROM pieces WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pieceName);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Store the sizes in an array
    $sizes = array();
    while ($row = $result->fetch_assoc()) {
        $sizes[] = $row;
    }
    
    // Return sizes as JSON
    echo json_encode($sizes);
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>
