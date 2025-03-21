<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Export Order Details</title>
<link rel="stylesheet" href="facviewpay.css">
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
<style>
.viewButton, .payButton {
    display: inline-block;
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-right: 5px;
}

.payButton {
    background-color: #2196F3;
}

.viewButton:hover, .payButton:hover {
    opacity: 0.8;
}
</style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo">Dashboard</div>
    <ul class="menu">
    <li><a href="pprocess.php">Production Process</a></li>
            <li><a href="viewcostreport1.html">Cost Report</a></li>
            <li><a href="gensalary.php">Generate Salary</a></li>
            <li><a href="facviewpay.php">Supplier Payment</a></li>
            <li><a href="salarystatus.php">Salary Status</a></li>
            <li><a href="grevenue.php">Generate Revenue</a></li>
            <li><a href="updatedelivery.php">Update Delivery</a></li>
            <li><a href="facmaapprove.php">Approve Request</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="stockstatus.html">Stock Status</a></li>
            <li><a href="performancereport.html">Performance Report</a></li>
            <li><a href="assign-task.html">Assigning Task</a></li>
            <li><a href="faimportorder.php">Import Order</a></li>
            <li><a href="viewfeedback.php">Feedback</a></li>
            <li><a href="facexportorder.html">Export Order</a></li>
            <li><a href="profile.html">My Profile</a></li>
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
                <th>Payment</th>
                <th>Action</th>
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
            $sql .= " WHERE SupplierID LIKE '%$searchTerm%'";
        }

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orderId = $row['OrderID'];  // assuming OrderID exists in the sgenpay table
                echo "<tr>";
                echo "<td>" . ($row["SupplierID"]) . "</td>";
                echo "<td>" . ($row["OrderID"]) . "</td>";
                echo "<td>" . ($row["OrderDate"]) . "</td>";
                echo "<td>" . ($row["Quantity"]) . "</td>";
                echo "<td>" . ($row["Price"]) . "</td>";
                echo "<td>" . ($row["OrderAmount"]) . "</td>";
                echo "<td>" . ($row["Status"]) . "</td>";
                echo "<td>
                        <a href='sinvoice.php?orderId={$orderId}' class='viewButton'>View</a>
                        <a href='spay.php?orderId={$orderId}' class='payButton'>Pay</a>
                      </td>";
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
