<?php
include 'conf.php';

// Initialize base SQL query to select all tasks
$sql = "SELECT * FROM driver_status ";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    $sql .= " , transport_id LIKE '%$searchTerm%'";
}



// Execute the query
$result = $conn->query($sql);

// ... (rest of your code to display the table rows)

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . ($row["driver_id"]) . "</td>";
        echo "<td>" . ($row["driver_name"]) . "</td>";
        echo "<td>" . ($row["vehicale_no"]) . "</td>";
        echo "<td>" . ($row["status"]) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No tasks found.</td></tr>";
}

$conn->close();
?>

