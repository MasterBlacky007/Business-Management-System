<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stock Details</title>
<link rel="stylesheet" href="salarystatus1.css">
<script>
// JavaScript function to validate the search form
function validateForm(event) {
    const searchInput = document.forms["stock"]["search"].value;
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
    <h1 class="head">Stock Details</h1>

    <form name="stock" method="get" onsubmit="return validateForm(event)">
        <div>
            <input type="text" name="search" placeholder="Search by Product ID">
            <input type="submit" value="Search">
        </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Material ID</th>
                <th>Product ID</th>
                <th>Material Stock</th>
                <th>Product Stock</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include('conf.php');

        // Start session to manage login state
        session_start();

        // Base SQL query to select all records from edaily table
        $sql = "SELECT * FROM edaily";

        // Check if a search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            $sql .= " WHERE pid LIKE '%$searchTerm%'";
        }

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["mid"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["pid"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["mstock"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["pstock"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No stock found.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
    </form>
    <form action="supdailyreport.php" method="POST">
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
