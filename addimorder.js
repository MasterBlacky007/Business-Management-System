// Highlight active sidebar menu item
const sidebarItems = document.querySelectorAll('.sidebar ul li a');

sidebarItems.forEach(item => {
    item.addEventListener('click', () => {
        sidebarItems.forEach(link => link.parentElement.classList.remove('active'));
        item.parentElement.classList.add('active');
    });
});

// References to the order form container and button
const orderFormContainer = document.getElementById("orderFormContainer");
const showOrderFormButton = document.getElementById("showOrderForm");

if (showOrderFormButton && orderFormContainer) {
    showOrderFormButton.addEventListener("click", () => {
        // Insert the form HTML dynamically
        orderFormContainer.innerHTML = `
            <form id="exportOrderForm">
                <label for="nic">NIC:</label>
                <input type="text" id="nic" name="nic" placeholder="Enter NIC" required>

                <label for="exportOrderDate">Export Order Date:</label>
                <input type="date" id="exportOrderDate" name="exportOrderDate" required>

                <label for="destinationAddress">Destination Address:</label>
                <input type="text" id="destinationAddress" name="destinationAddress" placeholder="Enter destination address" required>

                <label for="productID">Product ID:</label>
                <input type="text" id="productID" name="productID" placeholder="Enter product ID" required>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>

                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" step="0.01" required>

                <button type="submit">Submit Export Order</button>
                <button type="button" id="cancelButton">Cancel</button>
            </form>
        `;

        orderFormContainer.style.display = "block"; // Show the form

        const exportOrderForm = document.getElementById("exportOrderForm");

        exportOrderForm.addEventListener("submit", (e) => {
            e.preventDefault(); // Prevent the form from refreshing the page

            const nicInput = document.getElementById("nic").value.trim();
            if (!validateNIC(nicInput)) {
                alert("Please enter a valid NIC.");
                return;
            }

            const formData = new FormData(exportOrderForm);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "addorder.php", true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(`Order submitted successfully. Order ID: ${response.orderID}`);
                        exportOrderForm.reset();
                        orderFormContainer.style.display = "none";
                    } else {
                        alert('Failed to submit order: ' + response.message);
                    }
                } else {
                    alert('Failed to submit order. Please try again.');
                }
            };

            xhr.onerror = function() {
                alert('An error occurred during the request. Please try again later.');
            };

            xhr.send(formData);
        });

        const cancelButton = document.getElementById("cancelButton");
        cancelButton.addEventListener("click", () => {
            orderFormContainer.style.display = "none"; // Hide the form
            orderFormContainer.innerHTML = ""; // Clear the form content
        });
    });
}

// NIC Validation Function
function validateNIC(nic) {
    const nicPattern = /^[0-9]{9}[vVxX]?$|^[0-9]{12}$/;
    return nicPattern.test(nic);
}
