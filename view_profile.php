<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Edit Profile</title>
    <link rel="stylesheet" href="viewprofile.css">
</head>
<body>

<div class="profile-container">
    <h2>View and Edit Your Profile</h2>
    <?php
    include 'conf.php';

    $profile = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle search
        if (!empty($_POST['search'])) {
            $userId = trim($_POST['search']);
            $query = "SELECT  First_Name,Last_Name,NIC_number,Email,Mobile_Number,Lane_Number,Gender,date_of_birth,Age,SAddress,photo,pmNumber,pArea,tsize FROM profiles WHERE staf_id = ?";
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

        // Handle save
        if (isset($_POST['fname'])) {
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
            $photo = trim($_POST['photo']);
            $pmnumber = $_POST['pmnumber'] ?? '';
            $tsize = $_POST['tsize'] ?? '';  
            $parea = $_POST['parea'] ?? ''; 
            $userId = $_POST['search'];

            $updateQuery = "UPDATE profiles SET First_Name = ?, Last_Name = ?, NIC_number = ?, Email = ?, Mobile_Number = ?, Lane_Number = ?, Gender = ?, date_of_birth = ?, Age = ?, SAddress = ?, photo = ?,pmNumber=?,pArea=?,tsize=? WHERE staf_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ssssiississsss", $fname, $lname, $nic, $email, $mphone, $lphone, $gender, $dob, $age, $address, $photo,$pmnumber,$parea,$tsize );

            if ($stmt->execute()) {
                echo "<p class='success'>Profile updated successfully!</p>";
            } else {
                echo "<p class='error'>Error updating profile. Please try again.</p>";
            }
            $stmt->close();

            // Redirect to avoid resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
    ?>

    <form action="" method="POST">
        <div class="sea">
            <input class="sea" type="text" id="search" name="search" placeholder="Enter User ID to Search"
                   value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
            <input class="seabut" type="submit" value="Search">
        </div>

        <?php if ($profile): ?>
        <div class="profile-layout">
            <section><div class="profile-photo">
                <?php
                // Define the path to the images directory
                $imagePath = 'path_to_image/' . $profile['photo'];

                // Check if the file exists
                if (file_exists($imagePath)) {
                    echo "<img src=\"$imagePath\" alt=\"Profile Photo\">";
                } else {
                    echo "<img src=\"path_to_image/default-profile.jpg\" alt=\"Profile Photo\">"; // Fallback image
                }
                ?>
            </div></section>
            
            <div class="profile-form">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($profile['First_Name']); ?>" >
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($profile['Last_Name']); ?>" >
                </div>
                <div class="form-group">
                    <label for="nic">NIC Number:</label>
                    <input type="text" id="nic" name="nic" value="<?php echo htmlspecialchars($profile['NIC_number']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['Email']); ?>">
                </div>
                <div class="form-group">
                    <label for="mphone">Mobile Phone:</label>
                    <input type="text" id="mphone" name="mphone" value="<?php echo htmlspecialchars($profile['Mobile_Number']); ?>">
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
                    <label for="dob">Date Of Birth:</label>
                    <input type="text" id="dob" name="dob" value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>">
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
                    <label for="photo">Photo Path:</label>
                    <input type="file" id="photo" name="photo" value="<?php echo htmlspecialchars($profile['photo']); ?>">
                </div>
                <div class="form-group">
                    <label for="pmnumber">Production Manager NUmber</label>
                    <input type="text" id="pmnumber" name="pmnumber" value="<?php echo htmlspecialchars($profile['pmNumber']); ?>">
                </div>
                <div class="form-group">
                    <label for="parea">Production Area</label>
                    <input type="text" id="parea" name="parea" value="<?php echo htmlspecialchars($profile['pArea']); ?>">
                </div>
                <div class="form-group">
                    <label for="tsize">Teame Members Count</label>
                    <input type="text" id="tsize" name="tsize" value="<?php echo htmlspecialchars($profile['tsize']); ?>">
                </div>
                <div class="form-buttons">
                    <button type="reset" class="btn btn-cancel">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </form>
</div>

<script>
   document.querySelector('form').addEventListener('submit', function(event) {
    let isValid = true; // Flag to track overall form validity

    // Get all form inputs
    const fname = document.getElementById('fname');
    const lname = document.getElementById('lname');
    const email = document.getElementById('email');
    const mphone = document.getElementById('mphone');
    const lphone = document.getElementById('lphone');
    const gender = document.getElementById('gender');
    const dob = document.getElementById('dob');
    const age = document.getElementById('age');
    const address = document.getElementById('address');
    const photo = document.getElementById('photo');
    const pmnumber = document.getElementById('pmnumber');
    const pare = document.getElementById('parea');
    const tsize = document.getElementById('tsize');

    // Clear previous errors
    document.querySelectorAll('.error').forEach(function(element) {
        element.remove();
    });

    // Validate First Name
    if (fname.value.trim() === '') {
        displayError(fname, 'First Name is required.');
        isValid = false;
    }

    // Validate Last Name
    if (lname.value.trim() === '') {
        displayError(lname, 'Last Name is required.');
        isValid = false;
    }

    // Validate Email
    if (email.value.trim() === '') {
        displayError(email, 'Email is required.');
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email.value)) {
        displayError(email, 'Invalid email format.');
        isValid = false;
    }

    // Validate Mobile Phone
    if (mphone.value.trim() === '') {
        displayError(mphone, 'Mobile Phone is required.');
        isValid = false;
    } else if (!/^\d+$/.test(mphone.value)) {
        displayError(mphone, 'Mobile Phone must contain only numbers.');
        isValid = false;
    }

    // Validate Lane Phone (optional, but can be added as a number check)
    if (lphone.value.trim() !== '' && !/^\d+$/.test(lphone.value)) {
        displayError(lphone, 'Lane Phone must contain only numbers.');
        isValid = false;
    }

    // Validate Gender
    if (gender.value.trim() === '') {
        displayError(gender, 'Gender is required.');
        isValid = false;
    }

    // Validate Date of Birth (should match YYYY-MM-DD format)
    if (dob.value.trim() === '') {
        displayError(dob, 'Date of Birth is required.');
        isValid = false;
    } else if (!/^\d{4}[-]\d{2}[-]\d{2}$/.test(dob.value)) {
        displayError(dob, 'Date of Birth must be in the format YYYY-MM-DD.');
        isValid = false;
    }

    // Validate Age (must be a number)
    if (age.value.trim() === '') {
        displayError(age, 'Age is required.');
        isValid = false;
    } else if (!/^\d+$/.test(age.value)) {
        displayError(age, 'Age must be a number.');
        isValid = false;
    }

    // Validate Address
    if (address.value.trim() === '') {
        displayError(address, 'Address is required.');
        isValid = false;
    }

    // Validate Photo Path (optional, but check for valid path format)
    if (photo.value.trim() !== '' && !/^[\w\-.\/]+$/.test(photo.value)) {
        displayError(photo, 'Invalid photo path format.');
        isValid = false;
    }

    
    // Validate Production Area (optional, can be empty but check for valid format if filled)
    if (pare.value.trim() !== '' && !/^[\w\s]+$/.test(pare.value)) {
        displayError(pare, 'Production Area must contain only letters and spaces.');
        isValid = false;
    }

    // Validate Team Size (must be a number)
    if (tsize.value.trim() === '') {
        displayError(tsize, 'Team Size is required.');
        isValid = false;
    } else if (!/^\d+$/.test(tsize.value)) {
        displayError(tsize, 'Team Size must be a number.');
        isValid = false;
    }

    // Prevent form submission if validation fails
    if (!isValid) {
        event.preventDefault();
    }
});

// Function to display error messages
function displayError(input, message) {
    const error = document.createElement('div');
    error.textContent = message;
    error.classList.add('error');
    input.parentNode.appendChild(error);
}

</script>

<style>
    .error {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
    }
</style>

</body>
</html>
