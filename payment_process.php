<?php
// Include the database connection
include('conf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch input data
    $orderID = $_POST['orderId'];
    $paymentType = $_POST['paymentType'];
    $paymentDate = $_POST['paymentDate'];
    $amount = (float)$_POST['amount'];
    $createdAt = date('Y-m-d H:i:s');

    // Check if the order is already paid
    $query = "SELECT Payment FROM lcorder WHERE OrderID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    // If the order is paid, show a message and do not proceed further
    if ($order['Payment'] === 'Paid') {
        echo "<script>alert('This order has already been paid.'); window.location.href='vieworder1.php';</script>";
        exit; // Stop further execution
    }

    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        if ($amount <= 0) {
            throw new Exception("No payment is required. You don't have an outstanding balance.");
        }

        // Payment-specific logic
        if ($paymentType === 'Credit' || $paymentType === 'Debit') {
            $cardNumber = $_POST[$paymentType === 'Credit' ? 'creditCardNumber' : 'debitCardNumber'];
            $cvv = $_POST[$paymentType === 'Credit' ? 'creditCvv' : 'debitCvv'];
            $expiryDate = $_POST[$paymentType === 'Credit' ? 'creditExpiryDate' : 'debitExpiryDate'] . "-01";

            $query = "INSERT INTO " . strtolower($paymentType) . "_table (OrderID, CardNumber, ExpiryDate, CVV, Amount, PaymentDate, CreatedAt) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssss", $orderID, $cardNumber, $expiryDate, $cvv, $amount, $paymentDate, $createdAt);
            $stmt->execute();
            $stmt->close();
        } elseif ($paymentType === 'Paypal') {
            $email = $_POST['paypalEmail'];
            $verificationCode = $_POST['paypalVerificationCode'];

            $query = "INSERT INTO paypal_table (OrderID, Email, VerificationCode, Amount, PaymentDate, CreatedAt) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $orderID, $email, $verificationCode, $amount, $paymentDate, $createdAt);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Invalid payment type selected.");
        }

        // Insert into payments table
        $paymentDetails = "Payment processed via $paymentType";
        $query = "INSERT INTO payments (OrderID, PaymentDate, PaymentType, PaymentDetails, Amount, CreatedAt) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $orderID, $paymentDate, $paymentType, $paymentDetails, $amount, $createdAt);
        $stmt->execute();
        $stmt->close();

        // Update ledger table
        $query = "UPDATE lcorder SET Payment = 'Paid' WHERE OrderID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $orderID);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        mysqli_commit($conn);

        echo "<script>alert('Payment successfully processed.'); window.location.href='vieworder1.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}

// Close the database connection
$conn->close();
?>
