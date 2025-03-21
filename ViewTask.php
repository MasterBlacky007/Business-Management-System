<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <link rel="stylesheet" href="viewtk.css">
</head>
<body>
     <!-- Sidebar -->
     <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="view_exprot_order.php">Export Order</a></li>
            <li><a href="transprot_availabal_dash.html">Available Driver</a></li>
            <li><a href="driver.html">Driver Details</a></li>
            <!--<li><a href="generate-salary.html">Track Driver</a></li>-->
            <li><a href="reportdash1.html">Transport Report</a></li>
            <li><a href="status_transport.html">Transport Status</a></li>
            <li><a href="ViewTask.php">View Task</a></li>
            <li><a href="TMprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside> <!-- Main Content -->
    <main>
    <h1 class="head">View Tasks</h1>

<form method="get">
    <div><input class="" type="text" name="search" placeholder="Search Tasks">
    <input  type="submit" value="Search">
</div>
    
    


<table>
    <thead>
        <tr>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Description</th>
            <th>Assign By</th>
            <th>Assign To</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
include 'conf.php';

// Initialize base SQL query to select all tasks
$sql = "SELECT * FROM task";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
$searchTerm = $conn->real_escape_string($_GET['search']);
$sql .= " WHERE taskid LIKE '%$searchTerm%'";
}

// Check if the "show closed" filter is set
if (isset($_GET['show_closed'])) {
if (!empty($sql)) {
    $sql .= " OR ";
} else {
    $sql .= " WHERE ";
}
$sql .= "status = 'Closed'";
}

// Execute the query
$result = $conn->query($sql);

// ... (rest of your code to display the table rows)

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . ($row["taskid"]) . "</td>";
    echo "<td>" . ($row["taskname"]) . "</td>";
    echo "<td>" . ($row["discription"]) . "</td>";
    echo "<td>" . ($row["assignby"]) . "</td>";
    echo "<td>" . ($row["assignto"]) . "</td>";
    echo "<td>" . ($row["startdate"]) . "</td>";
    echo "<td>" . ($row["enddate"]) . "</td>";
    echo "<td>" . ($row["sstatus"]) . "</td>";
    echo "</tr>";
}
} else {
echo "<tr><td colspan='7'>No tasks found.</td></tr>";
}

$conn->close();
?>



    </tbody>
</table>
</form>
    </main>

    
</body>
</html>