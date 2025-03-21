<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenu</title>
    <link rel="stylesheet" href="genrevenu.css">
    <script>
        // JavaScript function to validate the search form
        function validateForm(event) {
            const searchInput = document.forms["order"]["search"].value;
            if (searchInput.trim() === "") {
                alert("Please enter a search month before submitting.");
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
            <li><a href="export-order.html">LogOut</a></li>
        </ul>
    </aside>

    <main>
        <h1 class="head">Revenu</h1>

        <!-- Search Form for Month -->
        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input type="month" name="search_month" placeholder="Search Month">
                <input type="submit" value="Search">
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Purchases</th>
                    <th>Total Sales</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('conf.php');

                // Start session to manage login state
                session_start();

                // Get the search month if it is provided
                $search_month = isset($_GET['search_month']) ? $_GET['search_month'] : '';

                // Query to get the total amount per month from the spayment table
                $sql_spayment = "
                    SELECT 
                        DATE_FORMAT(pdate, '%Y-%m') AS month,
                        SUM(amount) AS total_spayment
                    FROM spayment
                    WHERE DATE_FORMAT(pdate, '%Y-%m') LIKE '$search_month%'
                    GROUP BY month
                    ORDER BY month DESC
                ";

                // Query to get the total amount per month from the sale table
                $sql_sale = "
                    SELECT 
                        DATE_FORMAT(duration, '%Y-%m') AS month,
                        SUM(amount) AS total_sale
                    FROM sale
                    WHERE DATE_FORMAT(duration, '%Y-%m') LIKE '$search_month%'
                    GROUP BY month
                    ORDER BY month DESC
                ";

                // Execute the spayment query
                $result_spayment = $conn->query($sql_spayment);
                $result_sale = $conn->query($sql_sale);

                // Merge both results into a single array by month for display
                $spayment_data = [];
                while ($row = $result_spayment->fetch_assoc()) {
                    $spayment_data[$row['month']] = $row['total_spayment'];
                }

                $sale_data = [];
                while ($row = $result_sale->fetch_assoc()) {
                    $sale_data[$row['month']] = $row['total_sale'];
                }

                // Get all unique months from both tables
                $all_months = array_unique(array_merge(array_keys($spayment_data), array_keys($sale_data)));

                // Display the results and insert into revenu table only if not already inserted
                foreach ($all_months as $month) {
                    // Calculate total revenue (sales - purchases)
                    $total_revenue = (isset($sale_data[$month]) ? $sale_data[$month] : 0) - (isset($spayment_data[$month]) ? $spayment_data[$month] : 0);

                    // Display the data in the table
                    echo "<tr>";
                    echo "<td>" . $month . "</td>";
                    echo "<td>" . (isset($spayment_data[$month]) ? number_format($spayment_data[$month], 2) : '0.00') . "</td>";
                    echo "<td>" . (isset($sale_data[$month]) ? number_format($sale_data[$month], 2) : '0.00') . "</td>";
                    echo "<td>" . number_format($total_revenue, 2) . "</td>";
                    echo "</tr>";

                    // Check if the data for the current month already exists in the 'revenu' table
                    $sql_check_exists = "
                        SELECT COUNT(*) AS count
                        FROM revenu
                        WHERE month = '$month'
                    ";
                    $result_check = $conn->query($sql_check_exists);
                    $row_check = $result_check->fetch_assoc();

                    // If the data does not exist, insert it into the 'revenu' table
                    if ($row_check['count'] == 0) {
                        $sql_insert_revenu = "
                        INSERT INTO revenu (gdate, month, tpurchases, tsales, trevenu)
                        VALUES (CURRENT_TIMESTAMP, '$month-01', '" . (isset($spayment_data[$month]) ? $spayment_data[$month] : 0) . "', '" . (isset($sale_data[$month]) ? $sale_data[$month] : 0) . "', '$total_revenue')
                    ";
                    

                        // Execute the insert query
                        $conn->query($sql_insert_revenu);
                    }
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <form action="drevenu.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($_POST['report_id'] ?? ''); ?>">
            <input type="hidden" name="frequency" value="<?php echo htmlspecialchars($_POST['frequency'] ?? ''); ?>">
            <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>">
            <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>">
            <button type="submit" name="download_pdf">Download PDF</button>
        </form>
    </main>
</body>
</html>
