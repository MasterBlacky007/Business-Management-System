<?php
include('conf.php');

// Start session to manage login state
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Details</title>
    <link rel="stylesheet" href="ownersdetail.css">
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
        <li><a href="ownerexportorder.php">Export Order</a></li>
            <li><a href="owfinancial.html">Financial Report</a></li>
            <li><a href="ownerpayment.html">Payment Status</a></li>
            <li><a href="ownersdetail.php">Supplier Details</a></li>
            <li><a href="owmarequest.php">View Request</a></li>
            <li><a href="ownerassigntask.php">Assigning Task</a></li>
            <li><a href="ownerviewfeedback.php">Staff Performance</a></li>
            <li><a href="ownerviewfeedback.php">View Feedback</a></li>
            <li><a href="StDashboard.html">Logout</a></li>
        </ul>
    </aside>

    <main>
        <h1 class="head">Supplier Details</h1>

        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input type="text" name="search" placeholder="Search Supplier ID">
                <input type="submit" value="Search">
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>DOJ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Initialize base SQL query to select all suppliers
                $sql = "SELECT * FROM supregister";

                // Check if a search term is provided
                if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                    $searchTerm = $conn->real_escape_string(trim($_GET['search']));
                    $sql .= " WHERE suid LIKE '%$searchTerm%'";
                }

                // Execute the query and check for errors
                $result = $conn->query($sql);

                if (!$result) {
                    die("<tr><td colspan='6'>Query failed: " . $conn->error . "</td></tr>");
                }

                // Display results if there are any
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["SupplierID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["FullName"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Contact"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Address"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["DOJ"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No suppliers found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
