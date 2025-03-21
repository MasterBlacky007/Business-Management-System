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
    $taskname = $_POST['taskname'];
    $description = $_POST['description'];
    $assignby = $_POST['assignby'];
    $assignto = $_POST['assignto'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $status = $_POST['status'];

    // Insert into the database
    $sql = "INSERT INTO task (taskname, discription, assignby, assignto, startdate, enddate, sstatus) 
            VALUES ('$taskname', '$description', '$assignby', '$assignto', '$startdate', '$enddate', '$status')";

    if (mysqli_query($conn, $sql)) {
        // Get the last inserted task ID
        $taskID = mysqli_insert_id($conn);
        $successMessage = "Task added successfully! Task ID: " . $taskID;

        // Display success message using JavaScript
        echo "<script>
                alert('Task added successfully! Task ID: " . $taskID . "');
                window.location.href = 'assigntask.php'; // Optional: reload the page after showing message
              </script>";
    } else {
        // Display error message
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        
        // Display failure message using JavaScript
        echo "<script>
                alert('Failed to add task. Please try again.');
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
    <title>Create Task</title>
    <link rel="stylesheet" href="taskassign.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="pprocess.php">Production Process</a></li>
            <li><a href="viewcostreport1.html">Cost Report</a></li>
            <li><a href="gensalary.php">Generate Salary</a></li>
            <li><a href="facviewpay.php">Supplier Payment</a></li>
            <li><a href="salarystatus.php">Salary Status</a></li>
            <li><a href="grevenue.php">Generate Revenue</a></li>
            <li><a href="updatedelivery.php">Update Delivery</a></li>
            <li><a href="facmaapprove.php">Approve Request</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="stockstatus.html">Stock Status</a></li>
            <li><a href="performancereport.html">Performance Report</a></li>
            <li><a href="assign-task.html">Assigning Task</a></li>
            <li><a href="faimportorder.php">Import Order</a></li>
            <li><a href="viewfeedback.php">Feedback</a></li>
            <li><a href="facexportorder.html">Export Order</a></li>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>Create Task</h2>
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="assigntask.php" method="POST">
                <label for="taskname">Task Name</label>
                <input type="text" id="taskname" name="taskname" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>

                <label for="assignby">Assigned By</label>
                <input type="text" id="assignby" name="assignby" required>

                <label for="assignto">Assigned To</label>
                <input type="text" id="assignto" name="assignto" required>

                <label for="startdate">Start Date</label>
                <input type="date" id="startdate" name="startdate" required>

                <label for="enddate">End Date</label>
                <input type="date" id="enddate" name="enddate" required>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Assign">Assign</option>
                    <option value="Assigned">Assigned</option>
                </select>

                <button type="submit">Submit Task</button>
            </form>
        </div>
    </main>
</body>
</html>
