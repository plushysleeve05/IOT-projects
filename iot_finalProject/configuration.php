<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Configuration</h1>
        <form id="configurationForm">
            <!-- Form inputs for configuration settings -->
            <!-- Example: Node ID, HTTP/MQTT, Trigger Temperature -->
            <label for="node_id">Node ID:</label>
            <input type="text" id="node_id" name="node_id">
            <label for="protocol">Protocol:</label>
            <select id="protocol" name="protocol">
                <option value="http">HTTP</option>
                <option value="mqtt">MQTT</option>
            </select>
            <label for="trigger_temp">Trigger Temperature:</label>
            <input type="number" id="trigger_temp" name="trigger_temp">
            <button type="submit">Save Configuration</button>
        </form>
    </div>

    <!-- Script to handle form submission -->
    <script>
        document.getElementById('configurationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            // Get form data
            var formData = new FormData(this);
            
            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request was successful
                        console.log(xhr.responseText);
                        alert("details have been added!");
                        // Optionally, handle response here
                    } else {
                        // Request failed
                        console.error('Request failed:', xhr.status);
                    }
                }
            };
            xhr.open('POST', 'submit-configuration.php', true);
            xhr.send(formData);
        });
    </script>
</body>
</html>
