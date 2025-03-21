<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Order Details</title>
    <link rel="stylesheet" href="faimportorder.css">
</head>
<body>
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

    <main>
        <h1>Import Order</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by Order ID">
            <input type="submit" value="Search">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Supplier ID</th>
                    <th>Order Date</th>
                    <th>Request Date</th>
                    <th>Product Material</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conf.php');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['confirm'])) {
                        $orderId = $conn->real_escape_string($_POST['order_id']);
                        $updateQuery = "UPDATE genorder SET status='Transfered' WHERE oid='$orderId'";
                        $conn->query($updateQuery); // No alert, just update the status
                    }

                    if (isset($_POST['reject'])) {
                        $orderId = $conn->real_escape_string($_POST['order_id']);
                        $updateQuery = "UPDATE genorder SET status='Rejected' WHERE oid='$orderId'";
                        $conn->query($updateQuery); // No alert, just update the status
                    }
                }

                $sql = "SELECT * FROM genorder";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE oid LIKE '%$searchTerm%'";
                }

                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['oid']}</td>";
                        echo "<td>{$row['suid']}</td>";
                        echo "<td>{$row['odate']}</td>";
                        echo "<td>{$row['rdate']}</td>";
                        echo "<td>{$row['pmatirial']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='order_id' value='{$row['oid']}'>";
                        echo "<button type='submit' name='confirm' class='action-btn btn-confirm'>Transfer</button>";
                        echo "</form>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='order_id' value='{$row['oid']}'>";
                        echo "<button type='submit' name='reject' class='action-btn btn-reject'>Reject</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>