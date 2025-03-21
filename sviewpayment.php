<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize error and success message
$message = '';

// Check if a payment status update is being made
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status']) && isset($_POST['paymentID'])) {
    // Get the selected status and PaymentID from the form
    $status = $_POST['status'];
    $paymentID = $_POST['paymentID'];

    // Update the payment status in the database
    $sql = "UPDATE spayment SET Status = ? WHERE PaymentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $paymentID);
    
    if ($stmt->execute()) {
        $message = "Status updated successfully.";
    } else {
        $message = "Failed to update status.";
    }

    $stmt->close();
}

// Handle searching by SupplierID
$searchTerm = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $_GET['search'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="sviewp.css">
    <script>
        // JavaScript function to validate the search form
        function validateForm(event) {
            const searchInput = document.forms["order"]["search"].value;
            if (searchInput.trim() === "") {
                alert("Please enter a SupplierID to search.");
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
        <li><a href="supimportorder.php">Order</a></li>
            <li><a href="suppayment.html">Payment</a></li>
            <li><a href="supprofile.php">My Profile</a></li>
            <li><a href="suplogin.php">LogOut</a></li>
        </ul>
    </aside>
    
    <main>
        <h1 class="head">Payment</h1>

        <!-- Search for SupplierID -->
        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input type="text" name="search" placeholder="Search by SupplierID" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <input type="submit" value="Search">
            </div>
        </form>

        <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>

        <?php if (!empty($searchTerm)) { ?>
            <!-- Show table only when SupplierID is entered and searched -->
            <table>
                <thead>
                    <tr>
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
                    // SQL query to fetch data based on SupplierID
                    $searchTerm = $conn->real_escape_string($searchTerm);
                    $sql = "SELECT * FROM spayment WHERE SupplierID LIKE '%$searchTerm%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["SupplierID"] . "</td>";
                            echo "<td>" . $row["OrderID"] . "</td>";
                            echo "<td>" . $row["PaymentDate"] . "</td>";
                            echo "<td>" . $row["Currency"] . "</td>";
                            echo "<td>" . $row["Amount"] . "</td>";
                            echo "<td>" . $row["Method"] . "</td>";
                            echo "<td>" . ($row["Status"]) . "</td>";


                            // Form for updating the status, only shown when OrderID is provided
                           
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found for this SupplierID.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        <?php } ?>

    </main>
</body>
</html>