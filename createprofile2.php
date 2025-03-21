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

    // Role-specific fields
    $roleSpecificFields = "";
    switch ($position) {
        case 'Transport Manager':
            $managerNo = mysqli_real_escape_string($conn, $_POST['Tmanager_no']);
            $fleetSize = mysqli_real_escape_string($conn, $_POST['fleet_size']);
            $roleSpecificFields = ", transport_manager_number, fleet_size";
            $roleSpecificValues = "('$managerNo', '$fleetSize')";
            break;
        case 'Production Manager':
            $pmNumber = mysqli_real_escape_string($conn, $_POST['pmnumber']);
            $productionArea = mysqli_real_escape_string($conn, $_POST['parea']);
            $teamSize = mysqli_real_escape_string($conn, $_POST['tsize']);
            $roleSpecificFields = ", production_manager_number, production_area, team_members_count";
            $roleSpecificValues = "('$pmNumber', '$productionArea', '$teamSize')";
            break;
        case 'Driver':
            $driverNumber = mysqli_real_escape_string($conn, $_POST['dnumber']);
            $vehicleNumber = mysqli_real_escape_string($conn, $_POST['vnumber']);
            $licenseNumber = mysqli_real_escape_string($conn, $_POST['lnumber']);
            $experience = mysqli_real_escape_string($conn, $_POST['experience']);
            $roleSpecificFields = ", driver_number, vehicle_number, license_number, experience";
            $roleSpecificValues = "('$driverNumber', '$vehicleNumber', '$licenseNumber', '$experience')";
            break;
        case 'Factory Manager':
            $fmNumber = mysqli_real_escape_string($conn, $_POST['fm_no']);
            $dateOfJoin = mysqli_real_escape_string($conn, $_POST['doa']);
            $skill = mysqli_real_escape_string($conn, $_POST['skill']);
            $roleSpecificFields = ", factory_manager_number, date_of_join, skill";
            $roleSpecificValues = "('$fmNumber', '$dateOfJoin', '$skill')";
            break;
        case 'Inventory Manager':
            $invNumber = mysqli_real_escape_string($conn, $_POST['inv_no']);
            $invArea = mysqli_real_escape_string($conn, $_POST['inv_area']);
            $invSize = mysqli_real_escape_string($conn, $_POST['inv_size']);
            $roleSpecificFields = ", inventory_manager_number, inventory_area, inventory_size";
            $roleSpecificValues = "('$invNumber', '$invArea', '$invSize')";
            break;
        case 'Stock Keeper':
            $skNumber = mysqli_real_escape_string($conn, $_POST['sknummber']);
            $entryDate = mysqli_real_escape_string($conn, $_POST['edate']);
            $roleSpecificFields = ", stock_keeper_number, entry_date";
            $roleSpecificValues = "('$skNumber', '$entryDate')";
            break;
        case 'Supervisor':
            $supervisorNumber = mysqli_real_escape_string($conn, $_POST['sup_no']);
            $supervisorArea = mysqli_real_escape_string($conn, $_POST['sup_area']);
            $roleSpecificFields = ", supervisor_number, supervisor_area";
            $roleSpecificValues = "('$supervisorNumber', '$supervisorArea')";
            break;
        case 'Employee':
            $empNumber = mysqli_real_escape_string($conn, $_POST['em_no']);
            $jobRole = mysqli_real_escape_string($conn, $_POST['job_rol']);
            $experience = mysqli_real_escape_string($conn, $_POST['experience']);
            $roleSpecificFields = ", employee_number, job_role, experience";
            $roleSpecificValues = "('$empNumber', '$jobRole', '$experience')";
            break;
        default:
            $roleSpecificFields = "";
            $roleSpecificValues = "";
    }

    // Insert data into database
    $query = "INSERT INTO profiles (staff_id, first_name, last_name, nic, email, mobile_number, lane_number, gender, dob, age, address, position, photo $roleSpecificFields) 
    VALUES ('$staffId', '$firstName', '$lastName', '$nic', '$email', '$mobileNumber', '$laneNumber', '$gender', '$dob', '$age', '$address', '$position', '$photoDestination' $roleSpecificValues)";

    if (mysqli_query($conn, $query)) {
        echo "Profile saved successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
