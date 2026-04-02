<?php
require('fpdf.php');
include('includes/db_connect.php');
session_start();

// Get UID from URL and fetch data from Database
if(isset($_GET['uid'])) {
    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    
    // Using simple query for compatibility, or Prepared Statement as you had it
    $query = "SELECT * FROM athletes WHERE uid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if(!$data) { 
        die("Invalid UID. Record not found in Firozabad Sports Academy database."); 
    }

    // Initialize PDF - A5 size is great for receipts
    $pdf = new FPDF('P','mm','A5'); 
    $pdf->AddPage();
    
    // --- Header Branding ---
    $pdf->SetFillColor(0, 30, 95); // Academy Navy Blue
    $pdf->Rect(0, 0, 148, 35, 'F'); // Adjusted width for A5 (148mm)
    
    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetY(10);
    $pdf->Cell(0, 8, 'SHYAMVIR DADDA SPORTS TRUST', 0, 1, 'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0, 5, 'FIROZABAD SPORTS ACADEMY - OFFICIAL RECEIPT', 0, 1, 'C');
    
    $pdf->Ln(15);
    $pdf->SetTextColor(0, 0, 0);
    
    // --- Receipt Info ---
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(25, 6, 'Receipt No:', 0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(55, 6, 'SDSDT-' . strtoupper(substr($data['payment_id'], -6)), 0);
    
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(15, 6, 'Date:', 0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0, 6, date('d-m-Y'), 0, 1);
    
    $pdf->Ln(2);
    $pdf->Line(10, 52, 138, 52);
    $pdf->Ln(5);
    
    // --- Athlete Details Section ---
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(245, 245, 245);
    $pdf->Cell(0, 8, '  ATHLETE INFORMATION', 0, 1, 'L', true);
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40, 7, 'Full Name:', 0); 
    // FIXED: Ensured column name matches 'full_name' from your DB
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0, 7, strtoupper($data['full_name']), 0, 1);
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40, 7, 'Unique ID (UID):', 0); 
    $pdf->SetFont('Arial','B',10); 
    $pdf->SetTextColor(210, 50, 0); // Orange for UID
    $pdf->Cell(0, 7, $data['uid'], 0, 1);
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40, 7, 'Sport Discipline:', 0); 
    $pdf->Cell(0, 7, $data['sport'], 0, 1);
    
    $pdf->Cell(40, 7, 'Category:', 0); 
    $pdf->Cell(0, 7, $data['athlete_category'], 0, 1);
    
    $pdf->Cell(40, 7, 'Mobile:', 0); 
    $pdf->Cell(0, 7, '+91 ' . $data['mobile'], 0, 1);
    
    $pdf->Ln(8);
    
    // --- Payment Table ---
    $pdf->SetFillColor(0, 30, 95);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(85, 8, '  Description', 1, 0, 'L', true);
    $pdf->Cell(43, 8, 'Amount (INR)  ', 1, 1, 'R', true);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(85, 10, '  Registration & UID Generation Fee', 1);
    
    // FIXED: Ensured column matches 'fee_paid'
    $pdf->Cell(43, 10, 'Rs. ' . number_format($data['fee_paid'], 2) . '  ', 1, 1, 'R');
    
    // Discount Note
    if($data['fee_paid'] < 100) {
        $pdf->SetFont('Arial','I',7);
        $pdf->SetTextColor(180, 0, 0);
        $pdf->Cell(0, 5, '* Special Category / Ration Card Discount Applied', 0, 1, 'R');
        $pdf->SetTextColor(0, 0, 0);
    }
    
    $pdf->Ln(10);
    
    // --- Transaction Footer ---
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0, 4, 'Payment Status: SUCCESSFUL', 0, 1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(0, 4, 'Transaction ID: ' . $data['payment_id'], 0, 1);
    $pdf->Cell(0, 4, 'Gateway: Razorpay Secure', 0, 1);
    
    $pdf->Ln(10);
    $pdf->SetFont('Arial','I',7);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->MultiCell(0, 4, 'Note: This is an electronically generated document. For any discrepancies, please contact the Trust office at Shekhupur, Narkhi, Firozabad.', 0, 'C');
    
    // --- Visual ID Barcode Style ---
    $pdf->SetY(-25);
    $pdf->SetFont('Courier','B',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 5, '|| |||| | |||| | ||| | || ||||', 0, 1, 'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(0, 3, 'VALID FOR TRIALS 2026-27', 0, 0, 'C');
    
    // Output PDF to Browser (D = Download, I = Inline display)
    $pdf->Output('I', 'SDSDT_Receipt_' . $uid . '.pdf');
} else {
    echo "Access Denied: No UID provided.";
}
?>