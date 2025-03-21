<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supplier Payment Details</title>
    <link rel="stylesheet" href="ownersuppy.css">
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
     <h1 class="head">supplier Payment</h1>

<form name="order" method="get" onsubmit="return validateForm(event)">
    <div>
        <input class="" type="text" name="search" placeholder="Search SupplierID">
        <input type="submit" value="Search">
    </div>

<table>
    <thead>
        <tr>
            <th>Payment ID</th>
            <th>Supplier ID</th>
            <th>Order ID</th>
            <th>Payment Date</th>
            <th>Currency</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Status</th>

            
        </tr>
    </thead>
    <tbody>
    <?php
   include('conf.php');

   // Start session to manage login state
   session_start();

// Initialize base SQL query to select all tasks
$sql = "SELECT * FROM spayment";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
$searchTerm = $conn->real_escape_string($_GET['search']);
$sql .= " WHERE PaymentID LIKE '%$searchTerm%'";
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
    echo "<td>" . ($row["PaymentID"]) . "</td>";
    echo "<td>" . ($row["SupplierID"]) . "</td>";
    echo "<td>" . ($row["OrderID"]) . "</td>";
    echo "<td>" . ($row["PaymentDate"]) . "</td>";
    echo "<td>" . ($row["Currency"]) . "</td>";
    echo "<td>" . ($row["Amount"]) . "</td>";
    echo "<td>" . ($row["Method"]) . "</td>";
    echo "<td>" . ($row["Status"]) . "</td>";




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
