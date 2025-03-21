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
    $pid = $_POST['pid'];        // Product ID (Pid)
    $mid = $_POST['mid'];        // Manager ID (mid)
    $pinstock = $_POST['pinstock'];  // Product in stock (pinstock)
    $minstock = $_POST['minstock'];  // Minimum stock (minstock)
    $poutstock = $_POST['poutstock']; // Product out stock (poutstock)
    $moutstock = $_POST['moutstock']; // Manager out stock (moutstock)

    // Insert into the database
    $sql = "INSERT INTO stock (Pid, mid, pinstock, minstock, poutstock, moutstock) 
            VALUES ('$pid', '$mid', '$pinstock', '$minstock', '$poutstock', '$moutstock')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted task ID
        $taskID = mysqli_insert_id($conn);
        $successMessage = "Stock updated successfully! Stock ID: " . $taskID;

        // Display success message using JavaScript
        echo "<script>
                alert('Stock updated successfully! Stock ID: " . $taskID . "');
                window.location.href = 'skinventoryreport.php'; // Optional: reload the page after showing message
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        
        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to update stock. Please try again.');
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
    <title>Create Inventory</title>
    <link rel="stylesheet" href="skinventoryreport1.css">

</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="skinreport.html">Generate Inventory Report</a></li>
            <li><a href="skavailablestock.html">Available Stock</a></li>
            <li><a href="skstockstatus.html">Stock Status</a></li>
            <li><a href="skviewtask.php">View Task</a></li>
            <li><a href="STprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Create Inventory</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="skinventoryreport.php" method="POST">
                <div class="form-group">
                    <label for="pid">Product ID</label>
                    <input type="text" id="pid" name="pid" required>
                    <label for="pinstock">Product In Stock</label>
                    <input type="number" id="pinstock" name="pinstock" required>
                    <label for="poutstock">Product Out Stock</label>
                    <input type="number" id="poutstock" name="poutstock" required>
                </div>
                <div class="form-group">
                    <label for="mid">Material ID</label>
                    <input type="text" id="mid" name="mid" required>
                    <label for="minstock">Material In Stock</label>
                    <input type="number" id="minstock" name="minstock" required>
                    <label for="moutstock">Material Out Stock</label>
                    <input type="number" id="moutstock" name="moutstock" required>
                </div>
                <div class="form-group">
                    <button type="submit">Submit Inventory</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
