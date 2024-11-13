<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'mydb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
