<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['suid'])) {
    // Get form data
    $suid = $_POST['suid'];
    $oid = $_POST['oid'];
    $pdate = $_POST['pdate'];
    $currency = $_POST['currency'];
    $amount = $_POST['amount'];
    $pmethod = $_POST['pmethod'];
    $status = 'Active';

    // Insert into appropriate payment table based on payment method
    $sql = "";
    if ($pmethod == 'credit') {
        $sql = "INSERT INTO credit_payments (SupplierID, OrderID, PaymentDate, Currency, Amount, Status) 
                VALUES (?, ?, ?, ?, ?, ?)";
    } elseif ($pmethod == 'debit') {
        $sql = "INSERT INTO debit_payments (SupplierID, OrderID, PaymentDate, Currency, Amount, Status) 
                VALUES (?, ?, ?, ?, ?, ?)";
    } elseif ($pmethod == 'paypal') {
        $sql = "INSERT INTO paypal_payments (SupplierID, OrderID, PaymentDate, Currency, Amount, Status) 
                VALUES (?, ?, ?, ?, ?, ?)";
    }

    // Use prepared statements to prevent SQL injection
    if ($sql != "") {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iissds', $suid, $oid, $pdate, $currency, $amount, $status);

        if (mysqli_stmt_execute($stmt)) {
            // Insert also into the spayment table
            $sql_spayment = "INSERT INTO spayment (SupplierID, OrderID, PaymentDate, Currency, Amount, Method, Status) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_spayment = mysqli_prepare($conn, $sql_spayment);
            mysqli_stmt_bind_param($stmt_spayment, 'iissdss', $suid, $oid, $pdate, $currency, $amount, $pmethod, $status);

            if (mysqli_stmt_execute($stmt_spayment)) {
                // Payment was successfully added to both tables
                $pID = mysqli_insert_id($conn);
                $invoiceData = [
                    'Payment ID' => $pID,
                    'Supplier ID' => $suid,
                    'Order ID' => $oid,
                    'Payment Date' => $pdate,
                    'Currency' => $currency,
                    'Amount' => $amount,
                    'Payment Method' => ucfirst($pmethod),
                    'Status' => ucfirst($status)
                ];
            } else {
                echo "<script>alert('Failed to add payment to spayment table. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Failed to add payment to selected payment method table. Please try again.');</script>";
        }
    }
}

// Handle AJAX request to fetch 'amount' value based on 'oid' and 'suid'
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['oid']) && isset($_GET['suid'])) {
    $oid = $_GET['oid'];
    $suid = $_GET['suid'];
    // Ensure the column name 'OrderAmount' exists in your table
    $query = "SELECT OrderAmount as oa FROM sgenpay WHERE OrderID = '$oid' AND SupplierID = '$suid'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['oa'];
    } else {
        echo "0";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Payment</title>
    <link rel="stylesheet" href="Famakepay1.css">
    <script>
        // Function to fetch amount based on Order ID and Supplier ID
        function fetchAmount() {
            const oid = document.getElementById('oid').value;
            const suid = document.getElementById('suid').value;
            if (oid && suid) {
                fetch('Famakepay.php?oid=' + oid + '&suid=' + suid)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('amount').value = data || '';
                    })
                    .catch(error => console.error('Error fetching amount:', error));
            }
        }

        // Function to print the invoice
        function printInvoice() {
            const invoice = document.getElementById('invoice');
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Invoice</title></head><body>');
            printWindow.document.write(invoice.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
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
            <h2>Supplier Payment Form</h2>
            <form action="Famakepay.php" method="POST">
                <label for="suid">Supplier ID</label>
                <input type="text" id="suid" name="suid" required onblur="fetchAmount()">

                <label for="oid">Order ID</label>
                <input type="text" id="oid" name="oid" required onblur="fetchAmount()">

                <label for="pdate">Payment Date</label>
                <input type="date" id="pdate" name="pdate" required>

                <label for="currency">Currency</label>
                <input type="text" id="currency" name="currency" required>

                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" readonly required>

                <fieldset>
                    <legend>Payment Method:</legend>
                    <label for="credit">Credit</label>
                    <input type="radio" id="credit" name="pmethod" value="credit" required>
                    <label for="debit">Debit</label>
                    <input type="radio" id="debit" name="pmethod" value="debit" required>
                    <label for="paypal">PayPal</label>
                    <input type="radio" id="paypal" name="pmethod" value="paypal" required>
                </fieldset>

                <button type="submit">Submit Payment</button>
            </form>

            <?php if (isset($invoiceData)) { ?>
            <div id="invoice">
                <h3>Payment Invoice</h3>
                <ul>
                    <?php foreach ($invoiceData as $key => $value) { ?>
                        <li><strong><?php echo $key; ?>:</strong> <?php echo $value; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <button onclick="printInvoice()">Print Invoice</button>
            <?php } ?>
        </div>
    </main>
</body>
</html>
