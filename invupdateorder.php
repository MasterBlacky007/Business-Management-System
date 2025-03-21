<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize variables
$successMessage = "";
$orderData = null;

// Handle search form submission
if (isset($_POST['search'])) {
    $orderID = $_POST['orderid'];

    // Fetch order data from the database
    $sql = "SELECT * FROM genorder WHERE oid = '$orderID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $orderData = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Order not found. Please try again.');</script>";
    }
}

// Handle update form submission
if (isset($_POST['update'])) {
    $orderID = $_POST['orderid'];
    $suid = $_POST['suid'];
    $odate = $_POST['odate'];
    $rdate = $_POST['rdate'];
    $pmaterial = $_POST['pmaterial'];
    $quantity = $_POST['quantity'];

    // Update the order in the database
    $sql = "UPDATE genorder SET suid = '$suid', odate = '$odate', rdate = '$rdate', pmatirial = '$pmaterial', quantity = '$quantity'  WHERE oid = '$orderID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Order updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update order. Please try again.');</script>";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="imorder.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="ingenorder.html">Generate Order</a></li>
            <li><a href="invieworder.php">Import Order</a></li>
            <li><a href="imstock.html">Stock Status</a></li>
            <li><a href="Inventory.html">Inventory Report</a></li>
            <li><a href="Invpaymentstatus.php">Payment Status</a></li>
            <!--<li><a href="production-process.html">Stock Status</a></li>-->
            <li><a href="invsdetail.php">Supplier Details</a></li>
            <li><a href="inviewtask.php">View Task</a></li>
            <li><a href="IMprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Update Order</h2>

            <!-- Search Form -->
            <form action="invupdateorder.php" method="POST">
                <label for="orderid">Order ID</label>
                <input type="text" id="orderid" name="orderid" required value="<?php echo isset($orderData['id']) ? $orderData['id'] : ''; ?>">
                <button type="submit" name="search">Search</button>
            </form>

            <!-- Update Form -->
            <?php if ($orderData): ?>
                <form action="invupdateorder.php" method="POST">
                    <input type="hidden" name="orderid" value="<?php echo $orderData['oid']; ?>">

                    <label for="suid">Supplier ID</label>
                    <input type="text" id="suid" name="suid" required value="<?php echo $orderData['suid']; ?>">

                    <label for="odate">Order Date</label>
                    <input type="date" id="odate" name="odate" required value="<?php echo $orderData['odate']; ?>">

                    <label for="rdate">Request Date</label>
                    <input type="date" id="rdate" name="rdate" required value="<?php echo $orderData['rdate']; ?>">

                    <label for="pmaterial">Product Material</label>
                    <input type="text" id="pmaterial" name="pmaterial" required value="<?php echo $orderData['pmatirial']; ?>">

                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required value="<?php echo $orderData['quantity']; ?>">

                    <button type="submit" name="update">Update Order</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>