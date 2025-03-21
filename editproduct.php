<?php
include 'conf.php';

// Get the product ID from the URL
$id = $_GET['id'];

// Fetch product details from the database
$query = "SELECT * FROM product WHERE ProductID = $id";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error fetching product: " . mysqli_error($conn);
    exit();
}

$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="pedit.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Product</h1>
            <p>Update the product details below</p>
        </header>

        <form action="udproduct.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['ProductID']; ?>">

            <div class="form-row">
                <label for="name">Product Name:</label>
                <input type="text" name="Name" id="name" value="<?php echo $product['Name']; ?>" required>
            </div>

            <div class="form-row">
                <label for="price">Product Price:</label>
                <input type="number" name="Price" id="price" value="<?php echo $product['Price']; ?>" required>
            </div>

            <div class="form-row">
                <label for="image">Product Image :</label>
                <input type="text" name="Image" id="image" value="<?php echo $product['Image']; ?>" required>
            </div>


            <!-- Buttons container for horizontal layout -->
            <div class="button-container">
                <button type="submit">Update Product</button>
                <a href="addproduct.php">
                    <input type="button" value="Back" id="productmanage">
                </a>
            </div>
        </form>
    </div>
</body>
</html>
