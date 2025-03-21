<?php
// Include database connection
include('conf.php');

// Handle cancellation of a shift
if (isset($_GET['cancel_id'])) {
    $cancelId = $_GET['cancel_id'];
    $updateSql = "UPDATE shift SET status = 'cancel' WHERE shid = $cancelId";
    mysqli_query($conn, $updateSql);
    header('Location: superviewshiftchange.php');
    exit;
}

// Handle approval of a shift
if (isset($_GET['approve_id'])) {
    $approveId = $_GET['approve_id'];
    $updateSql = "UPDATE shift SET status = 'approve' WHERE shid = $approveId";
    mysqli_query($conn, $updateSql);
    header('Location: superviewshiftchange.php');
    exit;
}

// Fetch all shifts from the database
$sql = "SELECT shid, eno, date, stime, etime, status FROM shift";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching shifts: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shifts</title>
    <link rel="stylesheet" href="superviewshiftchange.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="superviewshiftchange.php">Shift Changes</a></li>
            <li><a href="supermatirial.html">Material Status</a></li>
            <li><a href="supemarequest.html">Material Request</a></li>
            <li><a href="superassigntask.php">Assign Task</a></li>
            <li><a href="supedailyreport.html">Daily Report</a></li>
            <li><a href="superviewtask.php">View Task</a></li>
            <li><a href="SPprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Shift Details</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Shift ID</th>
                        <th>Employee No</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['shid']; ?></td>
                            <td><?php echo $row['eno']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['stime']; ?></td>
                            <td><?php echo $row['etime']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="superviewshiftchange.php?approve_id=<?php echo $row['shid']; ?>">
                                    <button class="approve">Approve</button>
                                </a>
                                <a href="superviewshiftchange.php?cancel_id=<?php echo $row['shid']; ?>">
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