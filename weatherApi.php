<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>

<h1>Weather Information</h1>

<!-- HTML form to get user input -->
<form method="post" action="">
    <label for="city">Enter City:</label>
    <input type="text" name="city" id="city" required>
    <button type="submit">Get Weather</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If the form is submitted, fetch weather information

    // Replace 'YOUR_API_KEY' with your actual OpenWeatherMap API key
    $apiKey = 'd0d4e27a28b28ad78bf11f42718da859';

    // Get city from the form
    $city = isset($_POST['city']) ? $_POST['city'] : '';

    if (!empty($city)) {
        // Construct API URL with the city and API key
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey";

        // Initialize cURL session
        $ch = curl_init($apiUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // Decode JSON response
            $data = json_decode($response, true);

            // Check if decoding was successful
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                echo 'Error decoding JSON: ' . json_last_error_msg();
            } else {
                // Display weather information
                echo "<h2>Weather in $city:</h2>";
                echo "Temperature: " . (isset($data['main']['temp']) ? $data['main']['temp'] . ' °C' : 'N/A') . "<br>";
                echo "Description: " . (isset($data['weather'][0]['description']) ? $data['weather'][0]['description'] : 'N/A') . "<br>";
                echo "Humidity: " . (isset($data['main']['humidity']) ? $data['main']['humidity'] . '%' : 'N/A') . "<br>";
                echo "Wind Speed: " . (isset($data['wind']['speed']) ? $data['wind']['speed'] . ' m/s' : 'N/A') . "<br>";
            }
        }

        // Close cURL session
        curl_close($ch);
    } else {
        echo "Please enter a city.";
    }
}
?>

</body>
</html>
