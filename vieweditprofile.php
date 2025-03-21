<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize variables
$searchResults = [];
$errorMessage = "";

// Handle search functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $profileID = $_POST['profile_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM profiles WHERE Profile_ID = ?");
    $stmt->bind_param("i", $profileID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Filter non-empty columns
        $searchResults = array_filter($row, fn($value) => !empty($value));
    } else {
        $errorMessage = "No profile found with Profile_ID: $profileID";
    }

    $stmt->close();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="inviewtask.css">
</head>
<body>
    <!-- Sidebar -->
    
    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>View Profile</h2>
            <form action="" method="POST">
                <label for="profile_id">Profile ID</label>
                <input type="number" id="profile_id" name="profile_id" required>
                <button type="submit" name="search">Search</button>
            </form>

            <?php if ($errorMessage): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

            <?php if (!empty($searchResults)): ?>
                <div class="profile-table-container">
                    <table class="profile-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($searchResults as $key => $value): ?>
                                <tr>
                                    <td><?php echo ucfirst(str_replace("_", " ", $key)); ?></td>
                                    <td><?php echo htmlspecialchars($value); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
