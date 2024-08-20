<?php

require_once 'config2.php';
$json_data = file_get_contents('php://input');
$params = json_decode($json_data, true);

if(isset($params['node_id']) && isset($params['timestamp_start']) && isset($params['timestamp_end'])) {
    $nodeId = $params['node_id'];
    $timestampStart = $params['timestamp_start'];
    $timestampEnd = $params['timestamp_end'];

    $sql = "SELECT * FROM readings WHERE device_id = '$nodeId' AND timestamp BETWEEN '$timestampStart' AND '$timestampEnd'";
    $result = $conn->query($sql);

    $sensorData = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sensorData[] = $row;
        }
        echo json_encode($sensorData);
    } else {
        echo "No data found.";
    }

    $conn->close();
} else {
    echo "Please provide all the required parameters.";
}
?>
