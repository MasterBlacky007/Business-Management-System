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
    $stockID = $_POST['sid'];

    // Fetch stock data from the database
    $sql = "SELECT * FROM pmstock WHERE sid = '$stockID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $stockData = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Stock not found. Please try again.');</script>";
    }
}

// Handle update form submission
if (isset($_POST['update'])) {
    $stockID = $_POST['sid'];
    $pmid = $_POST['pmid'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $sdate = $_POST['sdate'];
    $rsdate = $_POST['rsdate'];

    // Update the stock in the database
    $sql = "UPDATE pmstock SET pmid = '$pmid', quantity = '$quantity', location = '$location', 
            status = '$status', sdate = '$sdate', rsdate = '$rsdate' WHERE sid = '$stockID'";

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
    <link rel="stylesheet" href="superupdatematirial.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="superviewshiftchange.php">Shift Changes</a></li>
            <li><a href="supermatirial.html">Material Status</a></li>
            <li><a href="superassigntask.php">Assign Task</a></li>
            <li><a href="supedailyreport.html">Daily Report</a></li>
            <li><a href="superviewtask.php">View Task</a></li>
            <li><a href="export-order.html">My Profile</a></li>
            <li><a href="Home.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Update Stock</h2>

            <!-- Search Form -->
            <form action="superupdatematirial.php" method="POST">
                <label for="sid">Stock ID</label>
                <input type="text" id="sid" name="sid" required value="<?php echo isset($stockData['sid']) ? $stockData['sid'] : ''; ?>">
                <button type="submit" name="search">Search</button>
            </form>

            <!-- Update Form -->
            <?php if ($stockData): ?>
                <form action="superupdatematirial.php" method="POST">
                    <input type="hidden" name="sid" value="<?php echo $stockData['sid']; ?>">

                    <label for="pmid">Product Material ID</label>
                    <input type="text" id="pmid" name="pmid" required value="<?php echo $stockData['pmid']; ?>">

                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required value="<?php echo $stockData['quantity']; ?>">

                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" required value="<?php echo $stockData['location']; ?>">

                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Pending" <?php echo ($stockData['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Active" <?php echo ($stockData['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    </select>

                    <label for="sdate">Stock Date</label>
                    <input type="date" id="sdate" name="sdate" required value="<?php echo $stockData['sdate']; ?>">

                    <label for="rsdate">Restock Date</label>
                    <input type="date" id="rsdate" name="rsdate" required value="<?php echo $stockData['rsdate']; ?>">

                    <button type="submit" name="update">Update Stock</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
