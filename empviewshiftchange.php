<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shift Change</title>
    <link rel="stylesheet" href="svieworder1.css">
</head>
<body>
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

    <main>
        <h1>View Shift Change</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by Employee Number (eno)">
            <input type="submit" value="Search">
        </form>

        <?php
        // Include the database configuration file
        include('conf.php'); // Make sure 'conf.php' contains valid DB connection details

        // Initialize a flag to determine whether to show the table
        $showTable = false;

        // Base SQL query to fetch all shift changes
        $sql = "SELECT * FROM shift";

        // Check if the search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            $sql .= " WHERE eno LIKE '%$searchTerm%'"; // Filter results by `eno`
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
                        <th>Shift ID</th>
                        <th>Employee Number</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
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
                            echo "<td>{$row['shid']}</td>";
                            echo "<td>{$row['eno']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['stime']}</td>";
                            echo "<td>{$row['etime']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Display a message if no records are found
                        echo "<tr><td colspan='6'>No records found for the given Employee Number.</td></tr>";
                    }
                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Show this message if no search has been performed -->
            <p>Please enter an Employee Number to view shift changes.</p>
        <?php endif; ?>
    </main>
</body>
</html>
