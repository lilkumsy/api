<!DOCTYPE html>
<html>
<head>
    <title>bvn</title>
</head>
<body>
    <h1>BVN Details</h1>

    <!-- HTML Form with an input box for BVN -->
    <form method="post" action="">
        <label for="bvn">Enter BVN:</label>
        <input type="text" id="bvn" name="bvn">
        <input type="submit" value="Submit">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get BVN from the form input
        $inputBvn = $_POST['bvn'];

        // Validate BVN (You may want to add more validation as needed)

        // API Endpoint URL with the dynamically obtained BVN
        $url = "http://10.1.0.17:5000/api/singlebvnverification?bvn=" . urlencode($inputBvn);

        // Initialize cURL session
        $curl = curl_init($url);

        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session and get the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            echo 'cURL error: ' . curl_error($curl);
        }

        // Close cURL session
        curl_close($curl);

        // Process the API response
        if ($response) {
            // Decode JSON response
            $formattedR = json_decode($response, true);

            // Check if the response has the expected structure
            if (isset($formattedR['getSingleBVNModel'])) {
                $tel1 = $formattedR['getSingleBVNModel']['firstname'];
                $tel2 = $formattedR['getSingleBVNModel']['phonenumber1'];

                echo "<br>";
                echo ("Firstname  : " . $tel1 . "<br>");
                echo "<br>";
                echo ("Phone Number : " . $tel2 . "<br>");
            } else {
                echo "Invalid API response format.";
            }
        } else {
            echo 'No response from the API';
        }
    }
    ?>
</body>
</html>


