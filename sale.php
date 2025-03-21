<?php
// Include database connection
include('conf.php');
session_start();

// Initialize variables
$successMessage = "";
$errorMessage = "";
$pname = "";
$uprise = "";

// Fetch product details if Product ID is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pID'])) {
    $pID = $_POST['pID'];
    $sql = "SELECT product_name, unite_price FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $pID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $pname = $product['product_name'];
            $uprise = $product['unite_price'];
        } else {
            $errorMessage = "Product not found.";
        }
    } else {
        $errorMessage = "Error preparing statement: " . $conn->error;
    }
}

// Handle form submission for creating a sale record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_sale'])) {
    $pID = $_POST['pID'];
    $pname = $_POST['pname'];
    $quantity = $_POST['quantity'];
    $uprise = $_POST['uprise'];
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];
    $rdate = $_POST['rdate'];

    // Prepare SQL statement to insert the sale record
    $sql = "INSERT INTO sale (pID, pname, quantity, uprise, amount, duration, rdate) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("isiddss", $pID, $pname, $quantity, $uprise, $amount, $duration, $rdate);
        
        // Execute the query and handle success/error
        if ($stmt->execute()) {
            $saleID = $stmt->insert_id;
            $successMessage = "Sale record added successfully! Sale ID: " . $saleID;
        } else {
            $errorMessage = "Error adding sale record: " . $stmt->error;
        }
    } else {
        $errorMessage = "Error preparing statement: " . $conn->error;
    }
}

// Close database connection and statement if set
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Sale Record</title>
    <link rel="stylesheet" href="empshiftrequest.css">
    <script>
        // Function to calculate total amount
        function calculateAmount() {
            const quantity = document.getElementById('quantity').value;
            const unitPrice = document.getElementById('uprise').value;
            const totalAmount = quantity * unitPrice;
            document.getElementById('amount').value = totalAmount.toFixed(2); // Two decimal places
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
            <li><a href="sale.php">Sales</a></li>
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
            <h2>Create Sale Record</h2>

            <!-- Display success or error message -->
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if ($errorMessage): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <!-- Main Form for sale record -->
            <form action="sale.php" method="POST">
                <label for="pID">Product ID</label>
                <input type="text" id="pID" name="pID" value="<?php echo isset($_POST['pID']) ? $_POST['pID'] : ''; ?>" required onchange="this.form.submit()">

                <label for="pname">Product Name</label>
                <input type="text" id="pname" name="pname" value="<?php echo $pname; ?>" readonly>

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required oninput="calculateAmount()">

                <label for="uprise">Unit Price</label>
                <input type="number" id="uprise" name="uprise" value="<?php echo $uprise; ?>" readonly>

                <label for="amount">Total Amount</label>
                <input type="number" id="amount" name="amount" readonly>

                <label for="duration">Duration</label>
                <input type="date" id="duration" name="duration" required>

                <label for="rdate">Restock Date</label>
                <input type="date" id="rdate" name="rdate" required>

                <button type="submit" name="create_sale">Submit Sale</button>
            </form>
        </div>
    </main>
</body>
</html>
