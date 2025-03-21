<?php
// Include the database connection
include 'conf.php';

// Initialize variables
$searchDate = isset($_GET['search_date']) ? $_GET['search_date'] : null;
$showAll = isset($_GET['show_all']) ? true : false; // Show all data if 'show_all' is passed

// Pagination Setup
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Initialize creation info
$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Production Manager'; // Replace with dynamic data if available

// Prepare query based on search
if ($showAll) {
    // No pagination for print view, show all records
    if ($searchDate) {
        $query = "SELECT product_name, today_sell, today_create, balance, today_amount, create_amount, today_revanew 
                  FROM daily_report 
                  WHERE date = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $searchDate);
    } else {
        $query = "SELECT product_name, today_sell, today_create, balance, today_amount, create_amount, today_revanew 
                  FROM daily_report";
        $stmt = $conn->prepare($query);
    }
} else {
    // Paginated query
    if ($searchDate) {
        $query = "SELECT product_name, today_sell, today_create, balance, today_amount, create_amount, today_revanew 
                  FROM daily_report 
                  WHERE date = ? 
                  LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sii', $searchDate, $limit, $offset);
    } else {
        $query = "SELECT product_name, today_sell, today_create, balance, today_amount, create_amount, today_revanew 
                  FROM daily_report 
                  LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $limit, $offset);
    }
}
$stmt->execute();
$result = $stmt->get_result();

// Initialize totals
$totalSell = 0;
$totalCreate = 0;
$totalBalance = 0;
$totalAmount = 0;
$totalCreateAmount = 0;
$totalRevenue = 0;

// Fetch and calculate totals
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
    $totalSell += $row['today_sell'];
    $totalCreate += $row['today_create'];
    $totalBalance += $row['balance'];
    $totalAmount += $row['today_amount'];
    $totalCreateAmount += $row['create_amount'];
    $totalRevenue += $row['today_revanew'];
}

// Get total records for pagination (only for non-print version)
if (!$showAll) {
    if ($searchDate) {
        $totalQuery = "SELECT COUNT(*) as total FROM daily_report WHERE date = ?";
        $totalStmt = $conn->prepare($totalQuery);
        $totalStmt->bind_param('s', $searchDate);
        $totalStmt->execute();
        $totalResult = $totalStmt->get_result();
    } else {
        $totalQuery = "SELECT COUNT(*) as total FROM daily_report";
        $totalResult = $conn->query($totalQuery);
    }

    $totalRow = $totalResult->fetch_assoc();
    $totalRecords = $totalRow['total'];
    $totalPages = ceil($totalRecords / $limit);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Daily Reports</title>
    <style>
        /* CSS for Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            padding: 10px;
            color: white;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
        }
        .header img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .search-form {
            margin-bottom: 20px;
            text-align: center;
        }
        .search-form input[type="date"],
        .search-form input[type="submit"] {
            padding: 10px;
            font-size: 14px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        .search-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #4CAF50;
            color: white;
        }
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #4CAF50;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #888;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #2e8b57;
        }
        @media print {
            .print-btn,
            .pagination,
            .search-form {
                display: none;
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://micoceylonorganics.lk/assets/img/mico.png" alt="Mico Organic Logo">
            <h1>Mico Organic</h1>
            <h3>Daily Reports</h3>
            <p>Created by: <?php echo htmlspecialchars($createdBy); ?> | Created on: <?php echo htmlspecialchars($creationTime); ?></p>
        </div>

        <!-- Search Form -->
        <form method="GET" class="search-form">
            <label for="search_date">Search by Date:</label>
            <input type="date" name="search_date" id="search_date" value="<?php echo htmlspecialchars($searchDate); ?>">
            <input type="submit" value="Search">
        </form>

        <!-- Table Data -->
        <?php if (count($data) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Today Sell</th>
                        <th>Today Create</th>
                        <th>Balance</th>
                        <th>Today Amount</th>
                        <th>Create Amount</th>
                        <th>Today Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['today_sell']); ?></td>
                            <td><?php echo htmlspecialchars($row['today_create']); ?></td>
                            <td><?php echo htmlspecialchars($row['balance']); ?></td>
                            <td><?php echo htmlspecialchars($row['today_amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['create_amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['today_revanew']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No daily reports available for the selected date.</p>
        <?php endif; ?>

        <!-- Summary Data -->
        <div class="summary">
            <h3>Summary</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Total Sell</th>
                        <th>Total Create</th>
                        <th>Total Balance</th>
                        <th>Total Amount</th>
                        <th>Total Create Amount</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($totalSell); ?></td>
                        <td><?php echo htmlspecialchars($totalCreate); ?></td>
                        <td><?php echo htmlspecialchars($totalBalance); ?></td>
                        <td><?php echo htmlspecialchars($totalAmount); ?></td>
                        <td><?php echo htmlspecialchars($totalCreateAmount); ?></td>
                        <td><?php echo htmlspecialchars($totalRevenue); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!$showAll): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Print Button -->
        <!-- Print Button -->
        <button class="print-btn" onclick="window.print()">Print All Reports</button>
    </div>

    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> Mico Organic. All rights reserved.</p>
        <p><a href="#">www.micoorganic.com</a></p>
    </div>
</body>
</html>
