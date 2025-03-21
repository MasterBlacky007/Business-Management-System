<?php
include 'conf.php'; // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['Name']);
    $price = $conn->real_escape_string($_POST['Price']);

    // Handle file upload
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create uploads directory if not exists
    }

    $fileName = basename($_FILES['Image']['name']);
    $filePath = $uploadDir . $fileName;

    // Validate and move the uploaded file
    if (move_uploaded_file($_FILES['Image']['tmp_name'], $filePath)) {
        // Insert product details into the database
        $sql = "INSERT INTO product (Name, Price, Image) VALUES ('$name', '$price', '$filePath')";
        if ($conn->query($sql) === TRUE) {
            header('Location: addproduct.php'); // Redirect back to product page
            exit();
        } else {
            echo "Error inserting product: " . $conn->error;
        }
    } else {
        echo "Failed to upload the image.";
    }
}

$conn->close();
?>
