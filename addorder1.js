// Consolidated JavaScript for Add Order Functionality

// Pre-fill form if query string parameters exist
window.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const productID = params.get("productID");
    const price = params.get("price");

    if (productID) {
        document.getElementById("productID").value = productID;
    }

    if (price) {
        document.getElementById("price").value = parseFloat(price).toFixed(2);
    }
});

// Calculate total amount
document.getElementById("quantity").addEventListener("input", () => {
    const price = parseFloat(document.getElementById("price").value) || 0;
    const quantity = parseInt(document.getElementById("quantity").value) || 0;
    document.getElementById("amount").value = (price * quantity).toFixed(2);
});

// Handle form submission
document.getElementById("exportOrderForm").addEventListener("submit", function (e) {
    e.preventDefault();
    alert("Order submitted!");
});
