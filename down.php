<?php

include 'conf.php';

// Create a function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Production Cost Report</title>
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
                    .summary { margin-top: 30px; border: 1px solid #ddd; padding: 10px; }
                    .summary th { background-color: #4CAF50; color: white; }
                    .summary td { padding: 8px; text-align: right; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: #4CAF50; text-decoration: none; }
                    .actions { margin-top: 20px; text-align: center; }
                    .actions button { background-color: #4CAF50; color: white; border: none; padding: 10px 20px; cursor: pointer; font-size: 1em; }
                    .actions button:hover { background-color: #45a049; }

                    @media print {
                        body {
                            color: #000 !important;
                            background-color: white !important;
                        }
                        .header {
                            background-color: #4CAF50 !important;
                            color: white !important;
                        }
                        .table th, .summary th {
                            background-color: #4CAF50 !important;
                            color: white !important;
                        }
                        .table tr:nth-child(even) {
                            background-color: #f2f2f2 !important;
                        }
                        .footer {
                            color: #000 !important;
                        }
                        .actions { display: none; } /* Hide buttons during print */
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
                    <h3>Production Cost Reports</h3>
                    <p class="meta-info">Created by: ' . $createdBy . ' | Created on: ' . $creationTime . '</p>
                </div>
                <table class="table">
                    <tr>
                        <th>ID</th><th>Title</th><th>Date</th><th>Product</th><th>Quantity</th><th>Labor Cost</th>
                        <th>Transport Cost</th><th>Packaging Cost</th><th>Misc Cost</th><th>Frequency</th><th>Notes</th><th>Total Cost</th>
                    </tr>';

    $totalLaborCost = 0;
    $totalTransportCost = 0;
    $totalPackagingCost = 0;
    $totalMiscCost = 0;
    $totalOverallCost = 0;
    $totalQuantity = 0;

    while ($report = $result->fetch_assoc()) {
        $totalCost = $report['labor_cost'] + $report['transport_cost'] + $report['packaging_cost'] + $report['miscellaneous_cost'];

        $html .= '<tr>';
        $html .= '<td>' . $report['id'] . '</td>';
        $html .= '<td>' . $report['report_title'] . '</td>';
        $html .= '<td>' . $report['report_date'] . '</td>';
        $html .= '<td>' . $report['fruit_type'] . '</td>';
        $html .= '<td>' . $report['quantity'] . '</td>';
        $html .= '<td>' . number_format($report['labor_cost'], 2) . '</td>';
        $html .= '<td>' . number_format($report['transport_cost'], 2) . '</td>';
        $html .= '<td>' . number_format($report['packaging_cost'], 2) . '</td>';
        $html .= '<td>' . number_format($report['miscellaneous_cost'], 2) . '</td>';
        $html .= '<td>' . $report['report_frequency'] . '</td>';
        $html .= '<td>' . $report['observations'] . '</td>';
        $html .= '<td>' . number_format($totalCost, 2) . '</td>';
        $html .= '</tr>';

        $totalLaborCost += $report['labor_cost'];
        $totalTransportCost += $report['transport_cost'];
        $totalPackagingCost += $report['packaging_cost'];
        $totalMiscCost += $report['miscellaneous_cost'];
        $totalOverallCost += $totalCost;
        $totalQuantity += $report['quantity'];
    }

    $html .= '</table>';
    $html .= '<div class="summary">
                <h3>Summary of Production Costs</h3>
                <table>
                    <tr><th>Summary Type</th><th>Labor Cost</th><th>Transport Cost</th><th>Packaging Cost</th><th>Misc Cost</th><th>Total Cost</th></tr>
                    <tr>
                        <td>Total</td>
                        <td>' . number_format($totalLaborCost, 2) . '</td>
                        <td>' . number_format($totalTransportCost, 2) . '</td>
                        <td>' . number_format($totalPackagingCost, 2) . '</td>
                        <td>' . number_format($totalMiscCost, 2) . '</td>
                        <td>' . number_format($totalOverallCost, 2) . '</td>
                    </tr>
                    <tr>
                        <td>Average</td>
                        <td>' . number_format($totalLaborCost / $totalQuantity, 2) . '</td>
                        <td>' . number_format($totalTransportCost / $totalQuantity, 2) . '</td>
                        <td>' . number_format($totalPackagingCost / $totalQuantity, 2) . '</td>
                        <td>' . number_format($totalMiscCost / $totalQuantity, 2) . '</td>
                        <td>' . number_format($totalOverallCost / $totalQuantity, 2) . '</td>
                    </tr>
                </table>
              </div>';
    $html .= '<div class="footer">
                <p>&copy; ' . date('Y') . ' Mico Organic. All rights reserved.</p>
                <p><a href="#">www.micoorganic.com</a></p>
              </div>
              <div class="actions">
                  <button onclick="printReport()">Print Report</button>
                  <button onclick="goBack()">Go Back</button>
              </div>
            </body>
            </html>';
    return $html;
}

// Set timezone to Sri Lanka
date_default_timezone_set('Asia/Colombo');
$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Production Manager';

$reportId = isset($_POST['report_id']) ? $_POST['report_id'] : '';
$frequency = isset($_POST['frequency']) ? $_POST['frequency'] : '';
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

$query = "SELECT * FROM production_cost_reports WHERE 1=1";
$params = [];
$types = '';

if ($reportId) {
    $query .= " AND id = ?";
    $params[] = $reportId;
    $types .= 'i';
}

if ($frequency) {
    $query .= " AND report_frequency = ?";
    $params[] = $frequency;
    $types .= 's';
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

$stmt = $conn->prepare($query);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$reportPreview = generateReportPreview($result, $creationTime, $createdBy);
echo $reportPreview;

?>
