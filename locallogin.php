<?php
// Include the database configuration file
require_once 'conf.php';

// Start session to manage login state
session_start();

// Initialize message variable
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phonenumber']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Query to check user
    $sql = "SELECT password FROM login WHERE email = '$email' AND phonenumber = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user password
        $row = $result->fetch_assoc();
        if ($password === $row['password']) { // Plaintext password comparison
            // Successful login
            $_SESSION['email'] = $email;
            $_SESSION['phonenumber'] = $phone;
            $message = "<span style='color: green;'>Login successful!</span> <a href='ldashboard.html' style='color: #0072ff; text-decoration: none;'>&#8594; Go to Dashboard</a>";
        } else {
            // Incorrect password
            $message = "<span style='color: red;'>Invalid password!</span>";
        }
    } else {
        // User not found
        $message = "<span style='color: red;'>Invalid email or phone number!</span>";
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="ologin.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container1">
            <div class="logo">
                <img src="images/i1.png" alt="Logo" class="logo-img">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="Products.html">Products</a></li>
                    <li><a href="About.html">About Us</a></li>
                    <li><a href="FAQs.html">FAQs</a></li>
                </ul>
                <div class="buttons">
                    <a href="RegDashboard.html" class="btn">Register</a>
                    <a href="StDashboard.html" class="btn">Staff</a>
                    <a href="ClDashboard.html" class="btn">Client</a>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div class="login-container">
            <h2>Login</h2>
            <form action="locallogin.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="phonenumber">Phone Number:</label>
                <input type="text" id="phonenumber" name="phonenumber" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Login</button>
                <!-- Display message -->
                <div class="message"><?php echo $message; ?></div>
            </form>
        </div>
    </main>
</body>
</html>
