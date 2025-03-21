<?php
// Include your database connection file
include 'conf.php'; // Ensure this contains the correct database connection

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST['OrderID'])) {
    $orderIdi = intval($_POST['OrderID']); // Ensure OrderID is treated as an integer

    try {
        // Prepare and execute the SQL statement to update the order status to 'ready'
        $sqli = "UPDATE lforder SET Payment = 'ready' WHERE OrderID = ?";
        $stmti = $conn->prepare($sqli);
        $stmti->bind_param("i", $orderIdi);

        if ($stmti->execute()) {
            header("Location: ?status=success");
        } else {
            header("Location: ?status=error");
        }

        $stmti->close();
    } catch (Exception $e) {
        // Log and display the error for debugging
        error_log("Error updating order: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    } finally {
        $conn->close();
        exit; // Stop further execution of the script
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foreign Client Orders</title>
    <link rel="stylesheet" href="generate.css">
    <script>
        // JavaScript validation for the search form
        function validateForm() {
            const searchField = document.getElementById('searchField').value.trim();
            if (searchField === "") {
                alert("Please enter a search term before submitting.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        // Display success or error message based on the URL parameter
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get("status");

            if (status === "success") {
                alert("Order status updated to 'Ready'.");
            } else if (status === "error") {
                alert("Error updating the order status.");
            }
        });
    </script>
</head>
<body>
    <main>
        <h2>Search Foreign Client Orders</h2>
        <div>
    <button onclick="window.location.href='generate_order.php';">Back</button>
</div>
        <form method="get" onsubmit="return validateForm();">
            <input type="text" id="searchField" name="search" placeholder="Search by Order ID" />
            <button type="submit">Search</button>
        </form>

        <h2>Foreign Client Table</h2>
        <table border="0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>ProductID</th>
                    <th>IIC</th>
                    <th>OrderDate</th>
                    <th>Quantity</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            try {
                // Query for Foreign Client orders with 'pending' payment status
                $sqlFC = "SELECT * FROM lforder WHERE Payment = 'pending'";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sqlFC .= " AND OrderID LIKE '%$searchTerm%'";
                }

                $resultFC = $conn->query($sqlFC);

                if ($resultFC->num_rows > 0) {
                    while ($row = $resultFC->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["OrderID"] . "</td>";
                        echo "<td>" . $row["ProductID"] . "</td>";
                        echo "<td>" . $row["IIC"] . "</td>";
                        echo "<td>" . $row["OrderDate"] . "</td>";
                        echo "<td>" . $row["Quantity"] . "</td>";
                        echo "<td>" . $row["Address"] . "</td>";
                        echo "<td>" . $row["Country"] . "</td>";
                        echo "<td>" . $row["Amount"] . "</td>";
                        echo "<td>
                                <form method='post' action=''>
                                    <button type='submit' name='OrderID' value='" . $row["OrderID"] . "'>Generate Order</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No foreign orders found.</td></tr>";
                }
            } catch (Exception $e) {
                echo "<tr><td colspan='9'>Error retrieving orders: " . $e->getMessage() . "</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </main>
</body>
</html>
