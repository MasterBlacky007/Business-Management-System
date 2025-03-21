<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        <?php include 'invoice.css'; ?>
    </style>
</head>
<body>
    <div class="container">
        <h2>Invoice</h2>
        <?php
        // Database connection
        $servername = "127.0.0.1";
        $username = "Nigeeth"; // Replace with your database username
        $password = "2018";     // Replace with your database password
        $dbname = "finaldb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve order details
        $orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;

        // Ensure only one row is fetched
        $sql = "SELECT * FROM sgenpay WHERE OrderID = $orderId LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Fetch the single row
            $row = $result->fetch_assoc();
            echo "<div class='invoice-detail'><strong>Order ID:</strong> " . $row['OrderID'] . "</div>";
            echo "<div class='invoice-detail'><strong>Supplier ID:</strong> " . $row['SupplierID'] . "</div>";
            echo "<div class='invoice-detail'><strong>Order Date:</strong> " . $row['OrderDate'] . "</div>";
            echo "<div class='invoice-detail'><strong>Quantity:</strong> " . $row['Quantity'] . "</div>";
            echo "<div class='invoice-detail'><strong>Price:</strong> " . $row['Price'] . "</div>";
            echo "<div class='invoice-detail'><strong>Order Amount:</strong> " . $row['OrderAmount'] . "</div>";
            echo "<div class='invoice-detail'><strong>Payment:</strong> " . $row['Status'] . "</div>";
        } else {
            echo "<p>No order found with ID $orderId.</p>";
        }

        $conn->close();
        ?>
        <button onclick="window.print()">Print Invoice</button>
        <button onclick="window.location.href='facviewpay.php'">Back</button>
    </div>
</body>
</html>
