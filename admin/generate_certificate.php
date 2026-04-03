<?php
require('../fpdf.php');
include('../includes/db_connect.php');

$uid = $_POST['uid'];
$type = $_POST['type'];
$event = $_POST['event_name'];
$date = $_POST['event_date'];
$venue = $_POST['venue'];
$position = $_POST['position'];
$performance = $_POST['performance'];

// 🔹 Fetch athlete
$stmt = $conn->prepare("SELECT * FROM athletes WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if(!$user){
    die("Athlete not found!");
}

// 🔹 Create PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Background image
$bg = ($type == 'Merit') 
    ? '../assets/certificates/merit.jpeg' 
    : '../assets/certificates/participation.jpeg';

$pdf->Image($bg, 0, 0, 297, 210);

// 🔥 DYNAMIC TEXT (ADJUST POSITIONS IF NEEDED)
// 🔥 FONT SETUP
$pdf->SetTextColor(0,0,0);

// =======================
// 🔷 DATE & VENUE (TOP LINE)
// =======================
$pdf->SetFont('Arial','B',12);

$pdf->SetXY(95, 82);
$pdf->Cell(60, 8, date('d-m-Y', strtotime($date)), 0, 0, 'L');

$pdf->SetXY(165, 82);
$pdf->Cell(80, 8, $venue, 0, 0, 'L');


// // =======================
// // 🔷 CERTIFICATE TITLE FIX
// // =======================
// $pdf->SetFont('Arial','B',26);
// $pdf->SetXY(0, 75);
// $pdf->Cell(297, 10, ($type == 'Merit') ? 'Certificate of Merit' : 'Participation Certificate', 0, 0, 'C');


// =======================
// 🔷 NAME LINE
// =======================
$pdf->SetFont('Arial','B',14);

$pdf->SetXY(113, 110);
$pdf->Cell(120, 8, strtoupper($user['full_name']), 0, 0, 'L');


// =======================
// 🔷 REPRESENTING (SPORT / DISTRICT)
// =======================
$pdf->SetFont('Arial','',12);

$pdf->SetXY(245, 110);
$pdf->Cell(70, 8, $user['district'], 0, 0, 'L');


// =======================
// 🔷 DOB
// =======================
$pdf->SetXY(40, 123);
$pdf->Cell(80, 8, date('d-m-Y', strtotime($user['dob'])), 0, 0, 'L');


// =======================
// 🔷 FATHER NAME
// =======================
$pdf->SetXY(188, 123);
$pdf->Cell(120, 8, $user['father_name'], 0, 0, 'L');


// =======================
// 🔷 POSITION + PERFORMANCE
// =======================
$pdf->SetFont('Arial','B',12);

$pdf->SetXY(80, 136);
$pdf->Cell(40, 8, $position ?: '-', 0, 0, 'C');

$pdf->SetXY(240, 136);
$pdf->Cell(40, 8, $performance ?: '-', 0, 0, 'C');


// =======================
// 🔷 SPORT NAME
// =======================
$pdf->SetXY(60, 148);
$pdf->Cell(180, 8, strtoupper($user['sport']), 0, 0, 'C');


// =======================
// 🔷 CATEGORY / EVENT LINE
// =======================
$pdf->SetFont('Arial','',12);

$pdf->SetXY(60, 162);
$pdf->Cell(180, 8, $event . " | " . $venue, 0, 0, 'C');


// =======================
// 🔷 PHOTO BOX (TOP RIGHT)
// =======================
if(!empty($user['photo']) && file_exists("../" . $user['photo'])){
    $pdf->Image("../" . $user['photo'], 257, 65, 30, 35);
}


// =======================
// 🔷 SIGN BOX (BOTTOM RIGHT - OPTIONAL)
// =======================
if(!empty($user['photo']) && file_exists("../" . $user['photo'])){
    $pdf->Image("../" . $user['photo'], 211, 170, 30, 35);
}

// Save file
if(!is_dir("../certificates")){
    mkdir("../certificates",0777,true);
}

$file = "../certificates/" . time() . ".pdf";
$pdf->Output('F', $file);

// Save DB
mysqli_query($conn, "INSERT INTO certificates 
(uid, athlete_id, certificate_type, sport, position, performance, event_name, event_date, venue, file_path)
VALUES (
'$uid',
'{$user['id']}',
'$type',
'{$user['sport']}',
'$position',
'$performance',
'$event',
'$date',
'$venue',
'$file'
)");

header("Location: winners.php?success=1");