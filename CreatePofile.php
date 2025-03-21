<?php
// Include database connection
include('conf.php');

// Start session to manage login state
session_start();

// Initialize the success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $staf_id = $_POST['staf_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $nic_number = $_POST['nic_number'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $lane_number = $_POST['lane_number'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $saddress = $_POST['saddress'];
    
    // Handle file upload
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_destination = 'uploads/' . $photo_name;

        // Ensure the upload directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($photo_tmp_name, $photo_destination)) {
            $photo = $photo_name;
        } else {
            echo "<script>alert('Failed to upload photo.');</script>";
        }
    }

    $position = $_POST['position'];
    $role_specific_fields = [];

    // Role-specific fields data
    if ($position == "Transport Manager") {
        $role_specific_fields = [
            'transporter_no' => $_POST['transporter_no'] ?? '',
            'vehicle_no' => $_POST['vehicle_no'] ?? '',
            'license_no' => $_POST['license_no'] ?? '',
        ];
    } elseif ($position == "Production Manager") {
        $role_specific_fields = [
            'pmNumber' => $_POST['pmNumber'] ?? '',
            'pArea' => $_POST['pArea'] ?? '',
            'tsize' => $_POST['tsize'] ?? '',
        ];
    } elseif ($position == "Driver") {
        $role_specific_fields = [
            'dnumber' => $_POST['dnumber'] ?? '',
            'vnumber' => $_POST['vnumber'] ?? '',
            'lnumber' => $_POST['lnumber'] ?? '',
            'experience' => $_POST['experience'] ?? '',
        ];
    } elseif ($position == "Factory Manager") {
        $role_specific_fields = [
            'fm_no' => $_POST['fm_no'] ?? '',
            'doa' => $_POST['doa'] ?? '',
            'skill' => $_POST['skill'] ?? '',
        ];
    } elseif ($position == "Inventory Manager") {
        $role_specific_fields = [
            'inv_no' => $_POST['inv_no'] ?? '',
            'inv_area' => $_POST['inv_area'] ?? '',
            'inv_size' => $_POST['inv_size'] ?? '',
        ];
    } elseif ($position == "Stock Keeper") {
        $role_specific_fields = [
            'sknumber' => $_POST['sknumber'] ?? '',
            'edate' => $_POST['edate'] ?? '',
        ];
    } elseif ($position == "Supervisor") {
        $role_specific_fields = [
            'sup_no' => $_POST['sup_no'] ?? '',
            'sup_area' => $_POST['sup_area'] ?? '',
        ];
    } elseif ($position == "Employee") {
        $role_specific_fields = [
            'em_no' => $_POST['em_no'] ?? '',
            'job_rol' => $_POST['job_rol'] ?? '',
            'experience' => $_POST['experience'] ?? '',
        ];
    }

    // Build SQL query
    $sql = "INSERT INTO profiles (staf_id, First_Name, Last_Name, NIC_number, Email, Mobile_Number, Lane_Number, Gender, date_of_birth, Age, SAddress, photo, transporter_no, vehicle_no, license_no, skill, Tmanager_no, fleet_size, pmNumber, pArea, tsize, skeeper_no, edate, em_no, job_rol, sup_no, sup_area, fm_no, doa, inv_no, inv_area, inv_size, sk_no) 
            VALUES ('$staf_id', '$first_name', '$last_name', '$nic_number', '$email', '$mobile_number', '$lane_number', '$gender', '$dob', '$age', '$saddress', '$photo', 
            '{$role_specific_fields['transporter_no']}', '{$role_specific_fields['vehicle_no']}', '{$role_specific_fields['license_no']}', '{$role_specific_fields['skill']}', '{$role_specific_fields['Tmanager_no']}', '{$role_specific_fields['fleet_size']}', '{$role_specific_fields['pmNumber']}', '{$role_specific_fields['pArea']}', '{$role_specific_fields['tsize']}', '{$role_specific_fields['skeeper_no']}', '{$role_specific_fields['edate']}', '{$role_specific_fields['em_no']}', '{$role_specific_fields['job_rol']}', '{$role_specific_fields['sup_no']}', '{$role_specific_fields['sup_area']}', '{$role_specific_fields['fm_no']}', '{$role_specific_fields['doa']}', '{$role_specific_fields['inv_no']}', '{$role_specific_fields['inv_area']}', '{$role_specific_fields['inv_size']}', '{$role_specific_fields['sk_no']}')";

    if (mysqli_query($conn, $sql)) {
        $successMessage = "Record added successfully!";
        echo "<script>alert('$successMessage'); window.location.href = 'CreatePofile.html';</script>";
    } else {
        $successMessage = "Error: " . mysqli_error($conn);
        echo "<script>alert('Failed to add record. Please try again.');</script>";
    }
}

// Close database connection
mysqli_close($conn);
?>
