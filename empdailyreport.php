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
    $pid = $_POST['pid'];
    $mid = $_POST['mid'];
    $mstock = $_POST['mstock'];
    $pstock = $_POST['pstock'];

    // Insert into the database
    $sql = "INSERT INTO edaily (pid, mid, mstock, pstock) 
            VALUES ('$pid', '$mid', '$mstock', '$pstock')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Request ID
        $requestID = mysqli_insert_id($conn);
        $successMessage = "Entry added successfully! Record ID: " . $requestID;

        // Display success message using JavaScript
        echo "<script>
                alert('Entry added successfully! Record ID: " . $requestID . "');
                window.location.href = 'empdailyreport.php';
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to add entry. Please try again.');
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
    <title>Create Entry</title>
    <link rel="stylesheet" href="empshiftrequest.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="empshiftchange.html">Shift Changes</a></li>
            <li><a href="empviewsalary.php">Salary</a></li>
            <li><a href="empaddperformance.php">Performance</a></li>
            <li><a href="empdailyreport.php">Daily Report</a></li>
            <li><a href="empviewtask.php">View Task</a></li>
            <li><a href="Eprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Daily Process</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="empdailyreport.php" method="POST">
            <div class="form-group">
                    <label for="mid">Material ID</label>
                    <input type="text" id="mid" name="mid" required>
                    <label for="minstock">Material  Stock</label>
                    <input type="number" id="minstock" name="minstock" required>
                    
                </div>
           
            <div class="form-group">
                    <label for="pid">Product ID</label>
                    <input type="text" id="pid" name="pid" required>
                    <label for="pinstock">Product Stock</label>
                    <input type="number" id="pinstock" name="pinstock" required>
                    
                </div>
             
                <div class="form-group">
                    <button type="submit">Submit </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
