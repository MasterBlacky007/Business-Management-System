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
    $pid = $_POST['pid'];
    $quantity = $_POST['quantity'];
    $description = $_POST['discription'];
    $date = $_POST['date'];

    // Insert into the database
    $sql = "INSERT INTO pprocess (pid, quantity, discription, date) 
            VALUES ('$pid', '$quantity', '$description', '$date')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted ID
        $ppid = mysqli_insert_id($conn);
        $successMessage = "Record added successfully! Record ID: " . $ppid;

        // Display success message using JavaScript
        echo "<script>
                alert('Record added successfully! Record ID: " . $ppid . "');
                window.location.href = 'genpprocess.php'; // Redirect to a relevant page
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
    <title>Record Production Process</title>
    <link rel="stylesheet" href="empshiftrequest.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="reortdash.html">Production Report</a></li>
            <li><a href="addproduct.php">Generate Product</a></li>
            <li><a href="index.html">View Product</a></li>
            <li><a href="genpprocess.php">Production Process</a></li>
            <li><a href="viewpayPM.php">View Payment</a></li>
            <li><a href="generate_order.php">Generate Order</a></li>
            <li><a href="material.html">Material Status</a></li>
            <li><a href="dailyreortdash.html">Generate Daily Report</a></li>
            <li><a href="PMprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Production Process</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="genpprocess.php" method="POST">
                <label for="pid">Product ID</label>
                <input type="text" id="pid" name="pid" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="description">Description</label>
                <input type="text" id="discription" name="discription" required>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
