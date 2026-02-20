<?php
require('fpdf/fpdf.php');
include('includes/db_connect.php');
session_start();

// Get UID from URL and fetch data from Database
if(isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    
    $query = "SELECT * FROM athletes WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if(!$data) { die("Invalid UID."); }

    // Initialize PDF
    $pdf = new FPDF('P','mm','A5'); // A5 size is standard for receipts
    $pdf->AddPage();
    
    // Header Style
    $pdf->SetFillColor(0, 30, 95); // Academy Navy Blue
    $pdf->Rect(0, 0, 210, 35, 'F');
    
    $pdf->SetFont('Arial','B',16);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 10, 'FIROZABAD SPORTS ACADEMY', 0, 1, 'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0, 5, 'OFFICIAL REGISTRATION RECEIPT', 0, 1, 'C');
    
    $pdf->Ln(20);
    $pdf->SetTextColor(0, 0, 0);
    
    // Receipt Info Table
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(30, 8, 'Receipt No:', 0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(60, 8, 'REC-' . time(), 0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(20, 8, 'Date:', 0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0, 8, date('d-m-Y'), 0, 1);
    
    $pdf->Ln(5);
    $pdf->Line(10, 55, 138, 55);
    $pdf->Ln(5);
    
    // Athlete Details
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(0, 10, 'ATHLETE DETAILS', 0, 1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40, 7, 'Full Name:', 0); $pdf->Cell(0, 7, strtoupper($data['full_name']), 0, 1);
    $pdf->Cell(40, 7, 'Unique ID (UID):', 0); $pdf->SetFont('Arial','B',10); $pdf->Cell(0, 7, $data['uid'], 0, 1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40, 7, 'Sport Discipline:', 0); $pdf->Cell(0, 7, $data['sport'], 0, 1);
    $pdf->Cell(40, 7, 'Mobile:', 0); $pdf->Cell(0, 7, $data['mobile'], 0, 1);
    
    $pdf->Ln(10);
    
    // Payment Details Table
    $pdf->SetFillColor(240, 240, 240);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(90, 8, 'Description', 1, 0, 'L', true);
    $pdf->Cell(38, 8, 'Amount', 1, 1, 'R', true);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(90, 10, 'Registration Fee (One-time)', 1);
    $pdf->Cell(38, 10, 'INR ' . number_format($data['fee_paid'], 2), 1, 1, 'R');
    
    // Check if discount was applied
    if($data['fee_paid'] == 500) {
        $pdf->SetFont('Arial','I',8);
        $pdf->SetTextColor(200, 0, 0);
        $pdf->Cell(0, 5, '* 50% Ration Card Discount Applied', 0, 1, 'R');
    }
    
    $pdf->Ln(10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 5, 'Payment ID: ' . $data['payment_id'], 0, 1);
    $pdf->SetFont('Arial','I',8);
    $pdf->Cell(0, 5, 'This is a computer-generated receipt and does not require a signature.', 0, 1);
    
    // Footer Branding
    $pdf->SetY(-20);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->Cell(0, 10, 'Firozabad Sports Academy - Path to National Excellence', 0, 0, 'C');
    
    // Output PDF to Browser
    $pdf->Output('D', 'FSA_Receipt_' . $uid . '.pdf');
}
?>