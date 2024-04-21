<?php
include 'config.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    // Perform a database query to find similar entries based on the entered name
    $sql = "SELECT DISTINCT name FROM devices WHERE name LIKE '%$name%'";
    $result = $conn->query($sql);

    // Output the results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>" . $row["name"] . "</div>";
            // You can display more details if needed
        }
    } else {
        echo "چنین قطعه ای یافت نشد.";
    }
} elseif (isset($_POST['size'])) {
    $size = $_POST['size'];

    // Perform a database query to find similar entries based on the entered size
    $sql = "SELECT DISTINCT numbers FROM devices WHERE size LIKE '%$size%'";
    $result = $conn->query($sql);

    // Output the results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>" . $row["size"] . "</div>";
            // You can display more details if needed
        }
    } else {
        echo "چنین قطعه ای یافت نشد.";
    }
} else {
    echo "Error: No name or size provided.";
}
