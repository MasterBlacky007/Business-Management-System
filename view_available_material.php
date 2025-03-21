<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Material</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <h1 class="head">Available Material</h1>

    <form method="get">
        <div>
            <input type="text" name="search" placeholder="Search Materials">
            <input type="submit" value="Search">
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Material ID</th>
                <th>Material Name</th>
                <th>Available Quantity</th>
                <th>Request Date</th>
                <th>Note</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include 'conf.php';

        // Initialize base SQL query
        $sql = "SELECT * FROM product_material";

        // Check if a search term is provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $conn->real_escape_string($_GET['search']);
            $sql .= " WHERE material_name LIKE '%$searchTerm%'";
        }

        // Execute the query
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["material_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["material_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["request_date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["note"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No materials found.</td></tr>";
            }
        } else {
            // Display the SQL error for debugging
            echo "<tr><td colspan='6'>Error: " . $conn->error . "</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
        </tbody>
    </table>
</body>
</html>
