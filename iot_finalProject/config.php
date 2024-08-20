<?php
// Database configuration
$host = 'localhost'; // or your host
$dbname = 'iot_finalProject';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
