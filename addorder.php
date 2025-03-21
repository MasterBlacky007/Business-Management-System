<?php
include('conf.php');

// Start session to manage login state
session_start();

// Get the form data
$productID = $_POST['productID'];
$nic = $_POST['nic'];
$orderDate = $_POST['exportOrderDate'];
$quantity = $_POST['quantity'];
$destinationAddress = $_POST['destinationAddress'];
$amount = $_POST['amount'];

// SQL to insert data into the export orders table with the 'Payment' column set to 'pending' by default
$sql = "INSERT INTO lcorder (ProductID, NIC, OrderDate, Quantity, Address, Amount, Payment) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssd", $productID, $nic, $orderDate, $quantity, $destinationAddress, $amount);

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
