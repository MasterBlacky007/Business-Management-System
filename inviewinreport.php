<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory Report</title>
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
            <li><a href="ingenorder.html">Generate Order</a></li>
            <li><a href="invieworder.php">Import Order</a></li>
            <li><a href="imstock.html">Stock Status</a></li>
            <li><a href="Inventory.html">Inventory Report</a></li>
            <li><a href="Invpaymentstatus.php">Payment Status</a></li>
            <li><a href="invsdetail.php">Supplier Details</a></li>
            <li><a href="inviewtask.php">View Task</a></li>
            <li><a href="IMprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <main>
        <h1 class="head">Inventory Report</h1>

        <form name="order" method="get" onsubmit="return validateForm(event)">
            <div>
                <input class="" type="text" name="search" placeholder="Search by Product ID or Stock ID">
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
                </tr>
            </thead>
            <tbody>
            <?php
            include('conf.php');

            // Start session to manage login state
            session_start();

            // Initialize base SQL query to select all stock data
            $sql = "SELECT * FROM pstock";

            // Check if a search term is provided
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $searchTerm = $conn->real_escape_string($_GET['search']);
                $sql .= " WHERE sid LIKE '%$searchTerm%' OR pid LIKE '%$searchTerm%'";
            }

            // Execute the query
            $result = $conn->query($sql);

            // Check if query executed successfully
            if (!$result) {
                echo "<tr><td colspan='7'>Error: " . $conn->error . "</td></tr>";
                exit;
            }

            // Fetch and display the results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["sid"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["pid"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["sdate"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rsdate"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No stock found.</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </main>
</body>
</html>
