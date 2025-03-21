<?php
// Database connection
include('conf.php');

// Start session to manage login state
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - View Orders</title>
    <link rel="stylesheet" href="vieworder1.css">
    <style>
        #orderTable {
            display: none; /* Hide the table initially */
        }
        .viewButton, .payButton {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }

        .payButton {
            background-color: #2196F3;
        }

        .viewButton:hover, .payButton:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Dashboard</h2>
        <ul>
        <li><a href="lfproduct.html">View Product</a></li>
            <li><a href="lfaddorder.html">Add Order</a></li>
            <li><a href="vieworder2.php">View Order</a></li>
            <!--<li><a href="production-process.html">Make Payment</a></li>-->
            <li><a href="lffeedback.php">Feedback</a></li>
            <li><a href="lfprofile.php">My Profile</a></li>
            <li><a href="lflogin.php">LogOut</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Order List</h1>
        <div class="search-container">
            <input type="text" id="iicInput" placeholder="Search by IIC">
            <input type="text" id="orderIdInput" placeholder="Search by Order ID (optional)">
            <button id="searchButton">Search</button>
        </div>

        <div class="table-container">
            <?php
            // Fetch data query
            $sql = "SELECT OrderID, ProductID, IIC, OrderDate, Quantity, Address, Amount, Payment FROM lforder";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table id='orderTable'>";
                echo "<thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product ID</th>
                            <th>IIC</th>
                            <th>Order Date</th>
                            <th>Quantity</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    $orderId = $row['OrderID'];
                    echo "<tr>
                            <td>{$row['OrderID']}</td>
                            <td>{$row['ProductID']}</td>
                            <td>{$row['IIC']}</td>
                            <td>{$row['OrderDate']}</td>
                            <td>{$row['Quantity']}</td>
                            <td>{$row['Address']}</td>
                            <td>{$row['Amount']}</td>
                            <td>{$row['Payment']}</td>
                            <td>
                                <a href='invoice2.php?orderId={$orderId}' class='viewButton'>View</a>
                                <a href='pay2.php?orderId={$orderId}' class='payButton'>Pay</a>
                            </td>
                          </tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No orders found.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="vieworder2.js"></script>
</body>
</html>
