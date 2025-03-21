<?php
include 'conf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $mid = $_POST['mid'] ?? '';
    $mname = $_POST['mname'] ?? ''; 
    $quantity = $_POST['quntity'] ?? ''; 
    $status = $_POST['status'] ?? '';
    $rd = $_POST['rd'] ?? '';

    // Validation
    if (empty($mid) || empty($mname) || empty($quantity) || empty($status) || empty($rd)) {
        echo "<script>alert('All required fields must be filled.'); window.location.href = 'add_supply_request.html';</script>";
        exit;
    }

    // Validate numeric fields (if applicable)
    if (!is_numeric($quantity)) {
        echo "<script>alert('Quantity must be a numeric value.'); window.location.href = 'add_supply_request.html';</script>";
        exit;
    }

    // Prepare SQL statement
    $sql = "INSERT INTO supply_requset (request_date, material_id, material_name, quantity, status) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $rd, $mid, $mname, $quantity, $status);

    // Execute and check success
    if ($stmt->execute()) {
        echo "<script>alert('Record added successfully!'); window.location.href = 'add_supply_request.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'add_supply_request.html';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No data received.'); window.location.href = 'add_supply_request.html';</script>";
}

// Close the database connection
mysqli_close($conn);
?>
