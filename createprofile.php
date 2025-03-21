<?php
// Database connection
include 'conf.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $staffId = mysqli_real_escape_string($conn, $_POST['sid']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobileNumber = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $laneNumber = mysqli_real_escape_string($conn, $_POST['lane_number']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    // Handle file upload for photo
    $photo = $_FILES['photo'];
    $photoDestination = 'uploads/' . basename($photo['name']);
    if (!move_uploaded_file($photo['tmp_name'], $photoDestination)) {
        echo "Error uploading photo!";
        exit;
    }

    // Default role-specific fields and values
    $roleSpecificFields = "transporter_no, fleet_size, pmNumber, pArea, tsize, dnumber, vehicle_no, license_no, skill, fm_no, doa, inv_no, inv_area, inv_size, sk_no, edate, sup_no, sup_area, em_no, job_rol";
    $roleSpecificValues = "'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''";

    // Handle each position's specific fields
    switch ($position) {
        case 'Transport Manager':
            $managerNo = mysqli_real_escape_string($conn, $_POST['Tmanager_no']);
            $fleetSize = mysqli_real_escape_string($conn, $_POST['fleet_size']);
            $roleSpecificValues = "'$managerNo', '$fleetSize', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''";
            break;

        case 'Production Manager':
            $pmNumber = mysqli_real_escape_string($conn, $_POST['pmnumber']);
            $productionArea = mysqli_real_escape_string($conn, $_POST['parea']);
            $teamSize = mysqli_real_escape_string($conn, $_POST['tsize']);
            $roleSpecificValues = "'', '', '$pmNumber', '$productionArea', '$teamSize', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''";
            break;

        case 'Driver':
            $driverNumber = mysqli_real_escape_string($conn, $_POST['dnumber']);
            $vehicleNumber = mysqli_real_escape_string($conn, $_POST['vnumber']);
            $licenseNumber = mysqli_real_escape_string($conn, $_POST['lnumber']);
            $experience = mysqli_real_escape_string($conn, $_POST['experience']);
            $roleSpecificValues = "'', '', '', '', '', '$driverNumber', '$vehicleNumber', '$licenseNumber', '$experience', '', '', '', '', '', '', '', '', '', '', ''";
            break;

        case 'Factory Manager':
            $fmNumber = mysqli_real_escape_string($conn, $_POST['fm_no']);
            $dateOfJoin = mysqli_real_escape_string($conn, $_POST['doa']);
            $skill = mysqli_real_escape_string($conn, $_POST['skill']);
            $roleSpecificValues = "'', '', '', '', '', '', '', '', '', '$fmNumber', '$dateOfJoin', '', '', '', '', '', '', '', '', ''";
            break;

        case 'Inventory Manager':
            $invNumber = mysqli_real_escape_string($conn, $_POST['inv_no']);
            $invArea = mysqli_real_escape_string($conn, $_POST['inv_area']);
            $invSize = mysqli_real_escape_string($conn, $_POST['inv_size']);
            $roleSpecificValues = "'', '', '', '', '', '', '', '', '', '', '', '$invNumber', '$invArea', '$invSize', '', '', '', '', '', ''";
            break;

        case 'Stock Keeper':
            $skNumber = mysqli_real_escape_string($conn, $_POST['sknummber']);
            $entryDate = mysqli_real_escape_string($conn, $_POST['edate']);
            $roleSpecificValues = "'', '', '', '', '', '', '', '', '', '', '', '', '', '', '$skNumber', '$entryDate', '', '', '', ''";
            break;

        case 'Supervisor':
            $supervisorNumber = mysqli_real_escape_string($conn, $_POST['sup_no']);
            $supervisorArea = mysqli_real_escape_string($conn, $_POST['sup_area']);
            $roleSpecificValues = "'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '$supervisorNumber', '$supervisorArea', '', ''";
            break;

        case 'Employee':
            $empNumber = mysqli_real_escape_string($conn, $_POST['em_no']);
            $jobRole = mysqli_real_escape_string($conn, $_POST['job_rol']);
            $experience = mysqli_real_escape_string($conn, $_POST['experience']);
            $roleSpecificValues = "'', '', '', '', '', '', '', '', '$experience', '', '', '', '', '', '', '', '', '', '$empNumber', '$jobRole'";
            break;
    }

    // Insert data into database
    $query = "INSERT INTO profiles (staf_id, First_Name, Last_Name, NIC_number, Email, Mobile_Number, Lane_Number, Gender, date_of_birth, Age, SAddress, photo, $roleSpecificFields) 
    VALUES ('$staffId', '$firstName', '$lastName', '$nic', '$email', '$mobileNumber', '$laneNumber', '$gender', '$dob', '$age', '$address', '$photoDestination', $roleSpecificValues)";

    // Execute the query and check for success
    if (mysqli_query($conn, $query)) {
        echo "Profile saved successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
