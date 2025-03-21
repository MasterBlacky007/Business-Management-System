<?php
include 'conf.php';

// Collect form data and validate input
$report_title = isset($_POST['report_title']) ? trim($_POST['report_title']) : '';
$report_date = isset($_POST['report_date']) ? trim($_POST['report_date']) : '';
$fruit_type = isset($_POST['fruit_type']) ? trim($_POST['fruit_type']) : '';
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
$labor_cost = isset($_POST['labor_cost']) ? floatval($_POST['labor_cost']) : 0.0;
$transport_cost = isset($_POST['transport_cost']) ? floatval($_POST['transport_cost']) : 0.0;
$packaging_cost = isset($_POST['packaging_cost']) ? floatval($_POST['packaging_cost']) : 0.0;
$miscellaneous_cost = isset($_POST['miscellaneous_cost']) ? floatval($_POST['miscellaneous_cost']) : 0.0;
$report_frequency = isset($_POST['report_frequency']) ? trim($_POST['report_frequency']) : '';
$observations = isset($_POST['observations']) ? trim($_POST['observations']) : '';

// Check if required fields are empty
if (empty($report_title) || empty($report_date) || empty($fruit_type) || $quantity <= 0) {
    echo "<script>alert('Required fields are missing or invalid.'); window.history.back();</script>";
    exit();
}

// Validate date format (example: YYYY-MM-DD)
$date_regex = "/^\d{4}-\d{2}-\d{2}$/";
if (!preg_match($date_regex, $report_date)) {
    echo "<script>alert('Invalid date format. Please use YYYY-MM-DD.'); window.history.back();</script>";
    exit();
}

// Calculate total cost
$total_cost = $labor_cost + $transport_cost + $packaging_cost + $miscellaneous_cost;

// Prepare and bind the SQL statement using prepared statements to prevent SQL injection
$sql = "INSERT INTO production_cost_reports 
        (report_title, report_date, fruit_type, quantity, labor_cost, transport_cost, packaging_cost, miscellaneous_cost, total, report_frequency, observations) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "<script>alert('An error occurred while processing your request.'); window.history.back();</script>";
    exit();
}

// Bind parameters to the prepared statement
$stmt->bind_param(
    "sssiiddddss",
    $report_title,
    $report_date,
    $fruit_type,
    $quantity,
    $labor_cost,
    $transport_cost,
    $packaging_cost,
    $miscellaneous_cost,
    $total_cost,
    $report_frequency,
    $observations
);

// Execute the statement and check for success
if ($stmt->execute()) {
    echo "<script>alert('Production cost report created successfully! Total cost: $total_cost'); window.location.href='reortdash.html';</script>";
    exit();
} else {
    echo "<script>alert('An error occurred while processing your request.'); window.history.back();</script>";
    exit();
}
?>
