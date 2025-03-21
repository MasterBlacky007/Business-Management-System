<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Material Requests</title>
    <link rel="stylesheet" href="svieworder1.css">
</head>
<body>
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

    <main>
        <h1>View Material Requests</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by Request ID ">
            <input type="submit" value="Search">
        </form>

        <?php
        // Include the database configuration file
        include('conf.php'); // Make sure 'conf.php' contains valid DB connection details

        // Initialize a flag to determine whether to show the table
        $showTable = false;

        // Base SQL query to fetch all material requests
        $sql = "SELECT * FROM mrequest";

        // Check if the search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            $sql .= " WHERE rid LIKE '%$searchTerm%'"; // Filter results by `mid`
            $showTable = true; // Indicate that the table should be displayed
        }

        // Execute the SQL query
        $result = $conn->query($sql);
        ?>

        <!-- Only display the table if there are results -->
        <?php if ($showTable): ?>
            <table>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Date</th>
                        <th>Material ID</th>
                        <th>Quantity</th>
                        <th>Request Date</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if rows are returned
                    if ($result->num_rows > 0) {
                        // Fetch and display each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['rid']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['mid']}</td>";
                            echo "<td>{$row['quantity']}</td>";
                            echo "<td>{$row['rsdate']}</td>";
                            echo "<td>{$row['status']}</td>";

                            echo "</tr>";
                        }
                    } else {
                        // Display a message if no records are found
                        echo "<tr><td colspan='5'>No records found for the given Request ID.</td></tr>";
                    }
                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Show this message if no search has been performed -->
            <p>Please enter a Request ID to view material requests.</p>
        <?php endif; ?>
    </main>
</body>
</html>
