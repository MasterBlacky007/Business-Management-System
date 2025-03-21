document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registration-form");
    const messageDiv = document.querySelector(".message");

    form.addEventListener("submit", (e) => {
        const firstName = document.getElementById("first-name").value.trim();
        const lastName = document.getElementById("last-name").value.trim();
        const email = document.getElementById("email").value.trim();
        const contact = document.getElementById("contact").value.trim();
        const address = document.getElementById("address").value.trim();

        // Regular expressions for validation
        const nameRegex = /^[a-zA-Z]+$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let errorMessage = "";
        let registrationStatusMessage = "<span style='color: red;'>Registration unsuccessful:</span><br>";

        // Validate first name
        if (!nameRegex.test(firstName)) {
            errorMessage += "First name should contain only letters.<br>";
        }

        // Validate last name
        if (!nameRegex.test(lastName)) {
            errorMessage += "Last name should contain only letters.<br>";
        }

        // Validate email
        if (!emailRegex.test(email)) {
            errorMessage += "Invalid email address.<br>";
        }

        // Validate contact (only numeric values)
        if (!/^\d+$/.test(contact)) {
            errorMessage += "Contact number should contain only numeric values.<br>";
        }

        // Validate address
        if (address.length === 0) {
            errorMessage += "Address is required.<br>";
        }

        // If there are errors, prevent form submission and show message
        if (errorMessage) {
            e.preventDefault();
            messageDiv.innerHTML = registrationStatusMessage + errorMessage;
        } else {
            // If no validation errors, show success message
            messageDiv.innerHTML = "<span style='color: green;'>Registration successful!</span>";
        }
    });
});
