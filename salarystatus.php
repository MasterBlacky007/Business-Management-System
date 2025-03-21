<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Salary Status</title>
<link rel="stylesheet" href="salarystatus1.css">
<script>
    // JavaScript function to validate the search form
    function validateForm(event) {
        const searchInput = document.forms["order"]["search"].value;
        if (searchInput.trim() === "") {
            alert("Please enter a search term before submitting.");
            event.preventDefault(); // Prevent form submission
            return false;
        }
        return true;
    }
</script>
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
        <h1 class="head">Salary Status</h1>
        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input class="" type="text" name="search" placeholder="Search Staff ID">
                <input type="submit" value="Search">
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Salary ID</th>
                    <th>Staff ID</th>
                    <th>Staff No</th>
                    <th>Name</th>
                    <th>Month</th>
                    <th>Date</th>
                    <th>Account Number</th>
                    <th>Basic Pay</th>
                    <th>OT</th>
                    <th>ETF</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conf.php');

                // Start session to manage login state
                session_start();

                // Initialize base SQL query to select all records
                $sql = "SELECT * FROM salary";

                // Check if a search term is provided
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE StaffID LIKE '%$searchTerm%'";
                }

                // Execute the query
                $result = $conn->query($sql);

                // Display rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["SalaryID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["StaffID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["StaffNo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Month"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["AccountNumber"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["BasicPay"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["OT"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["ETF"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Amount"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Status"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No records found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <form action="salstatus.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <button type="submit" name="download_pdf">Download PDF</button>
        </form>

        
    </main>
</body>
</html>
