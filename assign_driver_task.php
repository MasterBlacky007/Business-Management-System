<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transport Details</title>
    <link rel="stylesheet" href="assing.css">
</head>
<body>

<div class="profile-container">
    <h2>Assign Driver Tasks</h2><br><br>

    <?php
    include 'conf.php'; // Ensure this is included only once

    // Initialize variables
    $profile = null;

    // Handle search functionality
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search']) && !empty(trim($_POST['search']))) {
        $userId = trim($_POST['search']);
        $query = "SELECT * FROM transport_details WHERE transport_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profile = $result->fetch_assoc();
        } else {
            echo "<p class='error'>No profile found with ID $userId.</p>";
        }
        $stmt->close();
    }

    // Handle update functionality
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location'], $_POST['note'], $_POST['cost'], $_POST['status'], $_POST['type'], $_POST['search']) && !empty($_POST['search'])) {
        $location = trim($_POST['location']);
        $note = trim($_POST['note']);
        $cost = trim($_POST['cost']);
        $status = trim($_POST['status']);
        $type = trim($_POST['type']);
        $driver = isset($_POST['driver_id']) ? trim($_POST['driver_id']) : null;
        $userId = $_POST['search'];

        $updateQuery = "UPDATE transport_details SET location = ?, note = ?, cost = ?, status = ?, type = ?, driver_id = ? WHERE transport_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssssi", $location, $note, $cost, $status, $type, $driver, $userId);

        if ($stmt->execute()) {
            echo "<p class='success'>Profile updated successfully!</p>";
        } else {
            echo "<p class='error'>Error updating profile: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    // Handle task assignment functionality
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['driver_id'], $_POST['discription'], $_POST['adate'], $_POST['status'], $_POST['endDate'], $_POST['assignBy'], $_POST['search']) && !empty($_POST['search'])) {
        $driver_id = trim($_POST['driver_id']);
        $description = trim($_POST['discription']);
        $adate = trim($_POST['adate']);
        $status = trim($_POST['status']);
        $endDate = trim($_POST['endDate']);
        $assignBy = trim($_POST['assignBy']);
        $tid = trim($_POST['search']);

        $insertQuery = "INSERT INTO task (taskname, discription,assignby, assignto, startdate, enddate, sstatus) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssssss", $tid, $assignBy, $driver_id, $description, $endDate, $status, $adate);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Task added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error adding task: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
    ?>

    <form id="updateTransportForm" action="" method="POST">
        <div class="sea">
            <input class="sea" type="text" id="search" name="search" placeholder="Enter Transport ID to Search" 
                   value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
            <input class="seabut" type="submit" value="Search">
        </div>

        <?php if ($profile): ?>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($profile['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="note">Note:</label>
                <input type="text" id="note" name="note" value="<?php echo htmlspecialchars($profile['note']); ?>" required>
            </div>
            <div class="form-group">
                <label for="cost">Transport Cost:</label>
                <input type="text" id="cost" name="cost" value="<?php echo htmlspecialchars($profile['cost']); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($profile['status']); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($profile['type']); ?>" required>
            </div>
            <div class="form-group">
                <label for="assignBy">Assigned By:</label>
                <input type="text" id="assignBy" name="assignBy" value="Transport Manager" required>
            </div>
            <div class="form-group">
                <label for="driver_id">Driver ID:</label>
                <input type="text" id="driver_id" name="driver_id" value="<?php echo htmlspecialchars($profile['driver_id']); ?>" required>
            </div>
            <div class="form-group">
                <label for="discription">Description:</label>
                <input type="text" id="discription" name="discription" required>
            </div>
            <div class="form-group">
                <label for="adate">Assign Date:</label>
                <input type="date" id="adate" name="adate" required>
            </div>
            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" required>
            </div>

            <div class="form-buttons">
                <button type="reset" class="btn btn-cancel">Cancel</button>
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        <?php endif; ?>
    </form>
</div>

<script src="updateTransport.js"></script>

</body>
</html>
