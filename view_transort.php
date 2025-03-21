<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Details</title>
    <link rel="stylesheet" href="viewstyle.css">
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <h1 class="head">View Transport Details</h1>

    <form method="get" onsubmit="return validateSearch()">
        <div>
            <input class="" type="text" id="search" name="search" placeholder="Search Tasks">
            <input type="submit" value="Search">
        </div>
        <span class="error" id="searchError"></span>

        <table>
            <thead>
                <tr>
                    <th>Transport ID</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Note</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Driver ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conf.php';

                // Initialize base SQL query to select all tasks
                $sql = "SELECT * FROM transport_details";

                // Check if a search term is provided
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE transport_id LIKE '%$searchTerm%'";
                }

                // Check if the "show closed" filter is set
                if (isset($_GET['show_closed'])) {
                    if (!empty($sql)) {
                        $sql .= " OR ";
                    } else {
                        $sql .= " WHERE ";
                    }
                    $sql .= "status = 'Closed'";
                }

                // Execute the query
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ($row["transport_id"]) . "</td>";
                        echo "<td>" . ($row["type"]) . "</td>";
                        echo "<td>" . ($row["location"]) . "</td>";
                        echo "<td>" . ($row["note"]) . "</td>";
                        echo "<td>" . ($row["cost"]) . "</td>";
                        echo "<td>" . ($row["status"]) . "</td>";
                        echo "<td>" . ($row["driver_id"]) . "</td>";
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

    <script>
        // Function to validate the search input
        function validateSearch() {
            const searchInput = document.getElementById('search');
            const searchError = document.getElementById('searchError');

            // Reset the error message
            searchError.textContent = '';

            // Check if the search input is empty
            if (!searchInput.value.trim()) {
                searchError.textContent = 'Please enter a search term.';
                return false; // Prevent form submission
            }

            // Validation passed
            return true;
        }
    </script>
</body>
</html>
