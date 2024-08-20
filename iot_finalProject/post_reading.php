<?php

include "config2.php";

// Get the HTTP POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData);

// Check if the device exists in the Devices table
$device_id = $data->device_id;
$device_name = $data->device_name;

// Update the device name based on its ID
$update_device_query = "UPDATE Devices SET device_name = '$device_name' WHERE device_id = $device_id";

if ($conn->query($update_device_query) === TRUE) {
    echo "Device name updated successfully. ";
} else {
    echo "Error updating device name: " . $conn->error;
}

// Proceed to post readings
$timestamp = date('Y-m-d H:i:s');
$temperature = $data->temperature;
$humidity = $data->humidity;
$light_intensity = $data->light_intensity;

// Insert readings into the database
$sql = "INSERT INTO Readings (device_id, timestamp, temperature, humidity, light_intensity) 
        VALUES ('$device_id', '$timestamp', '$temperature', '$humidity', '$light_intensity')";

if ($conn->query($sql) === TRUE) {
    echo "Readings posted successfully";
} else {
    echo "Error posting readings: " . $conn->error;
}

$conn->close();
?>
