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
    <h2>Update Transport Details</h2><br><br>
    <?php
    include 'conf.php';

    $profile = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle search
        if (!empty($_POST['search'])) {
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

        // Handle Update Details
        if (!empty($_POST['location']) && !empty($_POST['note']) && !empty($_POST['cost']) && !empty($_POST['status']) && !empty($_POST['type'])) {
            $location = trim($_POST['location']);
            $note = trim($_POST['note']);
            $cost = trim($_POST['cost']);
            $status = trim($_POST['status']);
            $type = trim($_POST['type']);
            $driver = trim($_POST['driver_id']);
            $userId = $_POST['search'];

            $updateQuery = "UPDATE transport_details SET location = ?, note = ?, cost = ?, status = ?, type = ?,driver_id=? WHERE transport_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssssi", $location, $note, $cost, $status, $type,$driver, $userId);

            if ($stmt->execute()) {
                echo "<p class='success'>Profile updated successfully!</p>";
                // Redirect to avoid resubmission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {
                echo "<p class='error'>Error updating profile. Please try again.</p>";
            }
            $stmt->close();
        }
    }
    ?>

    <form id="updateTransportForm" action="" method="POST" onsubmit="return validateForm()">
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
                <input type="text" id="cost" name="cost" value="<?php echo htmlspecialchars($profile['cost']); ?>">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($profile['status']); ?>">
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($profile['type']); ?>">
            </div>
            <div class="form-group">
                <label for="driver_id">Driver ID:</label>
                <input type="text" id="driver_id" name="driver_id" value="<?php echo htmlspecialchars($profile['driver_id']); ?>">
            </div>
            
            <div class="form-buttons">
                <button type="reset" class="btn btn-cancel">Cancel</button>
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        <?php endif; ?>
    </form>
</div>

<script>
    function validateForm() {
        const location = document.getElementById("location").value.trim();
        const note = document.getElementById("note").value.trim();
        const cost = document.getElementById("cost").value.trim();
        const status = document.getElementById("status").value.trim();
        const type = document.getElementById("type").value.trim();
        const driver = document.getElementById("driver_id").value.trim();

        // Validate location
        if (!location) {
            alert("Please enter the location.");
            document.getElementById("location").focus();
            return false;
        }

        // Validate note
        if (!note) {
            alert("Please enter the note.");
            document.getElementById("note").focus();
            return false;
        }

        // Validate cost
        if (!cost) {
            alert("Please enter the transport cost.");
            document.getElementById("cost").focus();
            return false;
        }

        if (isNaN(cost) || cost <= 0) {
            alert("Please enter a valid positive number for transport cost.");
            document.getElementById("cost").focus();
            return false;
        }

        // Validate status
        if (!status) {
            alert("Please enter the status.");
            document.getElementById("status").focus();
            return false;
        }

        // Validate type
        if (!type) {
            alert("Please enter the transport type.");
            document.getElementById("type").focus();
            return false;
        }if (!driver) {
            alert("Please enter the driver id.");
            document.getElementById("type").focus();
            return false;
        }

        // If all validations pass
        return true;
    }
</script>

</body>
</html>
