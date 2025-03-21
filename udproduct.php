<?php
include 'conf.php';

// Get the product details from the form
$id = $_POST['id'];
$name = $_POST['Name'];
$price = $_POST['Price'];
$image = $_POST['Image'];

// Sanitize input
$name = mysqli_real_escape_string($conn, $name);
$price = mysqli_real_escape_string($conn, $price);
$image = mysqli_real_escape_string($conn, $image);

// Update product in the database
$query = "UPDATE product SET Name='$name', Price='$price', Image='$image' WHERE ProductID=$id";

if (mysqli_query($conn, $query)) {
    header("Location: addproduct.php?success=true");
    exit();
} else {
    echo "Error updating product: " . mysqli_error($conn);
}
?>
