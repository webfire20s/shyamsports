<?php
require('../fpdf.php');
include('../includes/db_connect.php');
require('../includes/phpqrcode/qrlib.php');

$uid = $_POST['uid'];
$event = $_POST['event_name'];
$date = $_POST['event_date'];
$venue = $_POST['venue'];

// Fetch athlete
$stmt = $conn->prepare("SELECT * FROM athletes WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if(!$user){
    die("Athlete not found!");
}

// Create PDF (PORTRAIT)
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Background image (YOU MUST SAVE YOUR IMAGE)
$bg = '../assets/certificates/district.jpg';
$pdf->Image($bg, 0, 0, 210, 297);

// TEXT SETTINGS
$pdf->SetTextColor(0,0,0);

// =======================
// 🔷 ATHLETE PHOTO (TOP RIGHT BOX)
// =======================
if(!empty($user['photo'])){

    $photoPath = "../" . $user['photo'];

    // Debug-safe check
    if(file_exists($photoPath)){
        $pdf->Image($photoPath, 170, 17, 30, 35); // adjust X,Y as per your design
    }
}
// =======================
// NAME
// =======================
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(75, 92);
$pdf->Cell(130, 8, strtoupper($user['full_name']), 0, 0, 'L');

// =======================
// REPRESENTING
// =======================
$pdf->SetFont('Arial','',12);
$pdf->SetXY(65, 111);
$pdf->Cell(130, 8, $user['district'], 0, 0, 'L');

// =======================
// SPORT
// =======================
$pdf->SetXY(110, 129);
$pdf->Cell(130, 8, $user['sport'], 0, 0, 'L');

// =======================
// VENUE / EVENT NAME
// =======================
$pdf->SetXY(60, 150);
$pdf->Cell(130, 8, $event . " - " . $venue, 0, 0, 'L');

// =======================
// DATE RANGE (CUSTOMIZE IF NEEDED)
// =======================
$pdf->SetXY(65, 188);
$pdf->Cell(130, 8, date('d-m-Y', strtotime($date)), 0, 0, 'L');

// =======================
// DOB
// =======================
$pdf->SetXY(120, 207);
$pdf->Cell(130, 8, date('d-m-Y', strtotime($user['dob'])), 0, 0, 'L');

// =======================
// QR CODE (BOTTOM RIGHT)
// =======================
if(!is_dir("../temp_qr")){
    mkdir("../temp_qr", 0777, true);
}

$qrData = "UID: ".$user['uid']."\nName: ".$user['full_name'];

$qrFile = "../temp_qr/" . $user['uid'] . "_district.png";

if(!file_exists($qrFile)){
    QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 4);
}

// position matches your design box
$pdf->Image($qrFile, 145, 235, 40, 40);

// SAVE
if(!is_dir("../certificates")){
    mkdir("../certificates",0777,true);
}

$file = "../certificates/district_" . time() . ".pdf";
$pdf->Output('F', $file);

// SAVE DB
mysqli_query($conn, "INSERT INTO certificates 
(uid, athlete_id, certificate_type, sport, event_name, event_date, venue, file_path)
VALUES (
'$uid',
'{$user['id']}',
'District',
'{$user['sport']}',
'$event',
'$date',
'$venue',
'$file'
)");

header("Location: winners.php?success=1");