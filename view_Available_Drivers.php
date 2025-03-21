<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Available Transport Details</title>
<link rel="stylesheet" href="viewTask.css">
</head>
<body>
    <h1 class="head">View Available Drivers</h1>

    <form id="searchForm" action="" method="get" onsubmit="return validateSearch()">
        <div>
            <input type="text" id="search" name="search" placeholder="Search Tasks">
            <input type="submit" value="Search">
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Driver ID</th>
                <th>Driver Name</th>
                <th>Vehicle Number</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            include 'availabale_tarns.php';
            ?>
        </tbody>
    </table>

    <script>
        // JavaScript function to validate the search input
        function validateSearch() {
            const searchInput = document.getElementById('search').value.trim();

            if (searchInput === "") {
                alert("Please enter a search term.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        // Example: Highlight table rows on hover (optional feature)
        const tableRows = document.querySelectorAll("table tbody tr");

        tableRows.forEach((row) => {
            row.addEventListener("mouseenter", () => {
                row.style.backgroundColor = "#f2f2f2"; // Light gray background
            });
            row.addEventListener("mouseleave", () => {
                row.style.backgroundColor = ""; // Reset background color
            });
        });
    </script>
</body>
</html>
