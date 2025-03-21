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
    $odate = $_POST['odate'];
    $rdate = $_POST['rdate'];
    $pmaterial = $_POST['pmaterial'];
    $quantity = $_POST['quantity'];

    // Insert into the database with status defaulted to 'Pending'
    $sql = "INSERT INTO genorder (suid, odate, rdate, pmatirial, quantity, status) 
            VALUES ('$suid', '$odate', '$rdate', '$pmaterial', '$quantity', 'Pending')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Order ID
        $orderID = mysqli_insert_id($conn);
        $successMessage = "Order added successfully! Order ID: " . $orderID;

        // Display success message using JavaScript
        echo "<script>
                alert('Order added successfully! Order ID: " . $orderID . "');
                window.location.href = 'invaddorder.php'; // Optional: reload the page after showing message
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to add order. Please try again.');
              </script>";
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
    <title>Create Order</title>
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
            <h2>Add Order</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="invaddorder.php" method="POST">
                <label for="suid">Supplier ID</label>
                <input type="text" id="suid" name="suid" required>

                <label for="odate">Order Date</label>
                <input type="date" id="odate" name="odate" required>

                <label for="rdate">Request Date</label>
                <input type="date" id="rdate" name="rdate" required>

                <label for="pmaterial">Product Material</label>
                <input type="text" id="pmaterial" name="pmaterial" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>

                <button type="submit">Submit Order</button>
            </form>
        </div>
    </main>
</body>
</html>