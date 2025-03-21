<?php
include('conf.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $paymentID = $_POST['paymentID'];
    $status = $_POST['status'];

    // Update the status in the database
    $sql = "UPDATE spayment SET Status = ? WHERE PaymentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $paymentID);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status.";
    }

    $stmt->close();
    $conn->close();
    header("Location: export-order.php"); // Redirect back to the page
}
?>
