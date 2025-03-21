<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $username = 'Nigeeth';
    $password = '2018';
    $database = 'finaldb';

    // Connect to the database
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Collect form data
    $report_title = $conn->real_escape_string($_POST['report_title']);
    $report_date = $conn->real_escape_string($_POST['report_date']);
    $fruit_type = $conn->real_escape_string($_POST['fruit_type']);
    $quantity = intval($_POST['quantity']);
    $labor_cost = floatval($_POST['labor_cost']);
    $transport_cost = floatval($_POST['transport_cost']);
    $packaging_cost = floatval($_POST['packaging_cost']);
    $miscellaneous_cost = isset($_POST['miscellaneous_cost']) ? floatval($_POST['miscellaneous_cost']) : 0;
    $report_frequency = $conn->real_escape_string($_POST['report_frequency']);
    $observations = $conn->real_escape_string($_POST['observations']);

    // Insert data into the database
    $sql = "INSERT INTO production_cost_reports 
            (report_title, report_date, fruit_type, quantity, labor_cost, transport_cost, packaging_cost, miscellaneous_cost, report_frequency, observations) 
            VALUES 
            ('$report_title', '$report_date', '$fruit_type', $quantity, $labor_cost, $transport_cost, $packaging_cost, $miscellaneous_cost, '$report_frequency', '$observations')";

    if ($conn->query($sql) === TRUE) {
        echo "Production cost report created successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
