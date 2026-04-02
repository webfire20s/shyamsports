<?php
session_start();
include('includes/db_connect.php');

/* ================================
   🔥 TEST MODE TO BYPASS PAYMENT
================================ */
$test_mode = false; // ✅ SET THIS TRUE FOR TESTING

$aadhaar_no = mysqli_real_escape_string($conn, $_POST['aadhaar_no']);

/* ================================
   DUPLICATE AADHAAR CHECK
================================ */
$check_sql = "SELECT id FROM athletes WHERE aadhaar_no = '$aadhaar_no'";
$result = $conn->query($check_sql);

if($result && $result->num_rows > 0) {
    header("Location: registration.php?status=duplicate_aadhaar");
    exit();
}

/* ================================
   TEST MODE FLOW (NO PAYMENT)
================================ */
if($test_mode){

    // 🔹 Generate UID (Temporary, based on next ID)
    $result = mysqli_query($conn, "SHOW TABLE STATUS LIKE 'athletes'");
    $row = mysqli_fetch_assoc($result);
    $next_id = $row['Auto_increment'];

    $uid = "SDSDT-" . str_pad($next_id, 4, '0', STR_PAD_LEFT);

    // 🔹 Password = Mobile (as per your system)
    $password = $_POST['mobile'];

    // 🔹 Handle optional fields safely
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

    // 🔹 HANDLE PHOTO UPLOAD
    $photo_path = '';

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){

        $upload_dir = "uploads/";
        
        // Create folder if not exists
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }

        $photo_name = time() . "_" . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $photo_name;

        if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)){
            $photo_path = $target_file;
        }
    }
    // 🔹 HANDLE AADHAAR DOCUMENT UPLOAD
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


    // 🔹 HANDLE PASSPORT DOCUMENT (OPTIONAL)
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

    // 🔹 Insert Query
    $query = "INSERT INTO athletes (
        uid, password, full_name, aadhaar_no, dob, gender, blood_group,
        email, mobile, sport, athlete_category, height_cm, weight_kg,
        father_name, mother_name, address_line, district, state, pincode,
        passport_number,photo,aadhar_doc,passport_doc, has_ration_card, fee_paid, payment_id, registration_date
    ) VALUES (
        '$uid',
        '$password',
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
        'TEST_PAYMENT',
        NOW()
    )";

    if(mysqli_query($conn, $query)){
        $last_id = mysqli_insert_id($conn);

        // 🔥 Redirect to UID card
        header("Location: registration.php?success=1&id=" . $last_id);
        exit();
    } else {
        echo "DB Error: " . mysqli_error($conn);
        exit();
    }
}
/* ================================
   ORIGINAL PAYMENT FLOW (UNCHANGED)
================================ */

// Store data in session
$_SESSION['reg_data'] = $_POST;

if(isset($_FILES['photo'])) { $_SESSION['reg_files']['photo'] = $_FILES['photo']; }
if(isset($_FILES['aadhar_doc'])) { $_SESSION['reg_files']['aadhar_doc'] = $_FILES['aadhar_doc']; }

$amount = ($_POST['fee_type'] == 'ration') ? 50 : 100;

$api_key = "YOUR_RAZORPAY_KEY";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Securing Payment Gateway...</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "<?php echo $api_key; ?>", 
    "amount": "<?php echo $amount * 100; ?>",
    "currency": "INR",
    "name": "Firozabad Sports Academy",
    "handler": function (response){
        window.location.href = "payment_success.php?pay_id=" + response.razorpay_payment_id;
    },
    "prefill": {
        "name": "<?php echo $_POST['fullname']; ?>",
        "email": "<?php echo $_POST['email']; ?>",
        "contact": "<?php echo $_POST['mobile']; ?>"
    }
};

var rzp1 = new Razorpay(options);
rzp1.open();
</script>

</body>
</html>