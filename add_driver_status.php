<?php
include 'conf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $driver_id = $_POST['driver_id'] ?? '';
    $dname = $_POST['dname'] ?? '';
    $vnumber = $_POST['vnumber'] ?? '';
    $type = $_POST['type'] ?? '';
    

    // Validation
    if (empty($type) || empty($driver_id) || empty($dname) || empty($vnumber)) {
        echo "All required fields must be filled.";
        exit;
    }

    // Escaping inputs to prevent SQL injection
    $type = mysqli_real_escape_string($conn, $type);
    $driver_id = mysqli_real_escape_string($conn, $driver_id);
    $dname = mysqli_real_escape_string($conn, $dname);
    $vnumber = mysqli_real_escape_string($conn, $vnumber);

    // Insert data into the database
    $sql = "INSERT INTO driver_status (driver_id , driver_name, vehicale_no , status) 
            VALUES ('$driver_id',  '$dname', '$vnumber','$type')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>Record added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "No data received.";
}

mysqli_close($conn);
?>
