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
    $stid = $_POST['stid'];
    $stno = $_POST['stno'];
    $name = $_POST['name'];
    $month = $_POST['month'];
    $date = $_POST['date'];
    $acc = $_POST['acc'];
    $bpay = $_POST['bpay'];
    $ot = $_POST['ot'];
    $etf = $_POST['etf'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    // Insert into the database
    $sql = "INSERT INTO salary (StaffID, StaffNo, Name, Month, Date, AccountNumber, BasicPay, OT, ETF, Amount, Status) 
            VALUES ('$stid', '$stno', '$name', '$month', '$date', '$acc', '$bpay', '$ot', '$etf', '$amount', '$status')";

    if (mysqli_query($conn, $sql)) {
        $successMessage = "Staff record added successfully!";
        echo "<script>
                alert('Staff record added successfully!');
                window.location.href = 'gensalary.php';
              </script>";
    } else {
        $successMessage = "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "<script>
                alert('Failed to add staff record. Please try again.');
              </script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Staff Record</title>
    <link rel="stylesheet" href="gensalary.css">
    <script>
        function calculateSalary() {
            const bpay = parseFloat(document.getElementById('bpay').value) || 0;
            const ot = parseFloat(document.getElementById('ot').value) || 0;
            const etf = bpay * 0.15; // ETF is 15% of basic pay
            const adjustedPay = bpay + (ot * 100); // Example: OT adds $100/hour
            const amount = adjustedPay - etf;

            document.getElementById('etf').value = etf.toFixed(2);
            document.getElementById('amount').value = amount.toFixed(2);
        }
    </script>
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
            <h2>Generate Salary</h2>
            
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <label for="stid">Staff ID</label>
                <input type="text" id="stid" name="stid" required>

                <label for="stno">Staff No</label>
                <input type="text" id="stno" name="stno" required>

                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="month">Month</label>
                <input type="text" id="month" name="month" required>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <label for="acc">Account Number</label>
                <input type="text" id="acc" name="acc" required>

                <label for="bpay">Basic Pay</label>
                <input type="number" id="bpay" name="bpay" oninput="calculateSalary()" required>

                <label for="ot">OT Hours</label>
                <input type="number" id="ot" name="ot" oninput="calculateSalary()" required>

                <label for="etf">ETF</label>
                <input type="number" id="etf" name="etf" readonly>

                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" readonly>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Active">Active</option>
                </select>

                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
