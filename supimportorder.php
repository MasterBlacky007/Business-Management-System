<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="svieworder1.css">
</head>
<body>
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
        <h1>Import Order</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by Supplier ID">
            <input type="submit" value="Search">
        </form>

        <?php
        include('conf.php');

        // Initialize the table visibility flag
        $showTable = false;

        // Modify the query to search by Supplier ID (suid)
        $sql = "SELECT * FROM genorder WHERE status IN ('Transfered', 'confirmed')"; 

        // Only run the search query if a search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            $sql .= " AND suid LIKE '%$searchTerm%'"; // Search by suid instead of oid
            $showTable = true;  // Show the table if search is performed
        }

        $result = $conn->query($sql);
        ?>

        <!-- Only show the table if there are results and search is performed -->
        <?php if ($showTable): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Supplier ID</th>
                        <th>Order Date</th>
                        <th>Request Date</th>
                        <th>Product Material</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['oid']}</td>";
                            echo "<td>{$row['suid']}</td>";
                            echo "<td>{$row['odate']}</td>";
                            echo "<td>{$row['rdate']}</td>";
                            echo "<td>{$row['pmatirial']}</td>";
                            echo "<td>{$row['quantity']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>";
                            echo "<form method='post' style='display:inline;'>";
                            echo "<input type='hidden' name='order_id' value='{$row['oid']}'>";
                            echo "<button type='submit' name='accept' class='btn-confirm'>Confirm</button>";
                            echo "</form>";
                            echo "<form method='post' style='display:inline;'>";
                            echo "<input type='hidden' name='order_id' value='{$row['oid']}'>";
                            echo "<button type='submit' name='cancel' class='btn-reject'>Cancel</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No confirmed orders found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>