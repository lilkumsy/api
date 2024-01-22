<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Data Display</title>
</head>
<body>

<?php
// API endpoint
$apiUrl = 'http://localhost:81/xampp/api/api.php?orderNumber=10112';

// Make API request
$data = file_get_contents($apiUrl);

if ($data) {
    // Decode JSON data
    $decodedData = json_decode($data, true);

    // Display data
	echo '<center>DATA FROM API';
    echo '<h3>Order Number: ' . $decodedData['orderNumber'] . '</h3>';
    echo '<h3>OrderDate: ' . $decodedData['orderDate'] . '</h3>';
	echo '<h3>Required Date: ' . $decodedData['requiredDate'] . '</h3>';
    echo '<h3>Shipped Date: ' . $decodedData['shippedDate'] . '</h3>';
	echo '<h3>Status: ' . $decodedData['status'] . '</h3>';
    echo '<h3>Comments: ' . $decodedData['comments'] . '</h3>';
	echo '<h3>Customer Number: ' . $decodedData['customerNumber'] . '</h3></center>';
} else {
    // Handle error
    echo 'Error fetching data from the API.';
}
?>

</body>
</html>
