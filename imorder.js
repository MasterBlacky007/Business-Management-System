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
                <input type="number" id="price" name="price" required readonly>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>

                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" step="0.01" required readonly>

                <button type="submit">Submit Export Order</button>
                <button type="button" id="cancelButton">Cancel</button>
            </form>
        `;

        orderFormContainer.style.display = "block";

        const exportOrderForm = document.getElementById("exportOrderForm");

        exportOrderForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const nicInput = document.getElementById("nic").value.trim();
            if (!validateNIC(nicInput)) {
                alert("Please enter a valid NIC.");
                return;
            }

            const formData = new FormData(exportOrderForm);

            fetch("addorder.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Order submitted successfully. Order ID: ${data.orderID}`);
                    exportOrderForm.reset();
                    orderFormContainer.style.display = "none";
                } else {
                    alert('Failed to submit order: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during the request. Please try again later.');
            });
        });

        const cancelButton = document.getElementById("cancelButton");
        cancelButton.addEventListener("click", () => {
            orderFormContainer.style.display = "none";
            orderFormContainer.innerHTML = "";
        });

        // Fetch price when the productID is entered
        document.getElementById('productID').addEventListener('blur', () => {
            const productID = document.getElementById('productID').value.trim();

            if (productID) {
                fetch(`getPrice.php?productID=${productID}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('price').value = data.price;
                            calculateAmount();
                        } else {
                            alert('Product not found!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error fetching price. Please try again.');
                    });
            }
        });

        // Calculate the amount when quantity or price changes
        document.getElementById('quantity').addEventListener('input', calculateAmount);
        document.getElementById('price').addEventListener('input', calculateAmount);

        function calculateAmount() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const quantity = parseInt(document.getElementById('quantity').value) || 0;
            const amount = price * quantity;

            document.getElementById('amount').value = amount.toFixed(2);
        }

        // NIC Validation Function
        function validateNIC(nic) {
            const nicPattern = /^[0-9]{9}[vVxX]?$|^[0-9]{12}$/;
            return nicPattern.test(nic);
        }
    });
}
