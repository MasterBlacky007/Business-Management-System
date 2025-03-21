<?php
// Include database connection
include('conf.php');

// Handle cancellation of a material request
if (isset($_GET['cancel_id'])) {
    $cancelId = $_GET['cancel_id'];
    $updateSql = "UPDATE mrequest SET status = 'cancel' WHERE rid = $cancelId";
    mysqli_query($conn, $updateSql);
    header('Location: owmarequest.php');
    exit;
}

// Fetch all material requests from the database
$sql = "SELECT rid, date, mid, quantity, rsdate, status FROM mrequest";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching material requests: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Material Requests</title>
    <link rel="stylesheet" href="superviewshiftchange1.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="viewoperations.html">View Operations</a></li>
            <li><a href="ownerexportorder.php">Export Order</a></li>
            <!--<li><a href="delivery-location.html">Delivery Location</a></li>-->
            <li><a href="owfinancial.html">Financial Report</a></li>
            <li><a href="ownerpayment.html">Payment Status</a></li>
            
           
            <li><a href="ownersdetail.php">Supplier Details</a></li>
            <li><a href="owmarequest.php">View Request</a></li>
            <li><a href="ownerassigntask.php">Assigning Task</a></li>
            <li><a href="ownerviewfeedback.php">Staff Performance</a></li>
            <li><a href="ownerviewfeedback.php">View Feedback</a></li>
            <!--<li><a href="Home.html">My Profile</a></li>-->
            <li><a href="StDashboard.html">Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Material Request </h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Material ID</th>
                        <th>Quantity</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['rid']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['mid']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['rsdate']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="owmarequest.php?cancel_id=<?php echo $row['rid']; ?>">
                                    <button class="cancel">Cancel</button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
