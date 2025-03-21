<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Edit Profile</title>
    <link rel="stylesheet" href="view_profile.css">
</head>
<body>

<div class="profile-container">
    <h2>View and Edit Your Profile</h2>
    <?php
    include 'config.php';

    $profile = null;
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle search
        if (!empty($_POST['search'])) {
            $userId = trim($_POST['search']);
            $query = "SELECT First_Name, Last_Name, NIC_number, Email, Mobile_Number, Lane_Number, Gender, date_of_birth, Age, SAddress, photo, em_no, job_rol, skill, Profile_ID FROM profiles WHERE staf_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $profile = $result->fetch_assoc();
            } else {
                $error = "No profile found with ID $userId.";
            }
            $stmt->close();
        }

        // Handle save
        if (isset($_POST['fname'])) {
            // Gather form inputs and sanitize
           
            $fname = trim($_POST['fname']);
            $lname = trim($_POST['lname']);
            $nic = trim($_POST['nic']);
            $email = trim($_POST['email']);
            $mphone = trim($_POST['mphone']);
            $lphone = trim($_POST['lphone']);
            $gender = trim($_POST['gender']);
            $dob = trim($_POST['dob']);
            $age = trim($_POST['age']);
            $address = trim($_POST['address']);
            $photo = isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK ? basename($_FILES['photo']['name']) : trim($_POST['current_photo']);
            $em_no = trim($_POST['em_no']);
            $job_rol = trim($_POST['job_rol']);
            $skill = trim($_POST['skill']);
            $profileId = trim($_POST['profile_id']);

            // Validate inputs
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } elseif (!preg_match('/^[0-9]{10}$/', $mphone)) {
                $error = "Mobile number must be 10 digits.";
            } elseif ($dob && strtotime($dob) > strtotime('today')) {
                $error = "Date of birth cannot be in the future.";
            } else {
                // Handle file upload
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $targetDir = "uploads/";
                    $targetFile = $targetDir . basename($_FILES['photo']['name']);
                    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    // Validate file type
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array($fileType, $allowedTypes)) {
                        $error = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
                    } elseif (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                        $error = "Error uploading photo.";
                    }
                }

                // Update profile in the database if there are no errors
                if (empty($error)) {
                    $updateQuery = "UPDATE profiles SET Profile_ID = ?, First_Name = ?, Last_Name = ?, NIC_number = ?, Email = ?, Mobile_Number = ?, Lane_Number = ?, Gender = ?, date_of_birth = ?, Age = ?, SAddress = ?, photo = ?, em_no = ?, job_rol = ?, skill = ? WHERE staf_id = ?";
                    $stmt = $conn->prepare($updateQuery);

                    // Ensure variables are bound correctly
                    $stmt->bind_param("sssssssssssssssi", $profileId, $fname, $lname, $nic, $email, $mphone, $lphone, $gender, $dob, $age, $address, $photo, $em_no, $job_rol, $skill, $sid);

                    if ($stmt->execute()) {
                        $success = "Profile updated successfully!";
                    } else {
                        $error = "Error updating profile: " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        }
    }
    ?>

    <!-- Search Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="sea">
            <input class="sea" type="text" id="search" name="search" placeholder="Enter User ID to Search"
                   value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
            <input class="seabut" type="submit" value="Search">
        </div>

        <!-- Display Error or Success Message -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Display Profile Form if a Profile is Found -->
        <?php if ($profile): ?>
        <div class="profile-layout">
            <section>
                <div class="profile-photo">
                    <?php
                    $imagePath = 'uploads/' . $profile['photo'];
                    if (file_exists($imagePath)) {
                        echo "<img src=\"$imagePath\" alt=\"Profile Photo\">";
                    } else {
                        echo "<img src=\"uploads/default-profile.jpg\" alt=\"Profile Photo\">";
                    }
                    ?>
                </div>
            </section>

            <div class="profile-form">
                <input type="hidden" name="profile_id" value="<?php echo htmlspecialchars($profile['Profile_ID']); ?>">
                <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($profile['photo']); ?>">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($profile['First_Name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($profile['Last_Name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nic">NIC Number:</label>
                    <input type="text" id="nic" name="nic" value="<?php echo htmlspecialchars($profile['NIC_number']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['Email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="mphone">Mobile Phone:</label>
                    <input type="text" id="mphone" name="mphone" value="<?php echo htmlspecialchars($profile['Mobile_Number']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lphone">Lane Phone:</label>
                    <input type="text" id="lphone" name="lphone" value="<?php echo htmlspecialchars($profile['Lane_Number']); ?>">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($profile['Gender']); ?>">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>">
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($profile['Age']); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($profile['SAddress']); ?>">
                </div>
                <div class="form-group">
                    <label for="photo">Upload Photo:</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="em_no">Employee No:</label>
                    <input type="text" id="em_no" name="em_no" value="<?php echo htmlspecialchars($profile['em_no']); ?>">
                </div>
                <div class="form-group">
                    <label for="job_rol">Job Role:</label>
                    <input type="text" id="job_rol" name="job_rol" value="<?php echo htmlspecialchars($profile['job_rol']); ?>">
                </div>
                <div class="form-group">
                    <label for="skill">Skills:</label>
                    <input type="text" id="skill" name="skill" value="<?php echo htmlspecialchars($profile['skill']); ?>">
                </div>

                <button type="submit">Save Changes</button>
            </div>
        </div>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
