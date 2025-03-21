<?php
// Include database configuration
include 'conf.php';

// Check if OrderID is set in the POST request to update the order status
if (isset($_POST['OrderID'])) {
    $orderId = $_POST['OrderID'];

    // Prepare and execute the SQL statement to update the order status to 'ready'
    $sql = "UPDATE lcorder SET Payment = 'ready' WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        header("Location: ?status=success"); // Redirect with success status
    } else {
        header("Location: ?status=error"); // Redirect with error status
    }

    // Close the statement and exit
    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Client Orders</title>
    <link rel="stylesheet" href="generate.css">
    <script>
        // Display success or error message based on URL parameters
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get("status");

            if (status === "success") {
                alert("Order status updated to 'Ready'.");
            } else if (status === "error") {
                alert("Error updating the order status.");
            }
        });

        // JavaScript form validation for search functionality
        function validateSearchForm() {
            const searchField = document.getElementById('searchField').value.trim();

            if (searchField === "") {
                alert("Please enter a search term before submitting.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</head>
<body>
    <h1>Local Client Orders</h1>
  

    <div>
    <button onclick="window.location.href='generate_order.php';">Back</button>
</div>
    <!-- Search Form -->
    <form id="searchForm" method="get" onsubmit="return validateSearchForm()">
        <div>
            <input id="searchField" type="text" name="search" placeholder="Search by Order ID">
            <input type="submit" value="Search">
        </div>
    </form>

    <!-- Local Client Orders Table -->
    <h2>Local Client Table</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>NIC</th>
                <th>Order Date</th>
                <th>Quantity</th>
                <th>Address</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Query to retrieve Local Client orders with 'pending' payment status
        $sqlLC = "SELECT * FROM lcorder WHERE Payment = 'pending'";

        // Add search filter if a search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            $sqlLC .= " AND OrderID LIKE '%$searchTerm%'";
        }

        $resultLC = $conn->query($sqlLC);

        // Check if results are available
        if ($resultLC->num_rows > 0) {
            // Display each order as a table row
            while ($row = $resultLC->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["OrderID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["ProductID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["NIC"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["OrderDate"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Address"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Amount"]) . "</td>";
                echo "<td>
                        <form method='post' action=''>
                            <button type='submit' name='OrderID' value='" . htmlspecialchars($row["OrderID"]) . "'>Generate Order</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            // Display message if no orders are found
            echo "<tr><td colspan='8'>No local orders found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>

