<?php
require('fpdf.php'); // Include FPDF
include("connection.php");

// Check if the ID is passed
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch donor details from the database
    $q = $db->prepare("SELECT * FROM donor_regis WHERE id = ?");
    $q->execute([$id]);
    $donor = $q->fetch(PDO::FETCH_OBJ);

    if ($donor) {
        // Create a PDF with Landscape orientation (Wider layout)
        $pdf = new FPDF('L', 'mm', 'A4'); // 'L' is for landscape orientation
        $pdf->AddPage();

        // Set page background color (light)
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Rect(0, 0, 297, 210, 'F'); // A4 size in landscape mode (297mm width, 210mm height)
      
        // Add Logo
        $pdf->Image('logo.png', 120, 15, 50, 50);  // Adjust the logo path and position

        $pdf->Ln(50);

        // Title - Blood Donation Certificate
        $pdf->SetFont('Arial', 'B', 30);
        $pdf->SetTextColor(0, 102, 204);  // Blue color
        $pdf->Cell(0, 40, 'Blood Donation Certificate', 0, 1, 'C');
        $pdf->Ln(10);
  
        // Text Message - Donor information
        $pdf->SetFont('Arial', '', 18);
        $pdf->SetTextColor(0, 0, 0);  // Black color
        $pdf->MultiCell(0, 10, "This is to certify that Mr./Ms. " . $donor->name . " has generously donated blood to save lives.", 0, 'C');
        $pdf->Ln(13);

        // Blood Group
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Blood Group: ' . $donor->bgroup, 0, 1, 'C');
        $pdf->Ln(13);

        // Thank You Message
        $pdf->SetFont('Arial', 'I', 14);
        $pdf->MultiCell(0, 10, 'Thank you for your valuable contribution!', 0, 'C');
        $pdf->Ln(8);

        // Footer Text
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetTextColor(169, 169, 169);  // Gray color
        $pdf->Cell(0, 10, 'Your generosity helps to save lives. We appreciate your kindness.', 0, 1, 'C');

        // Output PDF directly (this will download the PDF)
        $pdf->Output('D', 'Blood_Donation_Certificate_' . $donor->name . '.pdf'); // 'D' forces download
    } else {
        echo "Donor not found.";
    }
} else {
    echo "Invalid request.";
}
?>
