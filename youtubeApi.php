<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Analytics</title>
</head>
<body>

<h1>YouTube Video Analytics</h1>

<!-- HTML form to get user input -->
<form method="get" action="">
    <label for="videoId">Enter YouTube Video ID:</label>
    <input type="text" name="videoId" id="videoId" required>
    <button type="submit">Get Analytics</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['videoId'])) {
    // If the form is submitted, fetch YouTube video analytics

    // Replace 'YOUR_API_KEY' with your actual YouTube API key
    $apiKey = 'AIzaSyASrJNvR5J76UQ_I1w7t0WmC81r1Igpe2c';

    // Get video ID from the form
    $videoId = $_GET['videoId'];

    // Construct API URL with the video ID and API key
    $apiUrl = "https://www.googleapis.com/youtube/v3/videos?part=statistics&id=$videoId&key=$apiKey";

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
            // Display video analytics
            echo "<h2>Video Analytics:</h2>";
            echo "Views: " . $data['items'][0]['statistics']['viewCount'] . "<br>";
            echo "Likes: " . $data['items'][0]['statistics']['likeCount'] . "<br>";
            echo "Dislikes: " . $data['items'][0]['statistics']['dislikeCount'] . "<br>";
            echo "Comments: " . $data['items'][0]['statistics']['commentCount'] . "<br>";
        }
    }

    // Close cURL session
    curl_close($ch);
}
?>

</body>
</html>
