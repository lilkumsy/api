<?php
include('connection.php');
if (isset($_POST['orderNumber']) && $_POST['orderNumber'] != "") {
    $orderNumber = $_POST['orderNumber'];
    $url = "http://10.2.2.50:81/xampp/api/api.php?orderNumber=10112";

    $client = curl_init($url);
    curl_setopt($client, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($client, CURLOPT_VERBOSE, true);
    $response = curl_exec($client);

    // Debugging output
    var_dump($url, $response);

    if ($response === false) {
        echo "cURL Error: " . curl_error($client);
    } else {
        $result = json_decode($response);

        // Debugging output
        var_dump($result);

        if ($result === null) {
            echo "Error decoding JSON response";
        } else {
            echo "<table>";
            echo "<tr><td>Order number:</td><td>$result->orderNumber</td></tr>";
            echo "<tr><td>Order Date:</td><td>$result->orderDate</td></tr>";
            echo "<tr><td>Required Date:</td><td>$result->requiredDate</td></tr>";
            echo "<tr><td>Shipped Date:</td><td>$result->shippedDate</td></tr>";
            echo "<tr><td>Status:</td><td>$result->status</td></tr>";
            echo "<tr><td>Comments:</td><td>$result->comments</td></tr>";
            echo "<tr><td>Customer Number:</td><td>$result->customerNumber</td></tr>";
            echo "</table>";
        }
    }

    curl_close($client);
}
?>
<center>
    <form action="" method="POST">
        <label>Enter Order Number:</label><br /><br />
        <input type="text" name="orderNumber" placeholder="Enter Order number" required />
        <br /><br />
        <button type="submit" name="submit">Check Order Details</button>
    </form>
</center>
