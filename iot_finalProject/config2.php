<?php
// Set up database connection
$servername = "localhost"; 
$username = "root"; 
$password = "ayobalima"; 
$dbname = "iot_final"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>