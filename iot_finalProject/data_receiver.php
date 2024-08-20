<?php
include 'config.php'; // Include your database configuration

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract POST data
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : null;
    $humidity = isset($_POST['humidity']) ? $_POST['humidity'] : null;
    $lightIntensity = isset($_POST['lightIntensity']) ? $_POST['lightIntensity'] : null;

    // Validate data (basic validation, consider enhancing it)
    if ($temperature === null || $humidity === null || $lightIntensity === null) {
        echo "Invalid data received.";
        exit;
    }

    // Prepare SQL query
    $query = $conn->prepare("INSERT INTO SensorReadings (DeviceID, SensorTypeID, ReadingValue, Timestamp) VALUES (?, ?, ?, NOW())");
    
    // Assume DeviceID and SensorTypeID are known or determined beforehand
    // For demonstration purposes, DeviceID=1 for Temperature, 2 for Humidity, 3 for Light Intensity
    // You might need a more dynamic way to determine these IDs based on your project setup
    $query->bind_param("iis", $deviceID, $sensorTypeID, $readingValue);

    // Insert Temperature
    $deviceID = 1; // Example DeviceID for Temperature
    $sensorTypeID = 1; // Example SensorTypeID for Temperature
    $readingValue = $temperature;
    $query->execute();

    // Insert Humidity
    $deviceID = 1; // Example DeviceID for Humidity
    $sensorTypeID = 2; // Example SensorTypeID for Humidity
    $readingValue = $humidity;
    $query->execute();

    // Insert Light Intensity
    $deviceID = 1; // Example DeviceID for Light Intensity
    $sensorTypeID = 3; // Example SensorTypeID for Light Intensity
    $readingValue = $lightIntensity;
    $query->execute();

    echo "Data inserted successfully.";

    $query->close();
    $conn->close();
} else {
    echo "Only POST requests are accepted.";
}
?>
