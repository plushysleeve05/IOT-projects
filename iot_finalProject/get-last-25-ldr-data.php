<?php
// Include the database connection file
require_once 'config2.php';

// SQL query to retrieve the last 25 LDR readings
$sql = "SELECT light_intensity FROM readings ORDER BY timestamp DESC LIMIT 25";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Initialize an empty array to store the light intensity readings
    $ldrReadings = array();

    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add light intensity value to the readings array
        $ldrReadings[] = $row;
    }

    // Convert the readings array to JSON format
    $json = json_encode($ldrReadings);

    // Send the JSON response
    header('Content-Type: application/json');
    echo $json;
} else {
    // If no results found, send an empty JSON array
    echo json_encode(array());
    echo 'console.log("empty readings array")';
}

// Close the database connection
mysqli_close($conn);
?>
