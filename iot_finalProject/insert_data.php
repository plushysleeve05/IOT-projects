<?php

include "config.php"; // Include your database configuration file

// Get the HTTP POST data
$postData = file_get_contents("php://input");
$data = json_decode($postData);

// Parse incoming data
$device_id = null;

// Check if the device exists in the Devices table
$device_query = "SELECT device_id FROM Devices WHERE device_name = '".$data->device_name."' AND location = '".$data->location."'";
$device_result = $conn->query($device_query);

if ($device_result->num_rows > 0) {
    // Device already exists, retrieve its device_id
    $device_row = $device_result->fetch_assoc();
    $device_id = $device_row["device_id"];
} else {
    // Device does not exist, insert it into the Devices table
    $insert_device_query = "INSERT INTO Devices (device_name, location) VALUES ('".$data->device_name."', '".$data->location."')";
    if ($conn->query($insert_device_query) === TRUE) {
        // Get the auto-incremented device_id of the newly added device
        $device_id = $conn->insert_id;
    } else {
        echo "Error inserting device: " . $conn->error;
    }
}

// Proceed only if device_id is not null
if ($device_id !== null) {
    $timestamp = date('Y-m-d H:i:s');
    $temperature = $data->temperature;
    $humidity = $data->humidity;
    $light_intensity = $data->light_intensity;

    // Insert readings into the database
    $sql = "INSERT INTO Readings (device_id, timestamp, temperature, humidity, light_intensity) 
            VALUES ('$device_id', '$timestamp', '$temperature', '$humidity', '$light_intensity')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
