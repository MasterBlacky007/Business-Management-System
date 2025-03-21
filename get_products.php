<?php
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "Nigeeth";
$password = "2018";
$dbname = "finaldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get the search query parameter
$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : "";

// SQL query to retrieve product data with optional search filter
$sql = "SELECT ProductID, Name, Price, Image FROM product";
if ($query !== "") {
    $sql .= " WHERE Name LIKE '%$query%'";
}

$result = $conn->query($sql);

// Check if there are any results and return them as JSON
if ($result && $result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
} else {
    echo json_encode([]);
}

$conn->close();
?>
