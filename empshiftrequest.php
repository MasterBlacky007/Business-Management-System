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
    $eno = $_POST['eno'];
    $date = $_POST['date'];
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];
    $status = $_POST['status'];

    // Insert into the database
    $sql = "INSERT INTO shift (eno, date, stime, etime, status) 
            VALUES ('$eno', '$date', '$stime', '$etime','pending')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Shift ID
        $shiftID = mysqli_insert_id($conn);
        $successMessage = "Shift added successfully! Shift ID: " . $shiftID;

        // Display success message using JavaScript
        echo "<script>
                alert('Shift added successfully! Shift ID: " . $shiftID . "');
                window.location.href = 'empshiftrequest.php'; // Optional: reload the page after showing message
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);

        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to add shift. Please try again.');
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
    <title>Create Shift</title>
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
            <h2>Change Shift</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="empshiftrequest.php" method="POST">
                <label for="eno">Employee No</label>
                <input type="text" id="eno" name="eno" required>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <label for="stime">Start Time</label>
                <input type="time" id="stime" name="stime" required>

                <label for="etime">End Time</label>
                <input type="time" id="etime" name="etime" required>

                <button type="submit">Submit Shift</button>
            </form>
        </div>
    </main>
</body>
</html>
