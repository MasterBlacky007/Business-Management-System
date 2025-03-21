<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize the success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $mid = $_POST['mid'];
    $quantity = $_POST['quantity'];
    $rsdate = $_POST['rsdate'];
    $status = $_POST['status'];


    // Insert into the database
    $sql = "INSERT INTO mrequest (mid, quantity, rsdate, status) 
            VALUES ('$mid', '$quantity', '$rsdate', 'pending')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Request ID
        $requestID = mysqli_insert_id($conn);
        $successMessage = "Material request added successfully! Request ID: " . $requestID;

        // Display success message using JavaScript
        echo "<script>
                alert('Material request added successfully! Request ID: " . $requestID . "');
                window.location.href = 'supemarequest.php'; // Optional: reload the page after showing message
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to add material request. Please try again.');
              </script>";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Material Request</title>
    <link rel="stylesheet" href="empshiftrequest.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="superviewshiftchange.php">Shift Changes</a></li>
            <li><a href="supermatirial.html">Material Status</a></li>
            <li><a href="supemarequest.html">Material Request</a></li>
            <li><a href="superassigntask.php">Assign Task</a></li>
            <li><a href="supedailyreport.html">Daily Report</a></li>
            <li><a href="superviewtask.php">View Task</a></li>
            <li><a href="SPprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Create Material Request</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="supemarequest.php" method="POST">
                <label for="mid">Material ID</label>
                <input type="text" id="mid" name="mid" required>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>

                <label for="rsdate">Required Start Date</label>
                <input type="date" id="rsdate" name="rsdate" required>

                <button type="submit">Submit Request</button>
            </form>
        </div>
    </main>
</body>
</html>
