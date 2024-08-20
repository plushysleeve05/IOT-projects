<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Data</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h1>Browse Data</h1>
        <!-- Table to display sensor readings -->
        <table class="tbdata">
            <thead>
                <tr>
                    <th>Node ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Timestamp</th>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>Light Intensity</th>
                </tr>
            </thead>
            <tbody id="sensorData">
                <!-- Data rows will be dynamically populated here -->
            </tbody>
        </table>
        <!-- Pagination links -->
        <div class="pagination">
            <!-- Pagination links will be generated dynamically -->
        </div>
    </div>

    <div class="container">
        <h1>Query/Report</h1>
        <form onsubmit="event.preventDefault(); submitQuery();" method="get">
            <!-- Form inputs for query parameters -->
            <!-- Example: Node ID, Timestamp Range -->
            <label for="node_id">Node ID:</label>
            <input type="text" id="node_id" name="node_id">
            <label for="timestamp_start">Start Timestamp:</label>
            <input type="datetime-local" id="timestamp_start" name="timestamp_start">
            <br><br><br><br>
            <label for="timestamp_end">End Timestamp:</label>
            <input type="datetime-local" id="timestamp_end" name="timestamp_end">
            <button type="submit">Submit Query</button>
        </form>
        <div class="container" id="queryResults">
            <!-- Query results will be displayed here -->
        </div>
    </div>

    <div class="container">
        <h1>Data Visualization</h1>
        <canvas id="temperatureChart"></canvas>
    </div>

    <!-- Configuration Page Link -->
    <div class="container">
    <button class="button-9" role="button"><a href="configuration.php">Go to Configuration Page</a></button>
    
    <button class="button-9" role="button"><a href="172.20.10.3/index.html">view esp32</a></button>
    </div>
    <!-- HTML !-->




</body>
<script>
    // Fetch sensor data asynchronously using JavaScript and PHP
    window.onload = function() {
        fetchData();
    };

    function fetchData() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse JSON data into an array of objects
                var sensorData = JSON.parse(xhr.responseText);
                displayData(sensorData);
                createChart(sensorData);
            }
        };
        xhr.open("GET", "fetchData.php", true);
        xhr.send();
    }

    function displayData(data) {
        var sensorData = document.getElementById("sensorData");
        sensorData.innerHTML = ""; // Clear previous data
        data.forEach(function(row) {
            var tr = document.createElement("tr");
            tr.innerHTML = "<td>" + row.device_id + "</td>" +
                "<td>" + row.device_name + "</td>" +
                "<td>" + row.device_location + "</td>" +
                "<td>" + row.timestamp + "</td>" +
                "<td>" + row.temperature + "</td>" +
                "<td>" + row.humidity + "</td>" +
                "<td>" + row.light_intensity + "</td>";
            sensorData.appendChild(tr);
        });
    }

    // Create a line chart
    function createChart(data) {
        // Extract temperature data from sensor data
        var temperatures = data.map(function(row) {
            return row.temperature;
        });

        // Extract timestamps for labels
        var timestamps = data.map(function(row) {
            return row.timestamp;
        });

        // Create a canvas element for the chart
        var ctx = document.getElementById("temperatureChart").getContext("2d");

        // Create the chart
        var chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: timestamps,
                datasets: [{
                    label: "Temperature",
                    data: temperatures,
                    borderColor: "rgba(255, 99, 132, 1)",
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                }
            }
        });
    }

    // Submit query form asynchronously using JavaScript and PHP
    function submitQuery() {
        console.log("Submit button clicked!"); // Check if this message is logged
        // Get form input values
        var nodeId = document.getElementById("node_id").value;
        var timestampStart = document.getElementById("timestamp_start").value;
        var timestampEnd = document.getElementById("timestamp_end").value;

        // Create new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the request parameters
        var params = {
            node_id: nodeId,
            timestamp_start: timestampStart,
            timestamp_end: timestampEnd
        };

        // Configure the request
        xhr.open("POST", "getQueryReport.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        // Set the callback function to handle the response
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse JSON data into an object
                var responseData = JSON.parse(xhr.responseText);

                // Convert object back to JSON string with indentation for readability
                var formattedJSON = JSON.stringify(responseData, null, 2);

                // Display the formatted JSON in the element
                document.getElementById("queryResults").innerHTML = "<pre>" + formattedJSON + "</pre>";
            }
        };
        // Send the request with the JSON payload
        xhr.send(JSON.stringify(params));
    }
</script>

</html>
