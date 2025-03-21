document.getElementById("searchButton").addEventListener("click", function () {
    // Get the values from the inputs and trim extra whitespace
    const nicInput = document.getElementById("iicInput").value.trim().toLowerCase();
    const orderIdInput = document.getElementById("orderIdInput").value.trim().toLowerCase();

    // Get the table and all rows
    const table = document.getElementById("orderTable");
    const rows = table.querySelectorAll("tbody tr");

    // Check if NIC input is empty and alert the user
    if (!nicInput) {
        alert("Please enter the IIC for the search.");
        return;
    }

    // Flag to check if any matching rows are found
    let matchFound = false;

    // Loop through each row to check for matches
    rows.forEach(row => {
        // Get the NIC and Order ID from the respective cells in each row
        const orderIdCell = row.cells[0].textContent.trim().toLowerCase(); // Order ID
        const nicCell = row.cells[2].textContent.trim().toLowerCase();     // NIC

        // Check if the NIC matches and if the Order ID matches (if provided)
        const nicMatches = nicCell.includes(nicInput);
        const orderIdMatches = orderIdInput === "" || orderIdCell.includes(orderIdInput);

        if (nicMatches && orderIdMatches) {
            row.style.display = ""; // Show the row
            matchFound = true;
        } else {
            row.style.display = "none"; // Hide the row
        }
    });

    // Show or hide the table based on whether any matches were found
    if (matchFound) {
        table.style.display = "table"; // Show the table if matches are found
    } else {
        table.style.display = "none"; // Hide the table if no matches are found
        alert("No matching orders found.");
    }
});
