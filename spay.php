<?php
// Include the database connection
include('conf.php');

// Initialize variables
$orderData = [];

// Check if the order ID is provided
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Query to fetch the order details
    $stmt = $conn->prepare("SELECT * FROM sgenpay WHERE OrderID = ?");
    $stmt->bind_param("i", $orderId);  // Note the change to "i" to bind as integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $orderData = $result->fetch_assoc();
    } else {
        die("Order not found.");
    }

    $stmt->close();
} else {
    die("Order ID not provided.");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <link rel="stylesheet" href="pay.css">
    <script>
        function validatePaymentStatus() {
            const paymentStatus = document.getElementById("paymentStatus").value;

            if (paymentStatus === "Paid") {
                alert("This order has already been paid.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        function showPaymentDetails() {
            const paymentType = document.getElementById("paymentType").value;
            document.getElementById("debitFields").style.display = (paymentType === "Debit") ? "block" : "none";
            document.getElementById("creditFields").style.display = (paymentType === "Credit") ? "block" : "none";
            document.getElementById("paypalFields").style.display = (paymentType === "Paypal") ? "block" : "none";
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Make Payment</h2>
    <form action="spayment_process.php" method="POST" onsubmit="return validatePaymentStatus()">
        <!-- Hidden input to store payment status -->
        <input type="hidden" id="paymentStatus" value="<?php echo htmlspecialchars($orderData['Status']); ?>">

        <!-- Display Order Details -->
        <label>Order ID:</label>
        <input type="text" name="orderId" value="<?php echo htmlspecialchars($orderData['OrderID']); ?>" readonly>

        <label>Supplier ID:</label>
        <input type="text" value="<?php echo htmlspecialchars($orderData['SupplierID']); ?>" readonly>

        <label>Order Date:</label>
        <input type="text" value="<?php echo htmlspecialchars($orderData['OrderDate']); ?>" readonly>

        <label>Quantity:</label>
        <input type="text" value="<?php echo htmlspecialchars($orderData['Quantity']); ?>" readonly>

        <label>Price:</label>
        <input type="text" value="<?php echo htmlspecialchars($orderData['Price']); ?>" readonly>

        <label>Order Amount (LKR):</label>
        <input type="text" name="amount" value="<?php echo htmlspecialchars($orderData['OrderAmount']); ?>" readonly>

        <!-- Payment Date -->
        <label for="paymentDate">Payment Date:</label>
        <input type="date" id="paymentDate" name="paymentDate" value="<?php echo date('Y-m-d'); ?>" required>

        <!-- Payment Type Selection -->
        <label for="paymentType">Select Payment Type:</label>
        <select name="paymentType" id="paymentType" onchange="showPaymentDetails()" required>
            <option value="">-- Select Payment Type --</option>
            <option value="Debit">Debit Card</option>
            <option value="Credit">Credit Card</option>
            <option value="Paypal">Paypal</option>
        </select>

        <!-- Debit Card Fields -->
        <div id="debitFields" style="display: none;">
            <label for="debitCardNumber">Card Number:</label>
            <input type="text" name="debitCardNumber" placeholder="Enter Debit Card Number">

            <label for="debitExpiryDate">Expiry Date:</label>
            <input type="month" name="debitExpiryDate">

            <label for="debitCvv">CVV:</label>
            <input type="password" name="debitCvv" placeholder="Enter CVV">
        </div>

        <!-- Credit Card Fields -->
        <div id="creditFields" style="display: none;">
            <label for="creditCardNumber">Card Number:</label>
            <input type="text" name="creditCardNumber" placeholder="Enter Credit Card Number">

            <label for="creditExpiryDate">Expiry Date:</label>
            <input type="month" name="creditExpiryDate">

            <label for="creditCvv">CVV:</label>
            <input type="password" name="creditCvv" placeholder="Enter CVV">
        </div>

        <!-- Paypal Fields -->
        <div id="paypalFields" style="display: none;">
            <label for="paypalEmail">Paypal Email:</label>
            <input type="email" name="paypalEmail" placeholder="Enter Paypal Email">

            <label for="paypalVerificationCode">Verification Code:</label>
            <input type="text" name="paypalVerificationCode" placeholder="Enter Verification Code">
        </div>

        <!-- Submit Button -->
        <button type="submit">Pay Now</button>

        <!-- Back Button -->
        <button type="button" onclick="window.location.href='facviewpay.php'" style="background-color: #007bff; margin-top: 10px; padding: 12px 25px; color: white; border: none; border-radius: 5px; cursor: pointer;">Back</button>
    </form>
</div>
</body>
</html>
