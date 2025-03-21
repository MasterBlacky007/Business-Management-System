<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="ownerexportorder.css">
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
        <li><a href="viewoperations.html">View Operations</a></li>
            <li><a href="ownerexportorder.php">Export Order</a></li>
            <!--<li><a href="delivery-location.html">Delivery Location</a></li>-->
            <li><a href="owfinancial.html">Financial Report</a></li>
            <li><a href="ownerpayment.html">Payment Status</a></li>
            <li><a href="ownersdetail.php">Supplier Details</a></li>
            <li><a href="owmarequest.php">View Request</a></li>
            <li><a href="ownerassigntask.php">Assigning Task</a></li>
            <li><a href="ownerviewfeedback.php">Staff Performance</a></li>
            <li><a href="ownerviewfeedback.php">View Feedback</a></li>
            <!--<li><a href="Home.html">My Profile</a></li>-->
            <li><a href="StDashboard.html">Logout</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="head">View Export Orders</h1>

        <form id="searchForm" method="get" onsubmit="return validateForm()">
            <div>
                <input id="searchField" type="text" name="search" placeholder="Search Tasks">
                <input type="submit" value="Search">
            </div>

            <!-- First Table -->
            <h2>Local Client Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>ProductID</th>
                        <th>NIC</th>
                        <th>OrderDate</th>
                        <th>Quantity</th>
                        <th>Address</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include 'conf.php';

                // Query for Local Client orders
                $sqlLC = "SELECT * FROM lcorder";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sqlLC .= " WHERE OrderID LIKE '%$searchTerm%'";
                }

                $resultLC = $conn->query($sqlLC);

                if ($resultLC->num_rows > 0) {
                    while ($row = $resultLC->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["OrderID"] . "</td>";
                        echo "<td>" . $row["ProductID"] . "</td>";
                        echo "<td>" . $row["NIC"] . "</td>";
                        echo "<td>" . $row["OrderDate"] . "</td>";
                        echo "<td>" . $row["Quantity"] . "</td>";
                        echo "<td>" . $row["Address"] . "</td>";
                        echo "<td>" . $row["Amount"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No local orders found.</td></tr>";
                }
                ?>
                </tbody>
            </table>

            <!-- Second Table -->
            <h2>Foreign Client Table</h2>
            <table>
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
                    </tr>
                </thead>
                <tbody>
                <?php
                // Query for Foreign Client orders
                $sqlFC = "SELECT * FROM lforder";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sqlFC .= " WHERE OrderID LIKE '%$searchTerm%'";
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
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No foreign orders found.</td></tr>";
                }

                // Close the connection
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
    </script>
</body>
</html>
