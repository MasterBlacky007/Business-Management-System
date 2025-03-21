<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Production Cost Report</title>
    <link rel="stylesheet" href="stylesda.css">
</head>
<body>

    <div class="message-container" id="messageContainer"></div>

    <div class="report-modal">
        <div class="modal-header">
            <h2>Create Production Cost Report</h2><br>
        </div>
        <form id="reportForm" action="report_confirmation.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="report_title">Report Title *</label>
                    <input type="text" id="report_title" name="report_title" placeholder="Report title" required>
                </div>
                <div class="form-group">
                    <label for="report_date">Report Date *</label>
                    <input type="date" id="report_date" name="report_date" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fruit_type">Product *</label>
                    <input type="text" id="fruit_type" name="fruit_type" placeholder="e.g., Apples, Bananas" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (kg) *</label>
                    <input type="number" id="quantity" name="quantity" placeholder="e.g., 500" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="labor_cost">Labor Cost ($) *</label>
                    <input type="number" id="labor_cost" name="labor_cost" placeholder="e.g., 1000" required oninput="calculateTotal()">
                </div>
                <div class="form-group">
                    <label for="transport_cost">Transport Cost ($) *</label>
                    <input type="number" id="transport_cost" name="transport_cost" placeholder="e.g., 300" required oninput="calculateTotal()">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="packaging_cost">Packaging Cost ($) *</label>
                    <input type="number" id="packaging_cost" name="packaging_cost" placeholder="e.g., 200" required oninput="calculateTotal()">
                </div>
                <div class="form-group">
                    <label for="miscellaneous_cost">Miscellaneous Cost ($)</label>
                    <input type="number" id="miscellaneous_cost" name="miscellaneous_cost" placeholder="e.g., 50" oninput="calculateTotal()">
                </div>
            </div>

            <!-- Total Cost -->
            <div class="form-row">
                <div class="form-group">
                    <label for="total_cost">Total Cost ($)</label>
                    <input type="number" id="total_cost" name="total_cost" placeholder="Total Cost" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="report_frequency">Report Frequency *</label>
                    <select id="report_frequency" name="report_frequency" required>
                        <option value="" disabled selected>Select Frequency</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <label for="observations">Additional Notes</label>
                <textarea id="observations" name="observations" placeholder="Enter any additional details"></textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn">Cancel</button>
                <button type="submit" class="submit-btn">Create Report</button>
            </div>
        </form>
    </div>

    <script>
        // Function to calculate total cost
        function calculateTotal() {
            const laborCost = parseFloat(document.getElementById('labor_cost').value) || 0;
            const transportCost = parseFloat(document.getElementById('transport_cost').value) || 0;
            const packagingCost = parseFloat(document.getElementById('packaging_cost').value) || 0;
            const miscellaneousCost = parseFloat(document.getElementById('miscellaneous_cost').value) || 0;

            const totalCost = laborCost + transportCost + packagingCost + miscellaneousCost;

            // Update the total cost field
            document.getElementById('total_cost').value = totalCost.toFixed(2);
        }
    </script>

    <script src="script.js"></script>
</body>
</html>
