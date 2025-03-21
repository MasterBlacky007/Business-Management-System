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
    $sql = "SELECT * FROM salary WHERE stid = '$ato'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $errorMessage = "No salary found with: $ato";
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
    <link rel="stylesheet" href="empviewsalary.css">
    
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
            <h2>View Salary</h2>
            <form action="empviewsalary.php" method="POST">
                <label for="oid">Staff ID</label>
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
                            <th>Staff ID</th>
                            <th>Staff No</th>
                            <th>Name</th>
                            <th>Month</th>
                            <th>Basic Pay</th>
                            <th>OT</th>
                            <th>ETF</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Account Number</th>
                            <th>Status</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $row): ?>
                            <tr>
                                <td><?php echo $row['stid']; ?></td>
                                <td><?php echo $row['stno']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['month']; ?></td>
                                <td><?php echo $row['bpay']; ?></td>
                                <td><?php echo $row['ot']; ?></td>
                                <td><?php echo $row['etf']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['acc']; ?></td>
                                <td><?php echo $row['status']; ?></td>


                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
