<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize variables
$searchResults = [];
$errorMessage = "";

// Handle search functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $ato = $_POST['oid'];

    // Search for the order by Order ID
    $sql = "SELECT * FROM task WHERE assignto = '$ato'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $errorMessage = "No order found with: $ato";
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
    <title>View Order</title>
    <link rel="stylesheet" href="empviewtask.css">
    
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="empshiftchange.html">Shift Changes</a></li>
            <li><a href="empviewsalary.php">Salary</a></li>
            <li><a href="empaddperformance.php">Performance</a></li>
            <li><a href="empdailyreport.php">Daily Report</a></li>
            <li><a href="empviewtask.php">View Task</a></li>
            <li><a href="Eprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>View Task</h2>
            <form action="empviewtask.php" method="POST">
                <label for="oid">Assignto</label>
                <input type="text" id="oid" name="oid" required>
                <button type="submit" name="search">Search</button>
            </form>

            <?php if ($errorMessage): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <?php if (!empty($searchResults)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Discription</th>
                            <th>Assignby</th>
                            <th>Assignto</th>
                            <th>Startdate</th>
                            <th>Enddate</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $row): ?>
                            <tr>
                                <td><?php echo $row['taskid']; ?></td>
                                <td><?php echo $row['taskname']; ?></td>
                                <td><?php echo $row['discription']; ?></td>
                                <td><?php echo $row['assignby']; ?></td>
                                <td><?php echo $row['assignto']; ?></td>
                                <td><?php echo $row['startdate']; ?></td>
                                <td><?php echo $row['enddate']; ?></td>
                                <td><?php echo $row['sstatus']; ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
