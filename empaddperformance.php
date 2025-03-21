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
    $jrole = $_POST['jrole'];
    $skill = $_POST['skill'];

    // Insert into the database
    $sql = "INSERT INTO eperformance (eno, jrole, skill) 
            VALUES ('$eno', '$jrole', '$skill')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted Employee ID
        $empID = mysqli_insert_id($conn);
        $successMessage = "Employee details added successfully!";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <title>Employee Details</title>
    <link rel="stylesheet" href="empaddperformance.css">
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
            <h2>Add Performance</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="empaddperformance.php" method="POST">
                <label for="eno">Employee No</label>
                <input type="text" id="eno" name="eno" required>

                <label for="jrole">Job Role</label>
                <input type="text" id="jrole" name="jrole" required>

                <label for="skill">Skill</label>
                <input type="text" id="skill" name="skill" required>

                <button type="submit">Submit </button>
            </form>

            
        </div>
    </main>
</body>
</html>
