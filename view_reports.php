<?php
include 'conf.php';

// Start session and generate CSRF token if not set
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$message = '';
$searchResults = [];

// Helper function to execute prepared statements
function executeQuery($conn, $query, $params = [], $types = '') {
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Pagination Setup
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Handle Search Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $reportId = trim($_POST['report_id'] ?? '');
    $frequency = trim($_POST['frequency'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    $query = "SELECT * FROM production_cost_reports WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($reportId)) {
        $query .= " AND id = ?";
        $params[] = $reportId;
        $types .= 'i';
    }
    if (!empty($frequency)) {
        $query .= " AND report_frequency = ?";
        $params[] = $frequency;
        $types .= 's';
    }
    if (!empty($startDate) && !empty($endDate)) {
        $query .= " AND report_date BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
        $types .= 'ss';
    }

    $query .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    $types .= 'ii';

    $searchResults = executeQuery($conn, $query, $params, $types);
} else {
    // Default: Fetch all reports with pagination
    $query = "SELECT * FROM production_cost_reports LIMIT ? OFFSET ?";
    $searchResults = executeQuery($conn, $query, [$limit, $offset], 'ii');
}

// Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token mismatch!");
    }

    $id = $_POST['id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $laborCost = $_POST['labor_cost'];
    $transportCost = $_POST['transport_cost'];
    $packagingCost = $_POST['packaging_cost'];
    $miscCost = $_POST['misc_cost'];
    $frequency = $_POST['frequency'];
    $notes = $_POST['notes'];

    // Calculate Total Cost
    $totalCost = $laborCost + $transportCost + $packagingCost + $miscCost;

    // Update the report in the database
    $updateQuery = "UPDATE production_cost_reports SET 
                    report_title = ?, 
                    report_date = ?, 
                    fruit_type = ?, 
                    quantity = ?, 
                    labor_cost = ?, 
                    transport_cost = ?, 
                    packaging_cost = ?, 
                    miscellaneous_cost = ?, 
                    total = ?, 
                    report_frequency = ?, 
                    observations = ? 
                    WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param(
        'sssdddddsssi',
        $title,
        $date,
        $product,
        $quantity,
        $laborCost,
        $transportCost,
        $packagingCost,
        $miscCost,
        $totalCost,
        $frequency,
        $notes,
        $id
    );

    if ($stmt->execute()) {
        $message = "Report updated successfully!";
    } else {
        $message = "Failed to update the report: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Update Reports</title>
    <link rel="stylesheet" href="report.css">
    <script>
        // Auto-calculate total cost
        document.addEventListener('input', function (event) {
            if (event.target.matches('input[name="labor_cost"], input[name="transport_cost"], input[name="packaging_cost"], input[name="misc_cost"]')) {
                const row = event.target.closest('tr');
                const laborCost = parseFloat(row.querySelector('input[name="labor_cost"]').value) || 0;
                const transportCost = parseFloat(row.querySelector('input[name="transport_cost"]').value) || 0;
                const packagingCost = parseFloat(row.querySelector('input[name="packaging_cost"]').value) || 0;
                const miscCost = parseFloat(row.querySelector('input[name="misc_cost"]').value) || 0;
                const totalCost = laborCost + transportCost + packagingCost + miscCost;
                row.querySelector('input[name="total_cost"]').value = totalCost.toFixed(2);
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Production Cost Reports</h2>
        <p><?php echo htmlspecialchars($message); ?></p>

        <!-- Search Form -->
        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <div>
                <label for="report_id">Report ID:</label>
                <input type="text" id="report_id" name="report_id" placeholder="Enter Report ID">
            </div>
            <div>
                <label for="frequency">Frequency:</label>
                <input type="text" id="frequency" name="frequency" placeholder="Enter Frequency">
            </div>
            <div>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date">
            </div>
            <div>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date">
            </div>
            <button class='ss1'type="submit" name="search">Search</button>
        </form>

        <!-- Table to view and update reports -->
        <table border="1">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity (kg)</th>
                    <th>Labor Cost</th>
                    <th>Transport Cost</th>
                    <th>Packaging Cost</th>
                    <th>Miscellaneous Cost</th>
                    <th>Frequency</th>
                    <th>Notes</th>
                    <th>Total Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($report = $searchResults->fetch_assoc()): ?>
                    <tr>
                        <form method="POST" action="">
                            <td><?php echo htmlspecialchars($report['id']); ?></td>
                            <td><input type="text" name="title" value="<?php echo htmlspecialchars($report['report_title']); ?>" required></td>
                            <td><input type="date" name="date" value="<?php echo htmlspecialchars($report['report_date']); ?>" required></td>
                            <td><input type="text" name="product" value="<?php echo htmlspecialchars($report['fruit_type']); ?>" required></td>
                            <td><input type="number" name="quantity" value="<?php echo htmlspecialchars($report['quantity']); ?>" required></td>
                            <td><input type="number" step="0.01" name="labor_cost" value="<?php echo htmlspecialchars($report['labor_cost']); ?>" required></td>
                            <td><input type="number" step="0.01" name="transport_cost" value="<?php echo htmlspecialchars($report['transport_cost']); ?>" required></td>
                            <td><input type="number" step="0.01" name="packaging_cost" value="<?php echo htmlspecialchars($report['packaging_cost']); ?>" required></td>
                            <td><input type="number" step="0.01" name="misc_cost" value="<?php echo htmlspecialchars($report['miscellaneous_cost']); ?>" required></td>
                            <td>
                                <select name="frequency" required>
                                    <option value=""><?php echo htmlspecialchars($report['report_frequency']); ?></option>
                                    <option value="Daily" <?php echo ($report['report_frequency'] == 'Daily') ? 'selected' : ''; ?>>Daily</option>
                                    <option value="Weekly" <?php echo ($report['report_frequency'] == 'Weekly') ? 'selected' : ''; ?>>Weekly</option>
                                    <option value="Monthly" <?php echo ($report['report_frequency'] == 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
                                </select>
                            </td>
                            <td><textarea name="notes"><?php echo htmlspecialchars($report['observations']); ?></textarea></td>
                            <td><input type="text" name="total_cost" value="<?php echo htmlspecialchars($report['total']); ?>" readonly></td>
                            <td>
                                <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <button type="submit" name="update">Update</button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
       <!-- Add the following form for the download button -->
<form action="down.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($_POST['report_id'] ?? ''); ?>">
    <input type="hidden" name="frequency" value="<?php echo htmlspecialchars($_POST['frequency'] ?? ''); ?>">
    <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? ''); ?>">
    <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? ''); ?>">
    <button type="submit" name="download_pdf">Download PDF</button>
</form>



        <!-- Pagination -->
        <div>
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        </div>
    </div>
</body>
</html>
