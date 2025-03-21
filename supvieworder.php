<?php
include('conf.php'); // Include your database configuration

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions for confirming and rejecting orders
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $orderId = $conn->real_escape_string($_POST['order_id']);
        echo "<script>alert('Order $orderId confirmed.');</script>";
    }

    if (isset($_POST['reject'])) {
        $orderId = $conn->real_escape_string($_POST['order_id']);
        $deleteQuery = "DELETE FROM addorder WHERE orderid='$orderId'";
        if ($conn->query($deleteQuery)) {
            echo "<script>alert('Order $orderId rejected and removed.');</script>";
        } else {
            echo "<script>alert('Error rejecting order $orderId: " . $conn->error . "');</script>";
        }
    }
}

// Default SQL query for fetching orders
$sql = "SELECT * FROM addorder";

// Handle search input and filter by SupplierID
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);

    // Assuming 'supplierid' is a column in your 'addorder' table
    // Modify this if needed to search by the correct column
    $sql .= " WHERE supplierid LIKE '%$searchTerm%'";
}

// Execute query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="importorder.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
            <li><a href="supimportorder.php">Order</a></li>
            <li><a href="suppayment.html">Payment</a></li>
            <li><a href="export-order.html">My Profile</a></li>
            <li><a href="Home.html">LogOut</a></li>
        </ul>
    </aside>

    <main>
        <h1>Import Order</h1>
        
        <!-- Search Form -->
        <form method="get">
            <input type="text" name="search" placeholder="Search by Supplier ID">
            <input type="submit" value="Search">
        </form>

        <!-- Orders Table - Only visible if Supplier ID is searched -->
        <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Order Date</th>
                        <th>Quantity</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result === false) {
                        echo "<tr><td colspan='7' style='color: red;'>SQL Error: " . $conn->error . "</td></tr>";
                    } elseif ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['orderid']}</td>";
                            echo "<td>{$row['productid']}</td>";
                            echo "<td>{$row['orderdate']}</td>";
                            echo "<td>{$row['quantity']}</td>";
                            echo "<td>{$row['daddress']}</td>";
                            echo "<td>{$row['amount']}</td>";
                            echo "<td>";
                            echo "<form method='post' style='display:inline;'>";
                            echo "<input type='hidden' name='order_id' value='{$row['orderid']}'>";
                            echo "<button type='submit' name='confirm' class='action-btn btn-confirm'>Confirm</button>";
                            echo "</form>";
                            echo "<form method='post' style='display:inline;'>";
                            echo "<input type='hidden' name='order_id' value='{$row['orderid']}'>";
                            echo "<button type='submit' name='reject' class='action-btn btn-reject'>Reject</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No orders found for this Supplier ID.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>

    </main>
</body>
</html>
