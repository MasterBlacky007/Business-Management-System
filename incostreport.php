<?php
include 'conf.php';

// Set timezone to Sri Lanka Standard Time (SLST)
date_default_timezone_set('Asia/Colombo');

// Create a function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Inventory Cost Report</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: white; }
                    .header { background-color: #4CAF50; padding: 10px; color: white; text-align: center; }
                    .header h1 { margin: 0; font-size: 2em; }
                    .header h3 { margin: 5px 0; font-style: italic; }
                    .header img { width: 100px; height: auto; margin-bottom: 10px; } 
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                    .table th { background-color: #4CAF50; color: white; }
                    .table tr:nth-child(even) { background-color: #f2f2f2; }
                    .summary { margin-top: 30px; border: 1px solid #ddd; padding: 10px; }
                    .summary th { background-color: #4CAF50; color: white; }
                    .summary td { padding: 8px; text-align: right; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: #4CAF50; text-decoration: none; }
                    
                    /* Hide the print button when printing */
                    @media print {
                        .print-button {
                            display: none !important;
                        }
                            .back-button {
                            display: none !important;
                        }
                    }

                    /* Style the Print Report button */
                    .print-button {
                        background-color: #4CAF50; /* Green */
                        color: white;
                        padding: 10px 20px;
                        font-size: 1em;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-top: 20px;
                        display: inline-block;
                    }

                    .print-button:hover {
                        background-color: #45a049; /* Darker green */
                    }

                    .print-button:active {
                        background-color: #39843c; /* Even darker green */
                    }

                    .back-button {
                        background-color: #39843c; /* Red */
                        color: white;
                        padding: 10px 20px;
                        font-size: 1em;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-top: 20px;
                        display: inline-block;
                    }

                    .back-button:hover {
                        background-color: #39843c; /* Darker red */
                    }
                </style>
                <script>
                    function printReport() {
                        window.print();
                    }
                    function goBack() {
                        window.history.back();
                    }
                </script>
            </head>
            <body>
                <div class="header">
                    <img src="https://micoceylonorganics.lk/assets/img/mico.png" alt="Mico Organic Logo"> 
                    <h1>Mico Organic</h1>
                    <h3>Inventory Cost Reports</h3>
                    <p class="meta-info"> Created by: ' . $createdBy . ' | Created on: ' . $creationTime . ' </p>                    
                </div>
                
                <table class="table">
                    <tr>
                        <th>ID</th><th>Material ID</th><th>Date</th><th>Quantity</th><th>Price</th><th>Amount</th>
                    </tr>';

    $totalQuantity = 0;
    $totalOrderAmount = 0;
    $highestQuantity = 0;
    $highestQuantityDate = '';

    // Add rows
    while ($report = $result->fetch_assoc()) {
        $orderAmount = $report['quantity'] * $report['price'];
        $html .= '<tr>';
        $html .= '<td>' . $report['id'] . '</td>'; // Order ID (using 'id' for order ID)
        $html .= '<td>' . $report['mid'] . '</td>'; // Supplier ID (using 'mid' for the supplier ID)
        $html .= '<td>' . $report['date'] . '</td>'; // Order Date
        $html .= '<td>' . $report['quantity'] . '</td>';
        $html .= '<td>' . number_format($report['price'], 2) . '</td>';
        $html .= '<td>' . number_format($orderAmount, 2) . '</td>';
        $html .= '</tr>';

        // Calculate totals for summary
        $totalQuantity += $report['quantity'];
        $totalOrderAmount += $orderAmount;

        if ($report['quantity'] > $highestQuantity) {
            $highestQuantity = $report['quantity'];
            $highestQuantityDate = $report['date'];
        }
    }

    // Summary
    $html .= '</table>';

    $html .= '<div class="summary">
                <h3>Summary of Inventory Costs</h3>
                <table>
                    <tr><th>Total Quantity</th><th>Total Order Amount</th><th>Highest Quantity</th><th>Date of Highest Quantity</th></tr>
                    <tr>
                        <td>' . number_format($totalQuantity, 0) . '</td>
                        <td>' . number_format($totalOrderAmount, 2) . '</td>
                        <td>' . number_format($highestQuantity, 0) . '</td>
                        <td>' . $highestQuantityDate . '</td>
                    </tr>
                </table>
              </div>';

    $html .= '<div class="footer">
                <p>&copy; ' . date('Y') . ' Mico Organic. All rights reserved.</p>
                <p><a href="#">www.micoorganic.com</a></p>
              </div>
            </body>
            </html>';

    return $html;
}

// Retrieve POST data from the form
$reportId = isset($_POST['report_id']) ? $_POST['report_id'] : '';
$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Prepare the SQL query with filters
$query = "SELECT * FROM incost WHERE 1=1"; // Default WHERE clause
$params = [];
$types = ''; // Initialize $types with an empty string

// Add filters based on form input
if ($reportId) {
    $query .= " AND id = ?";
    $params[] = $reportId;
    $types .= 'i'; // Add integer type
}

if ($frequency) {
    $query .= " AND report_frequency = ?";
    $params[] = $frequency;
    $types .= 's'; // Add string type
}

if ($startDate) {
    $query .= " AND date >= ?";
    $params[] = $startDate;
    $types .= 's'; // Add string type
}

if ($endDate) {
    $query .= " AND date <= ?";
    $params[] = $endDate;
    $types .= 's'; // Add string type
}

// Prepare and execute the SQL query with dynamic filters
$stmt = $conn->prepare($query);

// Only bind parameters if $types is not empty
if ($types) {
    $stmt->bind_param($types, ...$params); // Bind dynamic parameters
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Define creation time and creator
$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Inventory Manager'; // Replace with dynamic data if available

// Generate the HTML preview
$reportPreview = generateReportPreview($result, $creationTime, $createdBy);

// Display HTML preview to the user
echo $reportPreview;

echo '<input type="button" class="print-button" value="Print Report" onclick="printReport()">'; // Button triggers print
echo '<input type="button" class="back-button" value="Back" onclick="goBack()">'; // Back button
?>
