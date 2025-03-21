<?php
include 'conf.php';

$successMessage = ''; // Variable to hold the success message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $type = $_POST['type'] ?? '';
    $note = $_POST['note'] ?? '';
    $discription = $_POST['discription'] ?? '';

    // Validation
    if (empty($type) || empty($note) || empty($discription)) {
        $successMessage = "<p style='color: red;'>All required fields must be filled.</p>";
    } else {
        // Escaping inputs to prevent SQL injection
        $type = mysqli_real_escape_string($conn, $type);
        $note = mysqli_real_escape_string($conn, $note);
        $discription = mysqli_real_escape_string($conn, $discription);

        // Insert data into the database
        $sql = "INSERT INTO dissues (Type, Note, Description) 
                VALUES ('$type', '$note', '$discription')";

        if (mysqli_query($conn, $sql)) {
            $successMessage = "<p style='color: green;'>Record added successfully!</p>";
        } else {
            $successMessage = "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "No data received.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Issues</title>
    <link rel="stylesheet" href="issues.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
            <li><a href="dilivery_confermation.html">Delivery Confirmation</a></li>
            <li><a href="add_issues.php">Issues</a></li>
            <li><a href="view_task.php">View Task</a></li>
            <li><a href="add_driver_status.html">Add Driver Status</a></li>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="Home.html">LogOut</a></li>
        </ul>
    </aside>

    <main>
        <div class="container">
            <!-- Form Section -->
            <div class="form-section">
                <h2>Add Delivery Issues</h2><br><br>
                <form action="add_issues.php" method="POST" onsubmit="return validateForm()">
                    
                    
                    <div>
                        <label for="type">Delivery Issue Type:</label>
                        <select name="type" id="type">
                            <option value="">Select Issue Type</option>
                            <option value="Delayed Delivery">Delayed Delivery</option>
                            <option value="Wrong Address">Wrong Address</option>
                            <option value="Damaged Item">Damaged Item</option>
                            <option value="Lost Package">Lost Package</option>
                            <option value="Incorrect Item">Incorrect Item</option>
                            <option value="Customer Unavailable">Customer Unavailable</option>
                        </select>
                        <span class="error" id="typeError"></span>
                    </div>
                    
                    <div>
                        <label for="note">Note:</label>
                        <input type="text" id="note" name="note" placeholder="Enter Note">
                        <span class="error" id="noteError"></span>
                    </div>
                    
                    <div>
                        <label for="discription">Description:</label>
                        <textarea name="discription" id="discription" rows="5" style="width: 100%;"></textarea>
                        <span class="error" id="descriptionError"></span>
                    </div><br><br>
                    <!-- Displaying Success or Error Message Above the Button -->
                    <?php
                    if (!empty($successMessage)) {
                        echo $successMessage; // Display the message above the button
                    }
                    ?>
                    
                    
                    <div class="save-button">
                        <button type="submit">Add Issue</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function validateForm() {
            let isValid = true;

            // Get form inputs
            const type = document.getElementById('type');
            const note = document.getElementById('note');
            const description = document.getElementById('discription');

            // Get error message elements
            const typeError = document.getElementById('typeError');
            const noteError = document.getElementById('noteError');
            const descriptionError = document.getElementById('descriptionError');

            // Reset error messages
            typeError.textContent = '';
            noteError.textContent = '';
            descriptionError.textContent = '';

            // Validate Delivery Issue Type
            if (type.value === '') {
                typeError.textContent = 'Please select a delivery issue type.';
                isValid = false;
            }

            // Validate Note
            if (note.value.trim() === '') {
                noteError.textContent = 'Please enter a note.';
                isValid = false;
            }

            // Validate Description
            if (description.value.trim() === '') {
                descriptionError.textContent = 'Please enter a description.';
                isValid = false;
            }

            return isValid; // Return true if the form is valid
        }
    </script>
</body>
</html>
