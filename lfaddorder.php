<?php
include('conf.php');

// Start session to manage login state
session_start();

// Get the form data
$productID = $_POST['productID'];
$iic = $_POST['iic'];
$orderDate = $_POST['exportOrderDate'];
$quantity = $_POST['quantity'];
$destinationAddress = $_POST['destinationAddress'];
$country = $_POST['country'];
$amount = $_POST['amount'];

// SQL to insert data into the lforder table with the 'Payment' column set to 'pending' by default
$sql = "INSERT INTO lforder (ProductID, IIC, OrderDate, Quantity, Address, Country, Amount, Payment) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssd", $productID, $iic, $orderDate, $quantity, $destinationAddress, $country, $amount);

$response = [];
if ($stmt->execute()) {
    // Get the auto-generated ID
    $orderID = $conn->insert_id;

    $response['success'] = true;
    $response['orderID'] = $orderID; // Return the generated Order ID
} else {
    $response['success'] = false;
    $response['message'] = "Error inserting order: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
