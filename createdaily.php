<?php
include 'conf.php';

// Initialize variables
$productName = $todaySell = $date = "";
$message = ""; // Variable for message
$alertType = ""; // Variable for JavaScript alert type

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $productName = mysqli_real_escape_string($conn, $_POST['product_name']);
    $todaySell = mysqli_real_escape_string($conn, $_POST['today_sell']);
    $todayCreate = mysqli_real_escape_string($conn, $_POST['today_create']);
    $balance = mysqli_real_escape_string($conn, $_POST['balance']);
    $todayAmount = mysqli_real_escape_string($conn, $_POST['today_amount']);
    $createAmount = mysqli_real_escape_string($conn, $_POST['create_amount']);
    $todayRevanew = mysqli_real_escape_string($conn, $_POST['today_revanew']);
    $date = mysqli_real_escape_string($conn, $_POST['date']); // Get the date

    // Insert the form data into the database without order_id
    $sql = "INSERT INTO daily_report (product_name, today_sell, today_create, balance, today_amount, create_amount, today_revanew, date)
            VALUES ('$productName', '$todaySell', '$todayCreate', '$balance', '$todayAmount', '$createAmount', '$todayRevanew', '$date')";

    if (mysqli_query($conn, $sql)) {
        $message = "Record added successfully.";
        $alertType = "success";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        $alertType = "error";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Daily Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        h1 {
            text-align: center;
            margin-top: 50px;
            color: #4CAF50;
            font-size: 36px;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 2fr;
            grid-gap: 15px;
            padding: 20px;
        }

        label {
            font-weight: bold;
            font-size: 16px;
        }

        input[type="text"], input[type="date"] {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group input[type="text"], .form-group input[type="date"] {
            width: 80%;
        }

        .message {
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: #ff0000;
        }

        .success {
            color: #4CAF50;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            form {
                grid-template-columns: 1fr;
            }
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            text-decoration: none;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
        }

        .back-btn a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <script>
        // PHP-generated message handling
        <?php if (!empty($message)) { ?>
            var message = "<?php echo $message; ?>";
            var alertType = "<?php echo $alertType; ?>";
            alert(message); // Display alert message
        <?php } ?>
    </script>

    <div class="container">
        <h1>Generate Daily Report</h1>
        <form name="orderForm" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date">
            </div>

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name">
            </div>

            <div class="form-group">
                <label for="today_sell">Today Sell:</label>
                <input type="text" name="today_sell" id="today_sell" oninput="calculateBalance()">
            </div>

            <div class="form-group">
                <label for="today_create">Today Create:</label>
                <input type="text" name="today_create" id="today_create" oninput="calculateBalance()">
            </div>

            <div class="form-group">
                <label for="balance">Balance:</label>
                <input type="text" name="balance" id="balance" readonly>
            </div>

            <div class="form-group">
                <label for="today_amount">Today Amount:</label>
                <input type="text" name="today_amount" id="today_amount" oninput="calculateBalance()">
            </div>

            <div class="form-group">
                <label for="create_amount">Create Amount:</label>
                <input type="text" name="create_amount" id="create_amount" oninput="calculateBalance()">
            </div>

            <div class="form-group">
                <label for="today_revanew">Today Revenue:</label>
                <input type="text" name="today_revanew" id="today_revanew" readonly>
            </div>

            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
            <div class="back-btn">
            <a href="dailyreortdash.html">Back </a>
        </div>
        </form>

       
    </div>

    <script>
        // Function to calculate Balance and Today Revenue
        function calculateBalance() {
            var todayCreate = parseFloat(document.getElementById('today_create').value) || 0;
            var todaySell = parseFloat(document.getElementById('today_sell').value) || 0;
            var balance = todayCreate - todaySell;
            document.getElementById('balance').value = balance.toFixed(2);

            var createAmount = parseFloat(document.getElementById('create_amount').value) || 0;
            var todayAmount = parseFloat(document.getElementById('today_amount').value) || 0;
            var todayRevenue = createAmount - todayAmount;
            document.getElementById('today_revanew').value = todayRevenue.toFixed(2);
        }

        // Form validation function
        function validateForm() {
            var productName = document.getElementById('product_name').value;
            var todaySell = document.getElementById('today_sell').value;
            var todayCreate = document.getElementById('today_create').value;
            var todayAmount = document.getElementById('today_amount').value;
            var createAmount = document.getElementById('create_amount').value;
            var date = document.getElementById('date').value;

            if (productName == "" || todaySell == "" || todayCreate == "" || todayAmount == "" || createAmount == "" || date == "") {
                alert("All fields are required.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
