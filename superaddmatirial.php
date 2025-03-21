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
    $sid = $_POST['sid'];
    $pmid = $_POST['pmid'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $sdate = $_POST['sdate'];
    $rsdate = $_POST['rsdate'];

    // Insert into the database
    $sql = "INSERT INTO pmstock (sid, pmid, quantity, location, status, sdate, rsdate) 
            VALUES ('$sid', '$pmid', '$quantity', '$location', '$status', '$sdate', '$rsdate')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Order ID
        $orderID = mysqli_insert_id($conn);
        $successMessage = "Stock order added successfully!";

        // Display success message using JavaScript
        echo "<script>
                alert('Stock order added successfully! ');
                window.location.href = 'superaddmatirial.php'; // Optional: reload the page after showing message
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to add stock order. Please try again.');
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
    <title>Create Stock Order</title>
    <link rel="stylesheet" href="superaddmatirial.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
            <li><a href="production-process.html">Import Order</a></li>
            <li><a href="instockstatus.html">Stock Status</a></li>
            <li><a href="production-process.html">Inventory Report</a></li>
            <li><a href="production-process.html">Payment Status</a></li>
            <li><a href="production-process.html">Stock Status</a></li>
            <li><a href="production-process.html">Supplier Details</a></li>
            <li><a href="production-process.html">Generate Order</a></li>
            <li><a href="cost-report.html">View Task</a></li>
            <li><a href="export-order.html">My Profile</a></li>
            <li><a href="export-order.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Add product Material</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="superaddmatirial.php" method="POST">
                
                <label for="sid">Stock ID</label>
                <input type="text" id="sid" name="sid" required>

                <label for="pmid">Product Material</label>
                <input type="text" id="pmid" name="pmid" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="location">Location</label>
                <input type="text" id="location" name="location" required>

                <label for="sdate">Stock Date</label>
                <input type="date" id="sdate" name="sdate" required>

                <label for="rsdate">Restock Date</label>
                <input type="date" id="rsdate" name="rsdate" required>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Active">Active</option>
                </select>

               

                <button type="submit">Submit </button>
            </form>
        </div>
    </main>
</body>
</html>
