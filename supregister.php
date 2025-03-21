<?php
// Include the database connection file
include('conf.php');

// Initialize message variable
$message = "";

// Process the form if it is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $doj = trim($_POST['doj']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate server-side
    if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        $message = "<span style='color: red;'>FullName should contain only letters.</span>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<span style='color: red;'>Invalid email address!</span>";
    } elseif (!ctype_digit($contact)) {
        $message = "<span style='color: red;'>Contact number should contain only numeric values.</span>";
    } elseif (empty($address)) {
        $message = "<span style='color: red;'>Address is required.</span>";
    } elseif (empty($doj)) {
        $message = "<span style='color: red;'>DOJ is required.</span>";
    } elseif (strlen($password) < 6) {
        $message = "<span style='color: red;'>Password must be at least 6 characters long.</span>";
    } elseif ($password !== $confirm_password) {
        $message = "<span style='color: red;'>Password and confirmation password do not match.</span>";
    } else {
        // Combine first and last name
        //$name = $first_name . " " . $last_name;

      

        // Begin a transaction to ensure both insertions are successful
        $conn->begin_transaction();
        try {
            // Insert into `supregister` table
            $sql_register = "INSERT INTO supregister (FullName, Email, Contact, Address, DOJ) 
                             VALUES ('$fullname', '$email', '$contact', '$address', '$doj')";
            $conn->query($sql_register);

            // Insert into `suplogin` table
            $sql_login = "INSERT INTO suplogin (Email, Contact, Password) 
                          VALUES ('$email', '$contact', '$password')";
            $conn->query($sql_login);

            // Commit the transaction
            $conn->commit();

            $message = "<span style='color: green;'>Registration successful!</span>";
        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $conn->rollback();
            $message = "<span style='color: red;'>Registration failed: " . $e->getMessage() . "</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Registration</title>
    <link rel="stylesheet" href="lcreg.css">
    <script src="validation.js" defer></script>
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
                    <li><a href="phome.html">Products</a></li>
                    <li><a href="about..html">About Us</a></li>
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

    <!-- Main Content Section -->
    <main>
        <div class="container2">
            <h1>Supplier Registration</h1>
            <form id="registration-form" action="supregister.php" method="POST">
                <div class="form-group">
                    <label for="fullname">First Name</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="contact">Contact</label>
                    <input type="tel" id="contact" name="contact" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="doj">Date of Join</label>
                    <input type="date" id="doj" name="doj" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </div>
                <button type="submit">Register</button>
                <div class="message"><?php echo $message; ?></div>
                <!-- Link to the login page -->
                <div class="login-link">
                    <p>Already have an account? <a href="suplogin.php">Login here</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
