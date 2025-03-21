<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="importorder1.css">
   
</head>
<body>
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="pprocess.php">Production Process</a></li>
            <li><a href="viewcostreport1.html">Cost Report</a></li>
            <li><a href="gensalary.php">Generate Salary</a></li>
            <li><a href="facpayment.html">Supplier Payment</a></li>
            <li><a href="salarystatus.php">Salary Status</a></li>
            <li><a href="generate-revenue.html">Generate Revenue</a></li>
            <li><a href="updatedelivery.php">Update Delivery</a></li>
            <li><a href="approve-request.html">Approve Request</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="stockstatus.html">Stock Status</a></li>
            <li><a href="performancereport.html">Performance Report</a></li>
            <li><a href="assigntask.php">Assigning Task</a></li>
            <li><a href="faimportorder.php">Import Order</a></li>
            <li><a href="viewfeedback.php">Feedback</a></li>
            <li><a href="facexportorder.html">Export Order</a></li>
            <li><a href="export-order.html">My Profile</a></li>
            <li><a href="Home.html">LogOut</a></li>
        </ul>
    </aside>

    <main>
        <h1>Import Order </h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by Order ID">
            <input type="submit" value="Search">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Address</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conf.php');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['confirm'])) {
                        $orderId = $conn->real_escape_string($_POST['order_id']);
                        // Confirm action - no changes needed for now
                        echo "<script>alert('Order $orderId confirmed.');</script>";
                    }

                    if (isset($_POST['reject'])) {
                        $orderId = $conn->real_escape_string($_POST['order_id']);
                        $deleteQuery = "DELETE FROM addorder WHERE orderid='$orderId'";
                        if ($conn->query($deleteQuery)) {
                            echo "<script>alert('Order $orderId rejected and removed.');</script>";
                        } else {
                            echo "<script>alert('Error rejecting order $orderId.');</script>";
                        }
                    }
                }

                $sql = "SELECT * FROM addorder";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE orderid LIKE '%$searchTerm%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['orderid']}</td>";
                        echo "<td>{$row['productid']}</td>";
                        echo "<td>{$row['orderdate']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>{$row['daddress']}</td>";
                        echo "<td>{$row['amount']}</td>";
                        echo "<td>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='order_id' value='{$row['orderid']}'>";
                        echo "<button type='submit' name='confirm' class='action-btn btn-confirm'>Confirm</button>";
                        echo "</form>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='order_id' value='{$row['orderid']}'>";
                        echo "<button type='submit' name='reject' class='action-btn btn-reject'>Reject</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
