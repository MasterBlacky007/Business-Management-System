<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>performance Details</title>
    <link rel="stylesheet" href="ownerpofermance.css">
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
        <li><a href="Home.html">View Operations</a></li>
        <li><a href="Home.html">View Operations</a></li>
            <li><a href="ownerexportorder.php">Export Order</a></li>
            <li><a href="delivery-location.html">Delivery Location</a></li>
            <li><a href="#">Financial Report</a></li>
            <li><a href="ownerpayment.html">Payment Status</a></li>
            
           
            <li><a href="ownersdetail.php">Supplier Details</a></li>
            <li><a href="#">View Request</a></li>
            <li><a href="ownerassigntask.php">Assigning Task</a></li>
            <li><a href="ownerviewfeedback.php">Staff Performance</a></li>
            <li><a href="ownerviewfeedback.php">View Feedback</a></li>
            <li><a href="Home.html">My Profile</a></li>
            <li><a href="Home.html">Logout</a></li>
        </ul>
    </aside>
     <main>
     <h1 class="head">Performance</h1>

<form name="order" method="get" onsubmit="return validateForm(event)">
    <div>
        <input class="" type="text" name="search" placeholder="Search employeeno">
        <input type="submit" value="Search">
    </div>

<table>
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
   session_start();

// Initialize base SQL query to select all tasks
$sql = "SELECT * FROM eperformance";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
$searchTerm = $conn->real_escape_string($_GET['search']);
$sql .= " WHERE eno LIKE '%$searchTerm%'";
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

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . ($row["eno"]) . "</td>";
    echo "<td>" . ($row["jrole"]) . "</td>";
    echo "<td>" . ($row["skill"]) . "</td>";
    

    echo "</tr>";
}
} else {
echo "<tr><td colspan='7'>No exportorder found.</td></tr>";
}

$conn->close();
?>
    </tbody>
</table>
</form>
     </main>
</body>
</html>
