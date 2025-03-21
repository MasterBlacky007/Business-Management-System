<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payment</title>
    <link rel="stylesheet" href="attendan.css">
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
        <h1 class="head">View Payment</h1>

        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input class="" type="text" name="search" placeholder="Search by Payment ID">
                <input type="submit" value="Search">
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Order ID</th>
                        <th>Payment Date</th>
                        <th>Payment Type</th>
                        <th>Payment Details</th>
                        <th>Amount</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('conf.php');

                    // Start session to manage login state
                    session_start();

                    // Initialize base SQL query to select all payments
                    $sql = "SELECT * FROM payments";

                    // Check if a search term is provided
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $searchTerm = $conn->real_escape_string($_GET['search']);
                        $sql .= " WHERE OrderID LIKE '%$searchTerm%'";
                    }

                    // Execute the query
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["PaymentID"] . "</td>";
                            echo "<td>" . $row["OrderID"] . "</td>";
                            echo "<td>" . $row["PaymentDate"] . "</td>";
                            echo "<td>" . $row["PaymentType"] . "</td>";
                            echo "<td>" . $row["PaymentDetails"] . "</td>";
                            echo "<td>" . $row["Amount"] . "</td>";
                            echo "<td>" . $row["CreatedAt"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No payments found.</td></tr>";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </form>
    </main>
</body>
</html>