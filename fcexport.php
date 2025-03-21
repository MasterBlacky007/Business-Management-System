<?php
include 'conf.php';

// Set the timezone to Sri Lanka (UTC+5:30)
date_default_timezone_set('Asia/Colombo');

// Create a function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - ExportOrder Report</title>
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
                        .print-button, .back-button {
                            display: none !important;
                        }
                    }

                    /* Style the buttons */
                    .print-button, .back-button {
                        background-color: #4CAF50; /* Green */
                        color: white;
                        padding: 10px 20px;
                        font-size: 1em;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-top: 20px;
                        margin-right: 10px;
                        display: inline-block;
                    }

                    .print-button:hover, .back-button:hover {
                        background-color: #45a049; /* Darker green */
                    }

                    .print-button:active, .back-button:active {
                        background-color: #39843c; /* Even darker green */
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
                    <h3>ExportOrder Report</h3>
                    <p class="meta-info"> Created by: ' . $createdBy . ' | Created on: ' . $creationTime . ' </p>                    
                </div>
                
                <table class="table">
                    <tr>
                        <th>OrderID</th>
                        <th>ProductID</th>
                        <th>IIC</th>
                        <th>OrderDate</th>
                        <th>Quantity</th>
                        <th>Address</th>
                        <th>Country</th>
                        <th>Amount</th>
                        <th>Payment</th>
                    </tr>';

    // Initialize an array to hold the totals by ProductID
    $productTotals = [];

    // Add rows and calculate totals for each ProductID
    while ($order = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $order['OrderID'] . '</td>';
        $html .= '<td>' . $order['ProductID'] . '</td>';
        $html .= '<td>' . $order['IIC'] . '</td>';
        $html .= '<td>' . $order['OrderDate'] . '</td>';
        $html .= '<td>' . $order['Quantity'] . '</td>';
        $html .= '<td>' . $order['Address'] . '</td>';
        $html .= '<td>' . $order['Country'] . '</td>';
        $html .= '<td>' . number_format($order['Amount'], 2) . '</td>';
        $html .= '<td>' . $order['Payment'] . '</td>';
        $html .= '</tr>';

        // Add the quantity and amount to the product totals
        if (!isset($productTotals[$order['ProductID']])) {
            $productTotals[$order['ProductID']] = ['quantity' => 0, 'amount' => 0];
        }
        $productTotals[$order['ProductID']]['quantity'] += $order['Quantity'];
        $productTotals[$order['ProductID']]['amount'] += $order['Amount'];
    }

    // Summary - Display total quantity and amount for each ProductID
    $html .= '</table>';

    $html .= '<div class="summary">
                <h3>Summary of ExportOrder Report</h3>
                <table>';
    $html .= '<tr><th>ProductID</th><th>Total Quantity</th><th>Total Amount</th></tr>';

    $totalQuantity = 0;
    $totalAmount = 0;

    // Display product totals
    foreach ($productTotals as $productID => $totals) {
        $html .= '<tr>';
        $html .= '<td>' . $productID . '</td>';
        $html .= '<td>' . $totals['quantity'] . '</td>';
        $html .= '<td>' . number_format($totals['amount'], 2) . '</td>';
        $html .= '</tr>';

        // Add to overall totals
        $totalQuantity += $totals['quantity'];
        $totalAmount += $totals['amount'];
    }

    // Display the overall total
    $html .= '<tr><th>Total</th><th>' . $totalQuantity . '</th><th>' . number_format($totalAmount, 2) . '</th></tr>';
    $html .= '</table></div>';

    $html .= '<div class="footer">
                <p>&copy; ' . date('Y') . ' Mico Organic. All rights reserved.</p>
                <p><a href="#">www.micoorganic.com</a></p>
              </div>
            </body>
            </html>';

    return $html;
}

// Retrieve POST data from the form
$orderId = isset($_POST['order_id']) ? $_POST['order_id'] : '';
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Prepare the SQL query with filters
$query = "SELECT * FROM lforder WHERE 1=1"; // Default WHERE clause
$params = [];
$types = ''; // Initialize $types with an empty string

// Add filters based on form input
if ($orderId) {
    $query .= " AND OrderID = ?";
    $params[] = $orderId;
    $types .= 'i'; // Add integer type
}

if ($startDate) {
    $query .= " AND OrderDate >= ?";
    $params[] = $startDate;
    $types .= 's'; // Add string type
}

if ($endDate) {
    $query .= " AND OrderDate <= ?";
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
$creationTime = date('Y-m-d H:i:s'); // Use Sri Lanka time
$createdBy = 'Factory Manager'; // Replace with dynamic data if available

// Generate the HTML preview
$reportPreview = generateReportPreview($result, $creationTime, $createdBy);

// Display HTML preview to the user
echo $reportPreview;

// Print and Back buttons
echo '<div>
        <input type="button" class="print-button" value="Print Report" onclick="printReport()">
        <input type="button" class="back-button" value="Back" onclick="goBack()">
      </div>';
?>
