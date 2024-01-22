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
$apiUrl = 'http://10.1.0.17:5000/api/singlebvnverification?bvn=22336776725';

// Make API request
$data = file_get_contents($apiUrl);
//print $data;
if ($data) {
    // Decode JSON data
    $decodedData1 = json_decode($data, true);
	
	$decodedData=$decodedData1['getSingleBVNModel'];
	
	echo 'BVN DATA FROM API';
	
    echo '<h3>First Name: ' . $decodedData['firstname'] . '</h3>';
    echo '<h3>Last Name: ' . $decodedData['lastname'] . '</h3>';
	echo '<h3>Middle Name: ' . $decodedData['middlename'] . '</h3>';
    echo '<h3>Date Of Birth: ' . $decodedData['dateofbirth'] . '</h3>';
	echo '<h3>Gender: ' . $decodedData['gender'] . '</h3>';
    echo '<h3>Local Governement Area: ' . $decodedData['lgaoforigin'] . '</h3>';
	echo '<h3>Marital Status: ' . $decodedData['maritalstatus'] . '</h3>';
	echo '<h3>Nationality: ' . $decodedData['nationality'] . '</h3>';
    echo '<h3>Phone Number 1: ' . $decodedData['phonenumber1'] . '</h3>';
	echo '<h3>Phone Number 2: ' . $decodedData['phonenumber2'] . '</h3>';
    echo '<h3>Address: ' . $decodedData['residentialaddress'] . '</h3>';
	echo '<img src="'. $decodedData['base64image'].'" />';
} else {
    // Handle error
    echo 'Error fetching data from the API.';
}
?>

</body>
</html>
