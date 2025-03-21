



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payment</title>
    <link rel="stylesheet" href="perfomreport.css">
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

        // JavaScript function to trigger print dialog
        function printTable() {
            const printContents = document.querySelector('table').outerHTML;
            const originalContents = document.body.innerHTML;

            // Create a temporary window for printing
            document.body.innerHTML = `
                <html>
                    <head>
                        <title>Print Table</title>
                        <style>
                            table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            th, td {
                                border: 1px solid #000;
                                padding: 8px;
                                text-align: left;
                            }
                            th {
                                background-color: #f2f2f2;
                            }
                        </style>
                    </head>
                    <body>
                        <h1>Performance Report</h1>
                        ${printContents}
                    </body>
                </html>
            `;
            window.print();

            // Restore original page contents
            document.body.innerHTML = originalContents;
            location.reload(); // Reload the page to restore JavaScript functionality
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
            <li><a href="Home.html">LogOut</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="head">Payment</h1>

        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input type="text" name="search" placeholder="Search SupplierID">
                <input type="submit" value="Search">
            </div>

            <table border="1">
                <thead>
                    <tr>
                        <th>Employee No</th>
                        <th>Job role</th>
                        <th>Skill</th>
                      
                    </tr>
                </thead>
                <tbody>
                <?php
                include('conf.php');

                // Start session to manage login state
                

                // Initialize base SQL query to select all tasks
                $sql = "SELECT * FROM eperformance";

                // Check if a search term is provided
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE eno LIKE '%$searchTerm%'";
                }

                // Execute the query
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["eno"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["jrole"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["skill"]) . "</td>";
                        

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No Supplier ID found.</td></tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
        </form>
        <button onclick="printTable()">Print</button>
    </main>
</body>
</html>
