<?php
// Include database configuration
include 'conf.php';

// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Initialize search query variables
$search_report_id = $_POST['report_id'] ?? '';
$search_transport_id = $_POST['transport_id'] ?? '';
$search_route = $_POST['route'] ?? '';
$search_report_date = $_POST['report_date'] ?? '';

// Prepare SQL query to fetch reports based on search criteria
$sql = "SELECT * FROM transport_cost_reports WHERE 1";

// Add filters to the query based on the search criteria
if (!empty($search_report_id)) {
    $sql .= " AND id LIKE '%" . $conn->real_escape_string($search_report_id) . "%'";
}
if (!empty($search_transport_id)) {
    $sql .= " AND transport_company LIKE '%" . $conn->real_escape_string($search_transport_id) . "%'";
}
if (!empty($search_route)) {
    $sql .= " AND route LIKE '%" . $conn->real_escape_string($search_route) . "%'";
}
if (!empty($search_report_date)) {
    $sql .= " AND report_date LIKE '%" . $conn->real_escape_string($search_report_date) . "%'";
}

// Execute the SQL query
$result = $conn->query($sql);

// Initialize TCPDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Add Title
$pdf->Cell(0, 10, 'Transport Cost Reports', 0, 1, 'C');

// Add Table Header
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Title', 1);
$pdf->Cell(30, 10, 'Date', 1);
$pdf->Cell(40, 10, 'Transport ID', 1);
$pdf->Cell(40, 10, 'Route', 1);
$pdf->Cell(30, 10, 'Total Cost', 1);
$pdf->Ln();

// Add Table Data
$pdf->SetFont('helvetica', '', 10);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(20, 10, $row['id'], 1);
        $pdf->Cell(40, 10, $row['report_title'], 1);
        $pdf->Cell(30, 10, $row['report_date'], 1);
        $pdf->Cell(40, 10, $row['transport_company'], 1);
        $pdf->Cell(40, 10, $row['route'], 1);
        $pdf->Cell(30, 10, number_format($row['total'], 2), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No data found', 1, 1, 'C');
}

// Close and Output PDF
$pdf->Output('transport_reports.pdf', 'D');

// Close database connection
$conn->close();
?>
