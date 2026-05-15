<?php
require('../fpdf.php');
include('../includes/db_connect.php');
require('../includes/phpqrcode/qrlib.php');

/* =========================
   🔷 FORM DATA
========================= */
$uid         = $_POST['uid'];
$event       = $_POST['event_name'];
$date        = $_POST['event_date'];
$venue       = $_POST['venue'];
$position    = $_POST['position'] ?? '';
$performance = $_POST['performance'] ?? '';

/* =========================
   🔷 FETCH ATHLETE
========================= */
$stmt = $conn->prepare("SELECT * FROM athletes WHERE uid = ?");
$stmt->bind_param("s", $uid);
$stmt->execute();

$result = $stmt->get_result();
$user   = $result->fetch_assoc();

if(!$user){
    die("Athlete not found!");
}

/* =========================
   🔷 CREATE PDF
========================= */
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

/* =========================
   🔷 BACKGROUND
========================= */
$bg = '../assets/certificates/district.jpg';

if(file_exists($bg)){
    $pdf->Image($bg, 0, 0, 210, 297);
}

/* =========================
   🔷 TEXT SETTINGS
========================= */
$pdf->SetTextColor(0,0,0);

/* =========================================================
   🔷 ATHLETE PHOTO (TOP RIGHT BOX)
========================================================= */
if(!empty($user['photo'])){

    $photoPath = "../" . $user['photo'];

    if(file_exists($photoPath)){

        // X, Y, WIDTH, HEIGHT
        // Adjust if needed according to exact box
        $pdf->Image($photoPath, 170, 17, 28, 34);
    }
}

/* =========================================================
   🔷 NAME
========================================================= */
$pdf->SetFont('Arial','B',13);

$pdf->SetXY(45, 86);
$pdf->Cell(145, 8, strtoupper($user['full_name']), 0, 0, 'L');

/* =========================================================
   🔷 FATHER NAME
========================================================= */
$pdf->SetFont('Arial','',12);

$pdf->SetXY(62, 104);
$pdf->Cell(130, 8, strtoupper($user['father_name']), 0, 0, 'L');

/* =========================================================
   🔷 EVENT NAME
========================================================= */
$pdf->SetFont('Arial','',12);

$pdf->SetXY(53, 120);
$pdf->Cell(80, 8, $event, 0, 0, 'L');

/* =========================================================
   🔷 EVENT DATE
========================================================= */
$pdf->SetXY(165, 120);
$pdf->Cell(50, 8, date('d-m-Y', strtotime($date)), 0, 0, 'L');

/* =========================================================
   🔷 VENUE
========================================================= */
$pdf->SetXY(40, 136);
$pdf->Cell(150, 8, strtoupper($venue), 0, 0, 'L');

/* =========================================================
   🔷 POSITION
========================================================= */
$pdf->SetFont('Arial','B',12);

$pdf->SetXY(42, 154);
$pdf->Cell(55, 8, $position ?: '-', 0, 0, 'L');

/* =========================================================
   🔷 PERFORMANCE
========================================================= */
$pdf->SetXY(130, 154);
$pdf->Cell(70, 8, $performance ?: '-', 0, 0, 'L');

/* =========================================================
   🔷 SPORT / EVENT LINE
========================================================= */
$pdf->SetFont('Arial','',12);

$pdf->SetXY(40, 170);
$pdf->Cell(150, 8, strtoupper($user['sport']), 0, 0, 'L');

/* =========================================================
   🔷 FROM DATE
========================================================= */
$pdf->SetXY(70, 204);
$pdf->Cell(70, 8, date('d-m-Y', strtotime($date)), 0, 0, 'L');

/* =========================================================
   🔷 DOB
========================================================= */
$pdf->SetXY(118, 220);
$pdf->Cell(70, 8, date('d-m-Y', strtotime($user['dob'])), 0, 0, 'L');

/* =========================================================
   🔷 QR CODE
========================================================= */
if(!is_dir("../temp_qr")){
    mkdir("../temp_qr", 0777, true);
}

$qrData =
    "UID: " . $user['uid'] . "\n" .
    "Name: " . $user['full_name'] . "\n" .
    "Sport: " . $user['sport'] . "\n" .
    "Event: " . $event;

$qrFile = "../temp_qr/" . $user['uid'] . "_district.png";

if(!file_exists($qrFile)){
    QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 4);
}

/* =========================================================
   🔷 QR POSITION (BOTTOM RIGHT BOX)
========================================================= */
$pdf->Image($qrFile, 145, 236, 40, 40);

/* =========================
   🔷 SAVE PDF
========================= */
if(!is_dir("../certificates")){
    mkdir("../certificates", 0777, true);
}

$file = "../certificates/district_" . time() . ".pdf";

$pdf->Output('F', $file);

/* =========================
   🔷 SAVE DATABASE
========================= */
mysqli_query($conn, "
    INSERT INTO certificates (
        uid,
        athlete_id,
        certificate_type,
        sport,
        position,
        performance,
        event_name,
        event_date,
        venue,
        file_path
    ) VALUES (
        '$uid',
        '{$user['id']}',
        'District',
        '{$user['sport']}',
        '$position',
        '$performance',
        '$event',
        '$date',
        '$venue',
        '$file'
    )
");

/* =========================
   🔷 REDIRECT
========================= */
header("Location: winners.php?success=1");
exit();
?>