<?php
include 'config.php';

$input = $_POST['input'];
$type = $_POST['type'];

// Validate input and type (for security, optional but recommended)
if (!isset($input) || !isset($type)) {
    die("Invalid input");
}

// Query database for suggestions based on input and type
if ($type == 'name') {
    $sql = "SELECT name FROM devices WHERE name LIKE '%$input%' LIMIT 5";
} elseif ($type == 'numbers') {
    $sql = "SELECT numbers FROM devices WHERE numbers LIKE '%$input%' LIMIT 5";
} else {
    die("Invalid type");
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $value = htmlspecialchars($row[$type]); // Sanitize output
        echo "<div class='suggestion'>$value</div>"; // Output suggestions
    }
} else {
    echo "<div class='suggestion'>هیچ مشابهی پیدا نشد</div>"; // Handle no suggestions
}

$conn->close();
?>
