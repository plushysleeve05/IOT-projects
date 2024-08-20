<?php
require_once 'config2.php';
global $conn;

// Retrieve sensor readings from the database, along with device details
$sql = "SELECT r.*, d.device_name AS device_name, d.location AS device_location 
        FROM readings r 
        INNER JOIN devices d ON r.device_id = d.device_id";
$result = $conn->query($sql);

// Fetch data and convert it to associative array
$sensorData = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sensorData[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output sensor data as JSON
echo json_encode($sensorData);
?>
