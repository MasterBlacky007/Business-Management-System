<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="vwfeedback.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="pprocess.php">Production Process</a></li>
            <li><a href="viewcostreport1.html">Cost Report</a></li>
            <li><a href="gensalary.php">Generate Salary</a></li>
            <li><a href="facviewpay.php">Supplier Payment</a></li>
            <li><a href="salarystatus.php">Salary Status</a></li>
            <li><a href="grevenue.php">Generate Revenue</a></li>
            <li><a href="updatedelivery.php">Update Delivery</a></li>
            <li><a href="facmaapprove.php">Approve Request</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="stockstatus.html">Stock Status</a></li>
            <li><a href="performancereport.html">Performance Report</a></li>
            <li><a href="assign-task.html">Assigning Task</a></li>
            <li><a href="faimportorder.php">Import Order</a></li>
            <li><a href="viewfeedback.php">Feedback</a></li>
            <li><a href="facexportorder.html">Export Order</a></li>
            <li><a href="profile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>
    <main>
        <h1 class="head">Delivery</h1>

        <form method="post" onsubmit="return validateForm()">
            <div>
                <input type="text" name="search" placeholder="Search feedback">
                <input type="submit" value="Search">
                <input type="text" name="status" placeholder="reply">
                <input type="submit" name="update" class="update-btn" value="Reply">
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Feedback Type</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Discripction</th>
                        <th>Reply</th>

                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('conf.php');

                    // Start session to manage login state
                    session_start();

                    // Initialize base SQL query to select all tasks
                    $sql = "SELECT * FROM lffeedback";

                    // Check if a search term is provided
                    if (isset($_POST['search']) && !empty($_POST['search'])) {
                        $searchTerm = $conn->real_escape_string($_POST['search']);
                        $sql .= " WHERE ID LIKE '%$searchTerm%'";
                    }

                    // Check for an update request
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                        $updateDid = $conn->real_escape_string($_POST['search']);
                        $newStatus = $conn->real_escape_string($_POST['status']);

                        if (!empty($updateDid)) {
                            $updateQuery = "UPDATE lffeedback SET Reply='$newStatus' WHERE ID='$updateDid'";
                            if ($conn->query($updateQuery) === TRUE) {
                                echo "<p>Record updated successfully.</p>";
                            } else {
                                echo "<p>Error updating record: " . $conn->error . "</p>";
                            }
                        } else {
                            echo "<p>Please enter a feedback ID to reply.</p>";
                        }
                    }

                    // Execute the query
                    $result = $conn->query($sql);

                    // Display table rows
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["ID"] . "</td>";
                            echo "<td>" . $row["FeedbackType"] . "</td>";
                            echo "<td>" . $row["Name"] . "</td>";
                            echo "<td>" . $row["Email"] . "</td>";
                            echo "<td>" . $row["Discription"] . "</td>";
                            echo "<td>" . $row["Reply"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No feedback found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </form>
    </main>

    <script>
        function validateForm() {
            const searchInput = document.forms[0]["search"].value.trim();
            const statusInput = document.forms[0]["status"].value.trim();
            const updateButtonClicked = document.activeElement.name === "update";

            if (updateButtonClicked && (searchInput === "" || statusInput === "")) {
                alert("Please fill out both the Search and reply fields before updating.");
                return false;
            }
            
        return true;
    }
        
    </script>
</body>
</html>
