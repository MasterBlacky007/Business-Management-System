<?php
// Include database connection
include('conf.php');

if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT price FROM product WHERE productID = ?");
    $stmt->bind_param("s", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'price' => $row['price']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
