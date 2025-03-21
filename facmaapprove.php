<?php
// Include database connection
include('conf.php');

// Handle cancellation of a material request
if (isset($_GET['cancel_id'])) {
    $cancelId = $_GET['cancel_id'];
    $updateSql = "UPDATE mrequest SET status = 'cancel' WHERE rid = $cancelId";
    mysqli_query($conn, $updateSql);
    header('Location: facmaapprove.php');
    exit;
}

// Handle approval of a material request
if (isset($_GET['approve_id'])) {
    $approveId = $_GET['approve_id'];
    $updateSql = "UPDATE mrequest SET status = 'approve' WHERE rid = $approveId";
    mysqli_query($conn, $updateSql);
    header('Location: facmaapprove.php');
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
    <link rel="stylesheet" href="superviewshiftchange.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="pprocess.php">Production Process</a></li>
            <li><a href="viewcostreport1.html">Cost Report</a></li>
            <li><a href="gensalary.php">Generate Salary</a></li>
            <li><a href="facviewpay.php">Supplier Payment</a></li>
            <li><a href="salarystatus.php">Salary Status</a></li>
            <li><a href="grevenue.php">Generate Revenue</a></li>
            <li><a href="updatedelivery.php">Update Delivery</a></li>
            <li><a href="facmaapprove.php">Approve Request</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="stockstatus.html">Stock Status</a></li>
            <li><a href="performancereport.html">Performance Report</a></li>
            <li><a href="assign-task.html">Assigning Task</a></li>
            <li><a href="faimportorder.php">Import Order</a></li>
            <li><a href="viewfeedback.php">Feedback</a></li>
            <li><a href="facexportorder.html">Export Order</a></li>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
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
                                <a href="facmaapprove.php?approve_id=<?php echo $row['rid']; ?>">
                                    <button class="approve">Approve</button>
                                </a>
                                <a href="facmaapprove.php?cancel_id=<?php echo $row['rid']; ?>">
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
