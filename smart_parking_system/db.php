<?php
$host = 'localhost';
$db = 'mydb';
$user = 'root'; // or your MySQL username
$pass = ''; // or your MySQL password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
