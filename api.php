<?php
header("Content-Type: application/json");

if (isset($_GET['orderNumber']) && $_GET['orderNumber'] !== "") {
    include('connection.php');

    $orderNumber = mysqli_real_escape_string($conn, $_GET['orderNumber']);

    $result = mysqli_query($conn, "SELECT * FROM orders WHERE orderNumber='$orderNumber'");

    if ($result === false) {
        response(NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, "Database Error");
    } elseif (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        response(
            $row['orderNumber'],
            $row['orderDate'],
            $row['requiredDate'],
            $row['shippedDate'],
            $row['status'],
            $row['comments'],
            $row['customerNumber']
        );
    } else {
        response(NULL, NULL, NULL, NULL, NULL, NULL, NULL, 404, "No Record Found");
    }

    mysqli_close($conn);
} else {
    response(NULL, NULL, NULL, NULL, NULL, NULL, NULL, 400, "Invalid Request");
}

function response($orderNumber, $orderDate, $requiredDate, $shippedDate, $status, $comments, $customerNumber, $statusCode = 200, $message = null)
{
    $response['orderNumber'] = $orderNumber;
    $response['orderDate'] = $orderDate;
    $response['requiredDate'] = $requiredDate;
    $response['shippedDate'] = $shippedDate;
    $response['status'] = $status;
    $response['comments'] = $comments;
    $response['customerNumber'] = $customerNumber;
    $response['statusCode'] = $statusCode;
    $response['message'] = $message;

    $json_response = json_encode($response);

    if ($json_response === false) {
        echo json_encode(['statusCode' => 500, 'message' => 'Error encoding JSON']);
    } else {
        http_response_code($statusCode);
        echo $json_response;
    }
}
?>
