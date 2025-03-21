<?php
// conf.php - Database connection configuration

$servername = "localhost";
$username = "Nigeeth";
$password = "2018";
$dbname = "finaldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
