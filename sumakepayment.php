<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize the success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $suid = $_POST['suid'];
    $oid = $_POST['oid'];
    $odate = $_POST['odate'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    

    // Calculate Order Amount
    $oa = ($quantity * $price) + ($quantity * 10);

    // Check if the record with the same SupplierID and OrderID already exists
    $checkQuery = "SELECT * FROM sgenpay WHERE SupplierID = ? AND OrderID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $suid, $oid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Record already exists, display error message
        echo "<script>
                alert('Duplicate entry: This order with the same SupplierID and OrderID already exists.');
              </script>";
    } else {
        // Insert into the database if no duplicate
        $sql = "INSERT INTO sgenpay (SupplierID, OrderID, OrderDate, Quantity, Price, OrderAmount, Status) 
                VALUES ('$suid', '$oid', '$odate', '$quantity', '$price', '$oa', 'pending')";

        if (mysqli_query($conn, $sql)) {
            // Get the last inserted order ID
            $orderId = mysqli_insert_id($conn);
            $successMessage = "Order added successfully!";

            // Display success message using JavaScript
            echo "<script>
                    alert('Order added successfully!');
                    window.location.href = 'sumakepayment.php'; // Optional: reload the page after showing message
                  </script>";
        } else {
            // Display error message
            $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

            // Display failure message using JavaScript
            echo "<script>
                    alert('Failed to add record. Please try again.');
                  </script>";
        }
    }

    // Close the statement
    $stmt->close();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="supmakep.css">
    <script>
        function calculateOrderAmount() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const price = parseFloat(document.getElementById('price').value) || 0;
            const orderAmount = (quantity * price) + (quantity * 10);
            document.getElementById('oa').value = orderAmount.toFixed(2); // Display calculated value
        }
    </script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="supimportorder.php">Order</a></li>
            <li><a href="suppayment.html">Payment</a></li>
            <li><a href="supprofile.php">My Profile</a></li>
            <li><a href="suplogin.php">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Create Order</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="sumakepayment.php" method="POST">
                <label for="suid">Supplier ID</label>
                <input type="text" id="suid" name="suid" required>

                <label for="oid">Order ID</label>
                <input type="text" id="oid" name="oid" required>

                <label for="odate">Order Date</label>
                <input type="date" id="odate" name="odate" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" oninput="calculateOrderAmount()" required>

                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" oninput="calculateOrderAmount()" required>

                <label for="oa">Order Amount</label>
                <input type="number" id="oa" name="oa" step="0.01" readonly required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
