<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="ownerviewfeedback.css">
    <script>
        // JavaScript function to validate the search form
        function validateForm(event) {
            const searchInput = document.forms["feedbackForm"]["search"].value;
            if (searchInput.trim() === "") {
                alert("Please enter a search term before submitting.");
                event.preventDefault(); // Prevent form submission
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
     <!-- Sidebar -->
     <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="ownerexportorder.php">Export Order</a></li>
            <li><a href="owfinancial.html">Financial Report</a></li>
            <li><a href="ownerpayment.html">Payment Status</a></li>
            <li><a href="ownersdetail.php">Supplier Details</a></li>
            <li><a href="owmarequest.php">View Request</a></li>
            <li><a href="ownerassigntask.php">Assigning Task</a></li>
            <li><a href="ownerviewfeedback.php">Staff Performance</a></li>
            <li><a href="ownerviewfeedback.php">View Feedback</a></li>
            <li><a href="StDashboard.html">Logout</a></li>
        </ul>
    </aside>
     <main>
     <h1 class="head">Feedback</h1>

<form name="feedbackForm" method="get" onsubmit="return validateForm(event)">
    <div>
        <input type="text" name="search" placeholder="Search feedback">
        <input type="submit" value="Search">
    </div>

<table>
    <thead>
        <tr>
            <th>Feedback ID</th>
            <th>Feedback Type</th>
            <th>Name</th>
            <th>Email</th>
            <th>Description</th>
            <th>Reply</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include('conf.php');

    // Start session to manage login state
    session_start();

    // Initialize base SQL query to select all feedback
    $sql = "SELECT * FROM lffeedback";

    // Check if a search term is provided
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $conn->real_escape_string($_GET['search']);
        $sql .= " WHERE ID LIKE '%$searchTerm%' ";
    }

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . ($row["ID"]) . "</td>";
            echo "<td>" . ($row["FeedbackType"]) . "</td>";
            echo "<td>" . ($row["Name"]) . "</td>";
            echo "<td>" . ($row["Email"]) . "</td>";
            echo "<td>" . ($row["Discription"]) . "</td>";
            echo "<td>" . ($row["Reply"]) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No feedback found.</td></tr>";
    }

    $conn->close();
    ?>
    </tbody>
</table>
</form>
     </main>
</body>
</html>
