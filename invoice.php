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

        $sql = "SELECT * FROM lcorder WHERE OrderID = $orderId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='invoice-detail'><strong>Order ID:</strong> " . $row['OrderID'] . "</div>";
                echo "<div class='invoice-detail'><strong>Product ID:</strong> " . $row['ProductID'] . "</div>";
                echo "<div class='invoice-detail'><strong>NIC:</strong> " . $row['NIC'] . "</div>";
                echo "<div class='invoice-detail'><strong>Order Date:</strong> " . $row['OrderDate'] . "</div>";
                echo "<div class='invoice-detail'><strong>Quantity:</strong> " . $row['Quantity'] . "</div>";
                echo "<div class='invoice-detail'><strong>Address:</strong> " . $row['Address'] . "</div>";
                echo "<div class='invoice-detail'><strong>Amount:</strong> " . $row['Amount'] . "</div>";
                echo "<div class='invoice-detail'><strong>Payment:</strong> " . $row['Payment'] . "</div>";
            }
        } else {
            echo "<p>No order found with ID $orderId.</p>";
        }

        $conn->close();
        ?>
        <button onclick="window.print()">Print Invoice</button>
        <button onclick="window.location.href='vieworder1.php'">Back</button>
    </div>
</body>
</html>
