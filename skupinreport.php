<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize variables
$successMessage = "";
$stockData = null;

// Handle search form submission
if (isset($_POST['search'])) {
    $stockID = $_POST['stockid'];

    // Fetch stock data from the database
    $sql = "SELECT * FROM stock WHERE ID = '$stockID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $stockData = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Stock not found. Please try again.');</script>";
    }
}

// Handle update form submission
if (isset($_POST['update'])) {
    $stockID = $_POST['stockid'];
    $pid = $_POST['pid'];
    $mid = $_POST['mid'];
    $pinstock = $_POST['pinstock'];
    $minstock = $_POST['minstock'];
    $poutstock = $_POST['poutstock'];
    $moutstock = $_POST['moutstock'];

    // Update the stock in the database
    $sql = "UPDATE stock SET Pid = '$pid', mid = '$mid', pinstock = '$pinstock', minstock = '$minstock', poutstock = '$poutstock', moutstock = '$moutstock' WHERE ID = '$stockID'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Stock updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update stock. Please try again.');</script>";
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
    <title>Update Stock</title>
    <link rel="stylesheet" href="skupinreport.css">
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
            <h2>Update Inventory</h2>

            <!-- Search Form -->
            <form action="skupinreport.php" method="POST">
                <label for="stockid">Inventory ID</label>
                <input type="text" id="stockid" name="stockid" required value="<?php echo isset($stockData['ID']) ? $stockData['ID'] : ''; ?>">
                <button type="submit" name="search">Search</button>
            </form>

            <!-- Update Form -->
            <?php if ($stockData): ?>
                <form action="skupinreport.php" method="POST">
                    <input type="hidden" name="stockid" value="<?php echo $stockData['ID']; ?>">

                    <!-- Product ID and In/Out Stock -->
                    <div class="form-group">
                        <label for="pid">Product ID</label>
                        <input type="text" id="pid" name="pid" required value="<?php echo $stockData['Pid']; ?>">

                        <label for="pinstock">Product In Stock</label>
                        <input type="number" id="pinstock" name="pinstock" required value="<?php echo $stockData['pinstock']; ?>">

                        <label for="poutstock">Product Out Stock</label>
                        <input type="number" id="poutstock" name="poutstock" required value="<?php echo $stockData['poutstock']; ?>">
                    </div>

                    <!-- Material ID and In/Out Stock -->
                    <div class="form-group">
                        <label for="mid">Material ID</label>
                        <input type="text" id="mid" name="mid" required value="<?php echo $stockData['mid']; ?>">

                        <label for="minstock">Material In Stock</label>
                        <input type="number" id="minstock" name="minstock" required value="<?php echo $stockData['minstock']; ?>">

                        <label for="moutstock">Material Out Stock</label>
                        <input type="number" id="moutstock" name="moutstock" required value="<?php echo $stockData['moutstock']; ?>">
                    </div>

                    <button type="submit" name="update">Update Inventory</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
