<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

header('Location: login.php'); // Replace with the actual login page URL
exit();
?>