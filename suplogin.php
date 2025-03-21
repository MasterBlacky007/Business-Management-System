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
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $contact = htmlspecialchars(trim($_POST['contact']));
    $password = $_POST['password']; // Plaintext password entered by user

    // Query to check user in `lclogin` table
    $sql = "SELECT Password FROM suplogin WHERE Email = ? AND Contact = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $contact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Fetch user data from the database
        $row = $result->fetch_assoc();
        $stored_password = $row['Password']; // Password stored in the database

        // Directly compare the input password with the stored password
        if ($password === $stored_password) {
            // Successful login
            $_SESSION['Email'] = $email;
            $_SESSION['Contact'] = $contact;
            $message = "<span style='color: green;'>Login successful! </span><a href='supDashboard.html' style='color: #0072ff; text-decoration: none;'>&#8594; Go to Dashboard</a>";
        } else {
            // Incorrect password
            $message = "<span style='color: red;'>Invalid password!</span>";
        }
    } else {
        // User not found
        $message = "<span style='color: red;'>Invalid email or phone number!</span>";
    }
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login</title>
    <link rel="stylesheet" href="ologin.css">
</head>
<body>
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
            <form action="suplogin.php" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="contact">Contact:</label>
                <input type="tel" id="contact" name="contact" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <div class="message"><?php echo $message; ?></div>
            </form>
        </div>
    </main>
</body>
</html>
