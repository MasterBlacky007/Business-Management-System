<?php
include 'conf.php';

// Set the timezone to Sri Lanka (UTC+5:30)
date_default_timezone_set('Asia/Colombo');

// Function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Salary Status</title>
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
                    @media print {
                        .print-button, .back-button { display: none !important; }
                    }
                    .print-button, .back-button {
                        background-color: #4CAF50; color: white; padding: 10px 20px;
                        font-size: 1em; border: none; cursor: pointer; border-radius: 5px;
                        margin-top: 20px; margin-right: 10px; display: inline-block;
                    }
                    .print-button:hover, .back-button:hover { background-color: #45a049; }
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
                    <h3>Salary Status</h3>
                    <p class="meta-info"> Created by: ' . $createdBy . ' | Created on: ' . $creationTime . ' </p>                    
                </div>
                
                <table class="table">
                    <tr>
                        <th>SalaryID</th>
                        <th>StaffID</th>
                        <th>StaffNo</th>
                        <th>Name</th>
                        <th>Month</th>
                        <th>BasicPay</th>
                        <th>Overtime</th>
                        <th>ETF</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>AccountNumber</th>
                        <th>Status</th>
                    </tr>';

    $totalBasicPay = $totalOvertime = $totalETF = $totalAmount = 0;

    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['SalaryID'] . '</td>';
        $html .= '<td>' . $row['StaffID'] . '</td>';
        $html .= '<td>' . $row['StaffNo'] . '</td>';
        $html .= '<td>' . $row['Name'] . '</td>';
        $html .= '<td>' . $row['Month'] . '</td>';
        $html .= '<td>' . number_format($row['BasicPay'], 2) . '</td>';
        $html .= '<td>' . number_format($row['OT'], 2) . '</td>';
        $html .= '<td>' . number_format($row['ETF'], 2) . '</td>';
        $html .= '<td>' . number_format($row['Amount'], 2) . '</td>';
        $html .= '<td>' . $row['Date'] . '</td>';
        $html .= '<td>' . $row['AccountNumber'] . '</td>';
        $html .= '<td>' . $row['Status'] . '</td>';
        $html .= '</tr>';

        $totalBasicPay += $row['BasicPay'];
        $totalOvertime += $row['OT'];
        $totalETF += $row['ETF'];
        $totalAmount += $row['Amount'];
    }

    $html .= '</table>';
    $html .= '<div class="summary">
                <h3>Summary of Salary Status</h3>
                <table>
                    <tr><th>Total Basic Pay</th><th>Total Overtime</th><th>Total ETF</th><th>Total Amount</th></tr>
                    <tr>
                        <td>' . number_format($totalBasicPay, 2) . '</td>
                        <td>' . number_format($totalOvertime, 2) . '</td>
                        <td>' . number_format($totalETF, 2) . '</td>
                        <td>' . number_format($totalAmount, 2) . '</td>
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

// SQL query to fetch all salary records
$query = "SELECT * FROM salary";
$result = $conn->query($query);

// Define creation time and creator
$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Factory Manager';

// Generate the HTML preview
$reportPreview = generateReportPreview($result, $creationTime, $createdBy);

// Display the report
echo $reportPreview;

// Print and Back buttons
echo '<div>
        <input type="button" class="print-button" value="Print Report" onclick="printReport()">
        <input type="button" class="back-button" value="Back" onclick="goBack()">
      </div>';
?>
