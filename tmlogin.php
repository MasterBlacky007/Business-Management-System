<?php
// Include the database configuration file
require_once 'conf.php';

// Initialize message variable
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Query to check user
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login
        $message = "<span style='color: green;'>Login successful! </span><a href='tmDashboard.html' style='color: #0072ff; text-decoration: none;'>&#8594; Go to Dashboard</a>";
    } else {
        // Failed login
        $message = "<span style='color: red;'>Invalid email or password!</span>";
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
                    <li><a href="login.html">Products</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">FAQs</a></li>
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
            <form action="tmlogin.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
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
