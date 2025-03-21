<?php
include 'conf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $nic = $_POST['nic'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobileNumber = $_POST['mobile_number'] ?? '';
    $laneNumber = $_POST['lane_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $age = $_POST['age'] ?? '';
    $address = $_POST['address'] ?? '';
    $pmnumber = $_POST['pmnumber'] ?? '';
    $tsize = $_POST['tsize'] ?? '';
    $parea = $_POST['parea'] ?? '';
    $photo = $_POST['photo'] ?? '';


    // File upload handling
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['photo']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
            $photo = $filePath;
        } else {
            echo "Failed to upload photo.";
            exit;
        }
    } else {
        echo "Photo is required.";
        exit;
    }

    // Validation
    if (empty($firstName) || empty($lastName) || empty($nic) || empty($email) || empty($mobileNumber) || empty($gender) || empty($dob) || empty($age)) {
        echo "Required fields must be filled.";
        exit;
    }

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO profiles (First_Name, Last_Name, NIC_number, Email, Mobile_Number, Lane_Number, Gender, date_of_birth, Age, SAddress, photo, pmNumber, tsize, pArea) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssssiississsss", $firstName, $lastName, $nic, $email, $mobileNumber, $laneNumber, $gender, $dob, $age, $address, $photo, $pmnumber, $tsize, $parea);

        if ($stmt->execute()) {
            // Success message as alert and redirect to create_profile.html
            echo "<script>alert('Profile created successfully!'); window.location.href='create_profile.html';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No data received.";
}
?>
