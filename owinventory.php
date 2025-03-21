<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>incostreport</title>
    <link rel="stylesheet" href="inventorycostreport.css">
</head>
<body>
    <!-- Sidebar for navigation -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="pprocess.php">Production Process</a></li>
            <li><a href="viewcostreport1.html">Cost Report</a></li>
            <li><a href="gensalary.php">Generate Salary</a></li>
            <li><a href="Famakepay.php">Supplier Payment</a></li>
            <li><a href="salarystatus.php">Salary Status</a></li>
            <li><a href="generate-revenue.html">Generate Revenue</a></li>
            <li><a href="updatedelivery.php">Update Delivery</a></li>
            <li><a href="approve-request.html">Approve Request</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="stockstatus.html">Stock Status</a></li>
            <li><a href="performancereport1.html">Performance Report</a></li>
            <li><a href="assigntask.php">Assigning Task</a></li>
            <li><a href="importorder.php">Import Order</a></li>
            <li><a href="viewfeedback.php">Feedback</a></li>
            <li><a href="exportorder.php">Export Order</a></li>
            <li><a href="export-order.html">My Profile</a></li>
            <li><a href="export-order.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main content area -->
    <main>
        <h1 class="head">Inventory Cost Report</h1>

        <!-- Form for searching Member ID -->
        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input type="text" name="search" placeholder="Search Matirial  ID">
                <input type="submit" value="Search">
            </div>

            <!-- Table for displaying order details -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Material ID</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include('conf.php');

                // SQL query to fetch order details
                $sql = "SELECT * FROM incost";

                // If a search term is provided, filter the results
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE mid LIKE '%$searchTerm%'";
                }

                // Execute the query
                $result = $conn->query($sql);

                // Display the results in the table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["mid"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["amount"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found.</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
        </form>

       
    </main>
</body>
</html>
