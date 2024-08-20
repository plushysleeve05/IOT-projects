<?php
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $nodeId = $_POST["node_id"];
    $protocol = $_POST["protocol"];
    $triggerTemp = $_POST["trigger_temp"];

    require_once 'config2.php';

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO configurations (device_id, protocol, trigger_temp) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nodeId, $protocol, $triggerTemp);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        echo "Configuration saved successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    // If form data is not received, return an error message
    echo "Error: Form data not received";
}
?>
