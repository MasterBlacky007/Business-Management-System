<?php 
include('conf.php');  // Include your database configuration

// Start session to manage login state
session_start();
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedbackType = $_POST['feedbackType'];
    $description = $_POST['description'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    $name = $firstName . " " . $lastName;

    $sql = "INSERT INTO lffeedback (FeedbackType, Name, Email, Discription)
            VALUES ('$feedbackType', '$name', '$email', '$description')";

    if ($conn->query($sql) === TRUE) {
        $message = "Thank you for your feedback! Your feedback ID is: " . $conn->insert_id;
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="lffeedback.css">
    <style>
        /* Inline CSS for displaying the message */
        .message {
            color: green;
            font-weight: bold;
            display: block;
            margin-bottom: 15px; /* Adds space below the message */
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="lfproduct.html">View Product</a></li>
            <li><a href="lfaddorder.html">Add Order</a></li>
            <li><a href="vieworder2.php">View Order</a></li>
            <!--<li><a href="production-process.html">Make Payment</a></li>-->
            <li><a href="lffeedback.php">Feedback</a></li>
            <li><a href="lfprofile.php">My Profile</a></li>
            <li><a href="lflogin.php">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <h1>Feedback Form</h1>

        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <!-- Feedback Form -->
        <form action="lffeedback.php" method="POST">
            <!-- Feedback Type -->
            <label for="feedbackType">Feedback Type:</label>
            <div class="feedback-type">
                <label><input type="radio" id="comments" name="feedbackType" value="Comments" required> Comments</label>
                <label><input type="radio" id="suggestions" name="feedbackType" value="Suggestions"> Suggestions</label>
                <label><input type="radio" id="questions" name="feedbackType" value="Questions"> Questions</label>
            </div>

            <!-- Description -->
            <label for="description">Describe Your Feedback:</label>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

            <!-- Name -->
            <label for="name">Name:</label>
            <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
            <input type="text" id="lastName" name="lastName" placeholder="Last Name"><br><br>

            <!-- Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="example@example.com" required><br><br>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </main>
</body>
</html>
