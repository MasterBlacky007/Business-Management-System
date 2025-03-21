<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="Invpaymentstatus.css">
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
        <li><a href="ingenorder.html">Generate Order</a></li>
            <li><a href="invieworder.php">Import Order</a></li>
            <li><a href="imstock.html">Stock Status</a></li>
            <li><a href="Inventory.html">Inventory Report</a></li>
            <li><a href="Invpaymentstatus.php">Payment Status</a></li>
            <!--<li><a href="production-process.html">Stock Status</a></li>-->
            <li><a href="invsdetail.php">Supplier Details</a></li>
            <li><a href="inviewtask.php">View Task</a></li>
            <li><a href="IMprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>
     <main>
     <h1 class="head">Payment</h1>

<form name="order" method="get" onsubmit="return validateForm(event)">
    <div>
        <input class="" type="text" name="search" placeholder="Search SupplierID">
        <input type="submit" value="Search">
    </div>

<table>
    <thead>
        <tr>
            <th>Supplier ID</th>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Order Amount</th>

            
        </tr>
    </thead>
    <tbody>
    <?php
   include('conf.php');

   // Start session to manage login state
   session_start();

// Initialize base SQL query to select all tasks
$sql = "SELECT * FROM sgenpay";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
$searchTerm = $conn->real_escape_string($_GET['search']);
$sql .= " WHERE SupplierID  LIKE '%$searchTerm%'";
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
    echo "<td>" . ($row["SupplierID"]) . "</td>";
    echo "<td>" . ($row["OrderID"]) . "</td>";
    echo "<td>" . ($row["OrderDate"]) . "</td>";
    echo "<td>" . ($row["Quantity"]) . "</td>";
    echo "<td>" . ($row["Price"]) . "</td>";
    echo "<td>" . ($row["OrderAmount"]) . "</td>";



    echo "</tr>";
}
} else {
echo "<tr><td colspan='7'>No supplierID found.</td></tr>";
}

$conn->close();
?>
    </tbody>
</table>
</form>
     </main>
</body>
</html>
