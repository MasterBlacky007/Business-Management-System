<?php
// Include database configuration
include 'conf.php';

// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Initialize search query variables
$search_report_id = '';
$search_transport_id = '';
$search_route = '';
$search_report_date = '';

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    // Get the search criteria
    $search_report_id = $_GET['report_id'];
    $search_transport_id = $_GET['transport_id'];
    $search_route = $_GET['route'];
    $search_report_date = $_GET['report_date'];
}

// Prepare SQL query to fetch reports based on search criteria
$sql = "SELECT * FROM transport_cost_reports WHERE 1";

// Add filters to the query based on the search criteria
if (!empty($search_report_id)) {
    $sql .= " AND id LIKE '%" . $conn->real_escape_string($search_report_id) . "%'";
}
if (!empty($search_transport_id)) {
    $sql .= " AND transport_company LIKE '%" . $conn->real_escape_string($search_transport_id) . "%'";
}
if (!empty($search_route)) {
    $sql .= " AND route LIKE '%" . $conn->real_escape_string($search_route) . "%'";
}
if (!empty($search_report_date)) {
    $sql .= " AND report_date LIKE '%" . $conn->real_escape_string($search_report_date) . "%'";
}

// Execute the SQL query
$result = $conn->query($sql);

?>

<link rel="stylesheet" href="report.css">

<!-- Display the search form -->
<h2>Search Transport Cost Reports</h2>
<form method="GET" action="" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
    <div style="flex: 1 0 250px;">
        <label for="report_id">Report ID:</label>
        <input type="text" name="report_id" value="<?php echo htmlspecialchars($search_report_id); ?>" style="width: 100%;">
    </div>
    
    <div style="flex: 1 0 250px;">
        <label for="transport_id">Transport ID:</label>
        <input type="text" name="transport_id" value="<?php echo htmlspecialchars($search_transport_id); ?>" style="width: 100%;">
    </div>

    <div style="flex: 1 0 250px;">
        <label for="route">Route:</label>
        <input type="text" name="route" value="<?php echo htmlspecialchars($search_route); ?>" style="width: 100%;">
    </div>

    <div style="flex: 1 0 250px;">
        <label for="report_date">Report Date:</label>
        <input type="date" name="report_date" value="<?php echo htmlspecialchars($search_report_date); ?>" style="width: 100%;">
    </div>

    <div style="flex: 0 1 150px;">
        <button type="submit" name="search" style="width: 100%;">Search</button>
    </div>
</form>

<!-- Display Reports in a Table with Editable Rows -->
<h2>Transport Cost Reports</h2>
<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Report ID</th>
            <th>Report Title</th>
            <th>Report Date</th>
            <th>Transport ID</th>
            <th>Route</th>
            <th>Total Distance</th>
            <th>Fuel Cost</th>
            <th>Driver Cost</th>
            <th>Maintenance Cost</th>
            <th>Other Costs</th>
            <th>Total Cost</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <form method='POST' action=''>
                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                            <td>" . $row['id'] . "</td>
                            <td><input type='text' name='report_title' value='" . $row['report_title'] . "' required></td>
                            <td><input type='date' name='report_date' value='" . $row['report_date'] . "' required></td>
                            <td><input type='text' name='transport_company' value='" . $row['transport_company'] . "' required></td>
                            <td><input type='text' name='route' value='" . $row['route'] . "' required></td>
                            <td><input type='number' name='total_distance' value='" . $row['total_distance'] . "' required onchange='calculateTotal(this)'></td>
                            <td><input type='number' step='0.01' name='fuel_cost' value='" . $row['fuel_cost'] . "' required onchange='calculateTotal(this)'></td>
                            <td><input type='number' step='0.01' name='driver_cost' value='" . $row['driver_cost'] . "' required onchange='calculateTotal(this)'></td>
                            <td><input type='number' step='0.01' name='maintenance_cost' value='" . $row['maintenance_cost'] . "' onchange='calculateTotal(this)'></td>
                            <td><input type='number' step='0.01' name='other_costs' value='" . $row['other_costs'] . "' onchange='calculateTotal(this)'></td>
                            <td><input type='number' step='0.01' name='total_cost' value='" . $row['total'] . "' required readonly></td>
                            <td>
                                <button type='submit' name='update_report'>Update</button>
                            </td>
                        </form>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No reports found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- PDF Download Button -->
<form method="POST" action="download_pdf.php">
    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($search_report_id); ?>">
    <input type="hidden" name="transport_id" value="<?php echo htmlspecialchars($search_transport_id); ?>">
    <input type="hidden" name="route" value="<?php echo htmlspecialchars($search_route); ?>">
    <input type="hidden" name="report_date" value="<?php echo htmlspecialchars($search_report_date); ?>">
    <button type="submit" name="download_pdf">Download PDF</button>
</form>

<script>
// JavaScript function to auto calculate the total cost
function calculateTotal(element) {
    let row = element.closest('tr');
    let total_distance = parseFloat(row.querySelector('[name="total_distance"]').value) || 0;
    let fuel_cost = parseFloat(row.querySelector('[name="fuel_cost"]').value) || 0;
    let driver_cost = parseFloat(row.querySelector('[name="driver_cost"]').value) || 0;
    let maintenance_cost = parseFloat(row.querySelector('[name="maintenance_cost"]').value) || 0;
    let other_costs = parseFloat(row.querySelector('[name="other_costs"]').value) || 0;

    // Calculate total cost
    let total_cost = fuel_cost + driver_cost + maintenance_cost + other_costs;

    // Update total cost input field
    row.querySelector('[name="total_cost"]').value = total_cost.toFixed(2);
}
</script>

<?php
// Close the database connection after all operations are complete
$conn->close();
?>
