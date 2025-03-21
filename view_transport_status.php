<?php
include 'conf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['status']) && isset($_POST['transport_id'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $transportId = $conn->real_escape_string($_POST['transport_id']);

        // Update status in the transport_details table
        $updateTransportQuery = "UPDATE transport_details SET status='$status' WHERE transport_id='$transportId'";

        // Update status in the task table as well
        $updateTaskQuery = "UPDATE task SET status='$status' WHERE Task_Name='$transportId'";

        if ($conn->query($updateTransportQuery) && $conn->query($updateTaskQuery)) {
            echo "<script>alert('Status updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Details</title>
    <link rel="stylesheet" href="vwstyle.css">
</head>
<body>
    <h1 class="head">View Transport Status</h1>

    <form id="searchForm" method="get" onsubmit="return validateSearch()">
        <div>
            <input type="text" id="search" name="search" placeholder="Search Tasks">
            <input type="submit" value="Search">
        </div>
    </form>

    <table id="transportTable">
        <thead>
            <tr>
                <th>Transport ID</th>
                <th>Driver ID</th>
                <th>Location</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Base SQL query for fetching data from transport_details and task tables
            $sql = "SELECT td.transport_id, td.driver_id, td.location, t.Discription, td.status 
                    FROM transport_details td 
                    LEFT JOIN task t ON td.transport_id = t.taskname";

            // Check if a search term is provided
            if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                $searchTerm = trim($_GET['search']);
                $sql .= " WHERE td.transport_id LIKE ? OR td.driver_id LIKE ? OR t.Discription LIKE ?";
            }

            $stmt = $conn->prepare($sql);

            // Debugging to check if prepare failed
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            // Bind parameters if a search term is used
            if (isset($searchTerm)) {
                $searchTerm = "%" . $searchTerm . "%";
                $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
            }

            // Execute the query
            if (!$stmt->execute()) {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            $result = $stmt->get_result();

            // Display the table rows
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["transport_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["driver_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Discription"]) . "</td>";
                    echo "<td class='status-cell' data-transport-id='" . htmlspecialchars($row["transport_id"]) . "'>";
                    echo "<form method='post' style='display:inline;'>";
                    echo "<input type='hidden' name='transport_id' value='" . htmlspecialchars($row["transport_id"]) . "'>";
                    echo "<select name='status' onchange='this.form.submit()'>";
                    $statusOptions = ['Pending', 'In Transit', 'Delivered', 'Cancelled'];
                    foreach ($statusOptions as $option) {
                        $selected = ($row['status'] === $option) ? "selected" : "";
                        echo "<option value='$option' $selected>$option</option>";
                    }
                    echo "</select>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No tasks found.</td></tr>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>

    <script>
        function validateSearch() {
            let searchField = document.getElementById('search');
            if (searchField.value.trim() === "") {
                alert("Please enter a search term.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
