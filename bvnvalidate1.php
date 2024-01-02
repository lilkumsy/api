<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
</head>
<body>
    <?php
    function generateOTP() {
        // Generate a 6-digit random OTP
        return mt_rand(100000, 999999);
    }

    // Function to send OTP to the internal SMS API using cURL
    function sendOTPToInternalApi($apiEndpoint, $apiParams) {
        $curl = curl_init($apiEndpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return array(
            'response' => $apiResponse,
            'http_status_code' => $httpStatusCode
        );
    }

    // Check if the form is submitted for OTP verification
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['otp'])) {
        // Get the entered OTP
        $enteredOTP = $_POST['otp'];

        // Validate the entered OTP (You may want to add more validation as needed)
        session_start();
        $generatedOTP = $_SESSION['generatedOTP']; // Retrieve the generated OTP from the session

        if ($enteredOTP == $generatedOTP) {
            echo "OTP verification successful.<br/>";
			echo "<href='application.php'>Proceed to the next page.</a>";
            // Redirect to the next page or perform further actions
        } else {
            echo "Invalid OTP. Please try again.";
        }
    } else {
        // Display the form to generate and send OTP
        ?>
        <h1>Generate and Send OTP</h1>

        <?php
        // Check if the form is submitted for BVN retrieval
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bvn'])) {
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
                    $tel2 = $formattedR['getSingleBVNModel']['phonenumber1'];

                    // Generate and send OTP using your internal SMS API
                    $generatedOTP = generateOTP();

                    // Your internal SMS API logic to send the OTP to $tel2
                    $apiEndpoint = "http://ibank.itmbplc.com:8500/RadiusPoints/";
                    $apiParams = array(
                        'phone_number' => $tel2,
                        'otp' => $generatedOTP
                    );

                    $apiResponse = sendOTPToInternalApi($apiEndpoint, $apiParams);

                    if ($apiResponse['http_status_code'] == 200) {
						echo $generatedOTP;
                        echo "OTP sent to $tel2. Check your phone for the OTP.";

                        // Store the generated OTP in the session for later verification
                        session_start();
                        $_SESSION['generatedOTP'] = $generatedOTP;
                    } else {
                        echo "Failed to send OTP. HTTP Status Code: " . $apiResponse['http_status_code'];
                    }
                } else {
                    echo "Invalid API response format.";
                }
            } else {
                echo 'No response from the API';
            }
        }

        // Display the form for BVN retrieval
        ?>
        <form method="post" action="">
            <label for="bvn">Enter BVN:</label>
            <input type="text" id="bvn" name="bvn">
            <input type="submit" value="Submit">
        </form>
        <?php
    }
    ?>
    
    <?php
    // Display the form for OTP verification
    if (isset($tel2)) {
        ?>
        <h1>Verify OTP</h1>
        <form method="post" action="">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp">
            <input type="submit" value="Verify OTP">
        </form>
        <?php
    }
    ?>
</body>
</html>
