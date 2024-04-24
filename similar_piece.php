<?php
include 'config.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    $sql = "SELECT DISTINCT name FROM devices WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchName = '%' . $_POST['name'] . '%';
    $stmt->bind_param("s", $searchName);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output the results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>" . $row["name"] . "</div>";
            // You can display more details if needed
        }
    } else {
        echo "چنین دستگاهی یافت نشد.";
    }


} elseif (isset($_POST['size'])) {
    $size = $_POST['size'];

    // Perform a database query to find similar entries based on the entered size
    $sql = "SELECT DISTINCT numbers FROM devices WHERE numbers LIKE '%$size%'";
    $result = $conn->query($sql);

    // Output the results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>" . $row["numbers"] . "</div>";
            // You can display more details if needed
        }
    } else {
        echo "چنین دستگاهی یافت نشد.";
    }
}