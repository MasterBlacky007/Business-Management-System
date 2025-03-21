<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Export Order Details</title>
<link rel="stylesheet" href="skpstock.css">
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
        <li><a href="skinventoryreport.html">Generate Inventory Report</a></li>
            <li><a href="skavailablestock.html">Available Stock</a></li>
            <li><a href="skstockstatus.html">Stock Status</a></li>
            <li><a href="skviewtask.php">View Task</a></li>
            <li><a href="export-order.html">My Profile</a></li>
            <li><a href="Home.html">LogOut</a></li>
        </ul>
    </aside>
     <main>
     <h1 class="head">Product Stock Status</h1>

<form name="order" method="get" onsubmit="return validateForm(event)">
    <div>
        <input class="" type="text" name="search" placeholder="Search Stock ID">
        <input type="submit" value="Search">
    </div>
</form>

<table>
    <thead>
        <tr>
            <th>Stock ID</th>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Location</th>
            <th>Status</th>
            <th>Stock Date</th>
            <th>Restock Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
   include('conf.php');

   // Start session to manage login state
   session_start();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $sid = $_POST['sid'];
    $newStatus = $_POST['status'];

    $updateSQL = "UPDATE pstock SET status='$newStatus' WHERE sid='$sid'";
    if ($conn->query($updateSQL) === TRUE) {
        echo "<script>alert('Status updated successfully!'); window.location.href='skpstock.php';</script>";
    } else {
        echo "<script>alert('Failed to update status. Please try again.');</script>";
    }
}

// Initialize base SQL query to select all tasks
$sql = "SELECT * FROM pstock";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE sid LIKE '%$searchTerm%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . ($row["sid"]) . "</td>";
        echo "<td>" . ($row["pid"]) . "</td>";
        echo "<td>" . ($row["quantity"]) . "</td>";
        echo "<td>" . ($row["location"]) . "</td>";
        echo "<td>" . ($row["status"]) . "</td>";
        echo "<td>" . ($row["sdate"]) . "</td>";
        echo "<td>" . ($row["rsdate"]) . "</td>";
        echo "<td>";
        echo "<form method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='sid' value='" . $row['sid'] . "'>";
        echo "<select name='status'>";
        echo "<option value='Pending'" . ($row['status'] === 'Pending' ? ' selected' : '') . ">Pending</option>";
        echo "<option value='Approved'" . ($row['status'] === 'Approved' ? ' selected' : '') . ">Approved</option>";
        echo "<option value='Rejected'" . ($row['status'] === 'Rejected' ? ' selected' : '') . ">Rejected</option>";
        echo "</select>";
        echo "<button type='submit' name='update_status'>Update</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No StockID found.</td></tr>";
}

$conn->close();
?>
    </tbody>
</table>
     </main>
</body>
</html>
