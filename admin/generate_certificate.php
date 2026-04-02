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

// 🔥 PAGE CONSTANTS
$pageWidth = 297;
$centerX = $pageWidth / 2;

// 🔥 HELPER FUNCTION (PERFECT CENTER + AUTO FIT)
function centerText($pdf, $text, $y, $fontSize = 20, $style = 'B') {
    $pdf->SetFont('Arial', $style, $fontSize);

    // Auto shrink if text too long
    while($pdf->GetStringWidth($text) > 240) {
        $fontSize -= 1;
        $pdf->SetFont('Arial', $style, $fontSize);
    }

    $pdf->SetXY(0, $y);
    $pdf->Cell(297, 10, strtoupper($text), 0, 0, 'C');
}

// 🔥 FORMAT DATA
$name = $user['full_name'] ?? 'N/A';
$dob  = !empty($user['dob']) ? date('d F Y', strtotime($user['dob'])) : 'N/A';
$sport = $user['sport'] ?? 'N/A';
$pos = $position ?: '-';
$eventText = $event ?: '';
$venueText = $venue ?: '';

// 🔥 EXACT ALIGNMENT (TUNED FOR YOUR DESIGN)

// NAME (BIG CENTER)
centerText($pdf, $name, 92, 28, 'B');

// DOB (SMALL BELOW NAME)
centerText($pdf, "Date of Birth: $dob", 108, 14, '');

// POSITION (BOLD CENTER)
centerText($pdf, $pos, 124, 18, 'B');

// SPORT (BOTTOM CENTER)
centerText($pdf, $sport, 140, 18, 'B');

// EVENT + VENUE (FOOTER LINE)
$pdf->SetFont('Arial','',12);
$pdf->SetXY(0, 160);
$pdf->Cell(297, 10, "$eventText | $venueText", 0, 0, 'C');

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