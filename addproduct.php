<?php
include 'conf.php'; // Include your database connection file

// Fetch products from the database
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="apstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Add Product</h1>
            <p>Manage your products with names, prices, and images.</p>
        </header>

        <!-- Add Product Section -->
        <section class="form-section">
            <form name="Productmanage" action="Doproduct.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="Name" id="productName" placeholder="Product Name" required>
                <input type="number" name="Price" id="productPrice" placeholder="Product Price" required>
                <input type="file" name="Image" id="productImage" accept="" required>
                <button type="submit">Add Product</button>
            </form>
        </section>

        <!-- Product List Section -->
        <section class="table-section">
            <h2>Product List</h2>
            <table id="productTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch products from the database
                    $query = "SELECT * FROM product";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><img src='" . $row['Image'] . "' alt='" . $row['Name'] . "'></td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>$" . $row['Price'] . "</td>";
                        echo "<td>
                                <a href='editproduct.php?id=" . $row['ProductID'] . "'>Edit</a> |
                                <a href='deleteproduct.php?id=" . $row['ProductID'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            
        </section>
        <a href="pmDashboard.html"> 
            <input type="button" value="Back" id="productmanage"> </a>
    </div>
</body>
</html>
