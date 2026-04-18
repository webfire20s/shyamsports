<?php
session_start();
include('includes/db_connect.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Only allow POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    die("Invalid request");
}

// ✅ Basic validation
if(empty($_POST['aadhaar_no'])){
    die("Form data missing");
}

$aadhaar_no = mysqli_real_escape_string($conn, $_POST['aadhaar_no']);

/* ================================
   🔴 DUPLICATE AADHAAR CHECK
================================ */
$check_sql = "SELECT id FROM athletes WHERE aadhaar_no = '$aadhaar_no'";
$result = $conn->query($check_sql);

if($result && $result->num_rows > 0) {
    header("Location: registration.php?status=duplicate_aadhaar");
    exit();
}

/* ================================
   🔴 HANDLE FORM DATA
================================ */
$blood_group = $_POST['blood_group'] ?? '';
$height = $_POST['height'] ?? 0;
$weight = $_POST['weight'] ?? 0;
$father = $_POST['father_name'] ?? '';
$mother = $_POST['mother_name'] ?? '';
$address = $_POST['address'] ?? '';
$district = $_POST['district'] ?? '';
$state = $_POST['state'] ?? 'Uttar Pradesh';
$pincode = $_POST['pincode'] ?? '';
$passport = $_POST['passport_no'] ?? '';

$has_ration = ($_POST['fee_type'] == 'ration') ? 1 : 0;
$fee_paid = ($_POST['fee_type'] == 'ration') ? 50 : 100;

/* ================================
   🔴 HANDLE PHOTO UPLOAD
================================ */
$photo_path = '';

if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
    $upload_dir = "uploads/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $photo_name = time() . "_photo_" . basename($_FILES['photo']['name']);
    $target_file = $upload_dir . $photo_name;

    if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)){
        $photo_path = $target_file;
    }
}

/* ================================
   🔴 HANDLE AADHAAR DOC
================================ */
$aadhar_path = '';

if(isset($_FILES['aadhar_doc']) && $_FILES['aadhar_doc']['error'] == 0){
    $upload_dir = "uploads/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $aadhar_name = time() . "_aadhar_" . basename($_FILES['aadhar_doc']['name']);
    $target_file = $upload_dir . $aadhar_name;

    if(move_uploaded_file($_FILES['aadhar_doc']['tmp_name'], $target_file)){
        $aadhar_path = $target_file;
    }
}

/* ================================
   🔴 HANDLE PASSPORT DOC (OPTIONAL)
================================ */
$passport_path = '';

if(isset($_FILES['passport_doc']) && $_FILES['passport_doc']['error'] == 0){
    $upload_dir = "uploads/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $passport_name = time() . "_passport_" . basename($_FILES['passport_doc']['name']);
    $target_file = $upload_dir . $passport_name;

    if(move_uploaded_file($_FILES['passport_doc']['tmp_name'], $target_file)){
        $passport_path = $target_file;
    }
}

/* ================================
   🔴 HANDLE PAYMENT SCREENSHOT (MANDATORY)
================================ */
$payment_path = '';

if(isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] == 0){

    $upload_dir = "uploads/payments/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];

    if(!in_array($ext, $allowed)){
        die("Invalid payment screenshot format");
    }

    $file_name = "pay_" . time() . "_" . rand(1000,9999) . "." . $ext;
    $target = $upload_dir . $file_name;

    if(move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $target)){
        $payment_path = $target;
    } else {
        die("Failed to upload payment proof");
    }

} else {
    die("Payment screenshot is required");
}

// 🔹 Generate UID using timestamp + random
$uid = "SDSDT-" . str_pad($next_id, 5, '0', STR_PAD_LEFT);
/* ================================
   🔴 INSERT INTO DATABASE (PENDING)
================================ */
$query = "INSERT INTO athletes (
    full_name, aadhaar_no, dob, gender, blood_group,
    email, mobile, sport, athlete_category,
    height_cm, weight_kg,
    father_name, mother_name,
    address_line, district, state, pincode,
    passport_number,
    photo, aadhar_doc, passport_doc,
    has_ration_card, fee_paid,uid,
    payment_screenshot, payment_status,
    registration_date
) VALUES (
    '{$_POST['fullname']}',
    '{$_POST['aadhaar_no']}',
    '{$_POST['dob']}',
    '{$_POST['gender']}',
    '$blood_group',
    '{$_POST['email']}',
    '{$_POST['mobile']}',
    '{$_POST['sport']}',
    '{$_POST['athlete_category']}',
    '$height',
    '$weight',
    '$father',
    '$mother',
    '$address',
    '$district',
    '$state',
    '$pincode',
    '$passport',
    '$photo_path',
    '$aadhar_path',
    '$passport_path',
    '$has_ration',
    '$fee_paid',
    '$uid',
    '$payment_path',
    'pending',
    NOW()
)";

if(mysqli_query($conn, $query)){
    header("Location: payment_success.php?status=pending");
    exit();
} else {
    echo "DB Error: " . mysqli_error($conn);
    exit();
}
?>