<?php
include('conf.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $orderId = $conn->real_escape_string($_POST['order_id']);
        $status = $conn->real_escape_string($_POST['status']);

        // Update the status of the order in the transport_details table
        $updateTransportQuery = "UPDATE transport_details SET status='$status' WHERE transport_id='$orderId'";
        // Update the status in the task table as well
        $updateTaskQuery = "UPDATE task SET sstatus='$status' WHERE taskname='$orderId'";

        if ($conn->query($updateTransportQuery) && $conn->query($updateTaskQuery)) {
            echo "<script>alert('Status updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating status.');</script>";
        }
    }

    if (isset($_POST['reject'])) {
        $orderId = $conn->real_escape_string($_POST['order_id']);
        $deleteQuery = "DELETE FROM transport_details  WHERE transport_id='$orderId'";

        if ($conn->query($deleteQuery)) {
            echo "<script>alert('Order $orderId rejected and removed.');</script>";
        } else {
            echo "<script>alert('Error rejecting order $orderId.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Order Details</title>
    <link rel="stylesheet" href="importorder1.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo">Dashboard</div>
        <ul class="menu">
        <li><a href="dilivery_confermation.html">Delivery Confirmation</a></li>
            <li><a href="add_issus.html">Issues</a></li>
            <li><a href="view_task.php">View Task</a></li>
            <li><a href="add_driver_status.html">Add Driver Status</a></li>
            <li><a href="Dprofile.html">My Profile</a></li>
            <li><a href="StDashboard.html">LogOut</a></li>
        </ul>
    </aside>

    <main>
        <h1 class="head">Confirm Delivery</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by Order ID">
            <input type="submit" value="Search">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Transport ID</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Note</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Driver ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM transport_details";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $searchTerm = $conn->real_escape_string($_GET['search']);
                    $sql .= " WHERE transport_id LIKE '%$searchTerm%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["transport_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["note"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["cost"]) . "</td>";

                        // Create a dropdown for selecting status
                        echo "<td>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='order_id' value='{$row['transport_id']}'>";
                        echo "<select name='status'>";
                        $statusOptions = ['Pending', 'In Transit', 'Delivered', 'Cancelled'];
                        foreach ($statusOptions as $option) {
                            $selected = ($row['status'] === $option) ? "selected" : "";
                            echo "<option value='$option' $selected>$option</option>";
                        }
                        echo "</select>";
                        echo "<button type='submit' name='confirm' class='action-btn btn-confirm'>Confirm</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "<td>" . htmlspecialchars($row["driver_id"]) . "</td>";

                        // Action for rejecting an order
                        echo "<td>";
                        echo "<form method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='order_id' value='{$row['transport_id']}'>";
                        echo "<button type='submit' name='reject' class='action-btn btn-reject'>Reject</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
