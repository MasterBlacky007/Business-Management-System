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
    $date = $_POST['date'];
    $mid = $_POST['mid'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $amount = $quantity * $price; // Calculate total amount

    // Insert into the database
    $sql = "INSERT INTO incost (date, mid, quantity, price, amount) 
            VALUES ('$date', '$mid', '$quantity', '$price', '$amount')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted ID
        $incostID = mysqli_insert_id($conn);
        $successMessage = "Record added successfully! Record ID: " . $incostID;

        // Display success message using JavaScript
        echo "<script>
                alert('Record added successfully! Record ID: " . $incostID . "');
                window.location.href = 'inincost.php'; // Redirect to a relevant page
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

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Material Cost</title>
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
            <h2>Inventory Cost</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="inincost.php" method="POST">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <label for="mid">Material ID</label>
                <input type="text" id="mid" name="mid" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="price">Price per Unit</label>
                <input type="number" id="price" name="price" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
