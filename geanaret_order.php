<?php
include 'conf.php';

if (isset($_POST['order_id'])) {
    // If the order ID is set, update the order status to 'ready'
    $orderId = $_POST['order_id'];

    $sql = "UPDATE exortorder SET Status = 'ready' WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        echo "Order status updated to 'Ready'.";
    } else {
        echo "Error updating status.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit; // Stop further execution of the script
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="vieworder.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="reortdash.html">Production Report</a></li>
            <li><a href="addproduct.php">Generate Product</a></li>
            <li><a href="index.html">View Product</a></li>
            <li><a href="genpprocess.php">Production Process</a></li>
            <li><a href="viewpayPM.php">View Payment</a></li>
            <li><a href="generate_order.php">Generate Order</a></li>
            <li><a href="material.html">Material Status</a></li>
            <li><a href="dailyreortdash.html">Generate Daily Report</a></li>
            <li><a href="PMprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="head">View Export Orders</h1>

        <form id="searchForm" method="get" onsubmit="return validateForm()">
            <div>
                <input id="searchField" class="" type="text" name="search" placeholder="Search Tasks">
                <input type="submit" value="Search">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Country</th>
                        <th>Address</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Action</th> <!-- New column for the button -->
                    </tr>
                </thead>
                <tbody>
                <?php
                // Initialize base SQL query to select all tasks
                $sql = "SELECT * FROM exortorder WHERE Status = 'pending'";

                // Check if a search term is provided
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " AND order_id LIKE '%$searchTerm%'";
                }

                // Execute the query
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ($row["order_id"]) . "</td>";
                        echo "<td>" . ($row["order_date"]) . "</td>";
                        echo "<td>" . ($row["country"]) . "</td>";
                        echo "<td>" . ($row["address"]) . "</td>";
                        echo "<td>" . ($row["quantity"]) . "</td>";
                        echo "<td>" . ($row["amount"]) . "</td>";
                        echo "<td><button onclick='generateOrder(" . $row["order_id"] . ")'>Generate Order</button></td>"; // Add button with onclick event
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

    <script>
        // JavaScript validation for the form
        function validateForm() {
            const searchField = document.getElementById('searchField').value.trim();

            if (searchField === "") {
                alert("Please enter a search term before submitting.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        // Function to handle order generation and status update
        function generateOrder(orderId) {
            // Create a new XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            
            // Open a POST request to the current script (which handles both displaying and updating)
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Send the orderId as data to update the status
            xhr.send("order_id=" + orderId);

            // When the request is completed
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("Order ID: " + orderId + " status updated to 'Ready'.");
                    location.reload(); // Reload the page to reflect the changes
                } else {
                    alert("Failed to update the order status.");
                }
            };
        }
    </script>
</body>
</html>
