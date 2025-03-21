<?php
include 'conf.php'; // Include the database connection configuration file

// Set the default time zone to Sri Lanka
date_default_timezone_set('Asia/Colombo');

// Create a function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy) {
    // Initialize summary variables
    $totalRecords = 0;
    $totalFuelCost = 0;
    $totalDriverCost = 0;
    $totalMaintenanceCost = 0;
    $totalOtherCosts = 0;
    $grandTotalCost = 0;

    // Start generating the HTML content for the report
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Transport Cost Report</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: white; }
                    .header { background-color: #4CAF50; padding: 10px; color: white; text-align: center; }
                    .header h1 { margin: 0; font-size: 2em; }
                    .header h3 { margin: 5px 0; font-style: italic; }
                    .header img { width: 100px; height: auto; margin-bottom: 10px; } 
                    .header .meta-info { font-size: 0.9em; margin-top: 5px; }
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                    .table th { background-color: #4CAF50; color: white; }
                    .table tr:nth-child(even) { background-color: #f2f2f2; }
                    .summary-table { width: 50%; margin: 20px auto; border-collapse: collapse; }
                    .summary-table th, .summary-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    .summary-table th { background-color: #4CAF50; color: white; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: #4CAF50; text-decoration: none; }
                    
                    /* Button Styles */
                    .btn {
                        padding: 10px 20px;
                        font-size: 1em;
                        border-radius: 5px;
                        cursor: pointer;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        margin-top: 20px;
                        transition: background-color 0.3s ease, transform 0.2s ease;
                    }
                    .btn-back {
                        background-color: #2196F3;
                        color: white;
                    }
                    .btn-back:hover {
                        background-color: #1976D2;
                        transform: scale(1.05);
                    }
                    .btn-back:active {
                        background-color: #1565C0;
                    }
                    .btn-print {
                        background-color: #4CAF50;
                        color: white;
                    }
                    .btn-print:hover {
                        background-color: #45a049;
                        transform: scale(1.05);
                    }
                    .btn-print:active {
                        background-color: #39843c;
                    }

                    @media print {
                        .print-button {
                            display: none !important;
                        }
                    }
                </style>
                <script>
                    function printReport() {
                        window.print();
                    }
                </script>
            </head>
            <body>
                <div class="header">
                    <img src="https://micoceylonorganics.lk/assets/img/mico.png" alt="Mico Organic Logo"> 
                    <h1>Mico Organic</h1>
                    <h3>Transport Cost Reports</h3>
                    <p class="meta-info">Created by: ' . $createdBy . ' | Created on: ' . $creationTime . '</p>
                </div>
                
                <table class="table">
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
                    </tr>';

    // Add rows
    while ($report = $result->fetch_assoc()) {
        $totalCost = $report['fuel_cost'] + $report['driver_cost'] + $report['maintenance_cost'] + $report['other_costs'];
        $totalRecords++;
        $totalFuelCost += $report['fuel_cost'];
        $totalDriverCost += $report['driver_cost'];
        $totalMaintenanceCost += $report['maintenance_cost'];
        $totalOtherCosts += $report['other_costs'];
        $grandTotalCost += $totalCost;

        $html .= '<tr>';
        $html .= '<td>' . $report['id'] . '</td>';
        $html .= '<td>' . $report['report_title'] . '</td>';
        $html .= '<td>' . $report['report_date'] . '</td>';
        $html .= '<td>' . $report['id'] . '</td>';
        $html .= '<td>' . $report['route'] . '</td>';
        $html .= '<td>' . number_format($report['total_distance'], 2) . '</td>';
        $html .= '<td>' . number_format($report['fuel_cost'], 2) . '</td>';
        $html .= '<td>' . number_format($report['driver_cost'], 2) . '</td>';
        $html .= '<td>' . number_format($report['maintenance_cost'], 2) . '</td>';
        $html .= '<td>' . number_format($report['other_costs'], 2) . '</td>';
        $html .= '<td>' . number_format($totalCost, 2) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Add summary in a table
    $html .= '<table class="summary-table">
                <tr>
                    <th>Summary Metric</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Total Records</td>
                    <td>' . $totalRecords . '</td>
                </tr>
                <tr>
                    <td>Total Fuel Cost</td>
                    <td>' . number_format($totalFuelCost, 2) . '</td>
                </tr>
                <tr>
                    <td>Total Driver Cost</td>
                    <td>' . number_format($totalDriverCost, 2) . '</td>
                </tr>
                <tr>
                    <td>Total Maintenance Cost</td>
                    <td>' . number_format($totalMaintenanceCost, 2) . '</td>
                </tr>
                <tr>
                    <td>Total Other Costs</td>
                    <td>' . number_format($totalOtherCosts, 2) . '</td>
                </tr>
                <tr>
                    <td>Grand Total Cost</td>
                    <td>' . number_format($grandTotalCost, 2) . '</td>
                </tr>
                <tr>
                    <td>Average Cost Per Report</td>
                    <td>' . ($totalRecords > 0 ? number_format($grandTotalCost / $totalRecords, 2) : 'N/A') . '</td>
                </tr>
              </table>';

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
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Prepare the SQL query with filters
$query = "SELECT * FROM transport_cost_reports WHERE 1=1";
$params = [];
$types = '';

if ($reportId) {
    $query .= " AND id = ?";
    $params[] = $reportId;
    $types .= 'i';
}

if ($startDate) {
    $query .= " AND report_date >= ?";
    $params[] = $startDate;
    $types .= 's';
}

if ($endDate) {
    $query .= " AND report_date <= ?";
    $params[] = $endDate;
    $types .= 's';
}

// Prepare and execute the SQL query with dynamic filters
$stmt = $conn->prepare($query);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Transport Manager';

$reportPreview = generateReportPreview($result, $creationTime, $createdBy);

echo $reportPreview;

echo '<div style="text-align:center;">
<button class="btn btn-print" onclick="printReport()">Print Report</button>
        <a href="costTR.php" class="btn btn-back">Back</a>
        
      </div>';
?>
