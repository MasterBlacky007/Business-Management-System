<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data with validation and sanitization
    $sid = filter_input(INPUT_POST, 'sid', FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $nic = filter_input(INPUT_POST, 'nic', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $mobileNumber = filter_input(INPUT_POST, 'mobile_number', FILTER_SANITIZE_STRING);
    $laneNumber = filter_input(INPUT_POST, 'lane_number', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $em_no = filter_input(INPUT_POST, 'em_no', FILTER_SANITIZE_STRING);
    $job_rol = filter_input(INPUT_POST, 'job_rol', FILTER_SANITIZE_STRING);
    $skill = filter_input(INPUT_POST, 'skill', FILTER_SANITIZE_STRING);

    // Check if photo is uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $photoName = basename($_FILES['photo']['name']);
        $photoPath = $uploadDir . preg_replace("/[^a-zA-Z0-9.-]/", "_", $photoName);

        // Move the uploaded file
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            // Prepare SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO profiles (staf_id, First_Name, Last_Name, NIC_number, Email, Mobile_Number, Lane_Number, Gender, date_of_birth, Age, SAddress, photo, em_no, job_rol, skill) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt) {
                $stmt->bind_param("sssssiississsss", $sid, $firstName, $lastName, $nic, $email, $mobileNumber, $laneNumber, $gender, $dob, $age, $address, $photoPath, $em_no, $job_rol, $skill);

                if ($stmt->execute()) {
                    echo "Profile created successfully!";
                } else {
                    echo "Error executing statement: " . $stmt->error;
                    error_log("Error executing statement: " . $stmt->error, 3, "error_log.txt");
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
                error_log("Error preparing statement: " . mysqli_error($conn), 3, "error_log.txt");
            }
        } else {
            echo "Error uploading the photo.";
            error_log("Error uploading the photo.", 3, "error_log.txt");
        }
    } else {
        echo "Please upload a photo.";
    }
} else {
    echo "No data received.";
}

// Close the database connection
mysqli_close($conn);
?>
