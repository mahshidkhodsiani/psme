<?php

include 'config.php';
// Assuming $conn is your database connection
if (isset($_GET['piece_name'])) {
    $pieceName = $_GET['piece_name'];
    // Fetch sizes from the database based on the selected piece name
    $sql = "SELECT size FROM pieces WHERE name = '$pieceName'";
    $result = $conn->query($sql);
    $sizes = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row['size'];
        }
    }
    // Return sizes as JSON
    echo json_encode($sizes);
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>
