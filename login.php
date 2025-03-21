<?php
// Include the database connection from conf.php
include('conf.php');

// Start session to manage login state
session_start();

// Initialize error message
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $email = $_POST['email'];
    $phone = $_POST['phonenumber'];
    $password = $_POST['password'];

    // Query to check if the user exists with the given email and phone
    $sql = "SELECT password FROM lclogin WHERE Email = '$email' AND Contact = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, fetch the password
        $row = $result->fetch_assoc();
        if ($password === $row['password']) { // Plaintext password comparison
            // Password is correct, set session variables
            $_SESSION['Email'] = $email;
            $_SESSION['Contact'] = $phone;
            // Redirect to the homepage or dashboard after login
            header("Location: Home.html");
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid password!";
        }
    } else {
        // User with the given email and phone does not exist
        $error_message = "Invalid email or phone number!";
    }
}

// Close the connection
$conn->close();
?>