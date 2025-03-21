<?php
// Include database configuration
include 'conf.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (empty($_POST['report_title']) || empty($_POST['report_date']) || empty($_POST['transport_company']) || empty($_POST['route']) ||
        empty($_POST['total_distance']) || empty($_POST['fuel_cost']) || empty($_POST['driver_cost'])) {
        echo "Please fill in all required fields (*).";
        exit;
    }

    // Escape input values to prevent SQL injection
    $report_title = $conn->real_escape_string($_POST['report_title']);
    $report_date = $conn->real_escape_string($_POST['report_date']);
    $transport_company = $conn->real_escape_string($_POST['transport_company']);
    $route = $conn->real_escape_string($_POST['route']);
    $total_distance = intval($_POST['total_distance']);
    $fuel_cost = floatval($_POST['fuel_cost']);
    $driver_cost = floatval($_POST['driver_cost']);
    $maintenance_cost = isset($_POST['maintenance_cost']) ? floatval($_POST['maintenance_cost']) : 0;
    $other_costs = isset($_POST['other_costs']) ? floatval($_POST['other_costs']) : 0;
    $observations = isset($_POST['observations']) ? $conn->real_escape_string($_POST['observations']) : '';
    $total_cost = floatval($_POST['total_cost']); // Get the total cost from the form

    // Prepare SQL query using prepared statements
    $sql = "INSERT INTO transport_cost_reports 
            (report_title, report_date, transport_company, route, total_distance, fuel_cost, driver_cost, maintenance_cost, other_costs, observations, total)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Use prepared statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("ssssdssddds", $report_title, $report_date, $transport_company, $route, $total_distance, $fuel_cost, $driver_cost, $maintenance_cost, $other_costs, $observations, $total_cost);

        // Execute the query
        if ($stmt->execute()) {
            echo "New report submitted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
