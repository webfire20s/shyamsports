<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: donate.php");
    exit();
}

/* ================================
   🔹 SANITIZE INPUT
================================ */
$donor_name  = mysqli_real_escape_string($conn, $_POST['donor_name']);
$donor_email = mysqli_real_escape_string($conn, $_POST['donor_email']);
$amount      = mysqli_real_escape_string($conn, $_POST['amount']);

/* ================================
   🔹 HANDLE SCREENSHOT UPLOAD
================================ */
$payment_path = '';

if(isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0){

    $upload_dir = "uploads/donations/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . "_donation_" . basename($_FILES['payment_proof']['name']);
    $target = $upload_dir . $file_name;

    if(move_uploaded_file($_FILES['payment_proof']['tmp_name'], $target)){
        $payment_path = $target;
    } else {
        die("Error uploading payment screenshot.");
    }
} else {
    die("Payment screenshot is required.");
}

/* ================================
   🔹 GENERATE TRANSACTION ID
================================ */
$transaction_id = "DON-" . date('YmdHis');

/* ================================
   🔹 INSERT INTO DATABASE
================================ */
$sql = "INSERT INTO donations 
(donor_name, donor_email, amount, payment_id, payment_proof, transaction_status, created_at)
VALUES (?, ?, ?, ?, ?, 'completed', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdss", $donor_name, $donor_email, $amount, $transaction_id, $payment_path);

if($stmt->execute()){
    
    // Redirect to success page
    header("Location: donation_success.php?txn=$transaction_id&amount=$amount&name=" . urlencode($donor_name));
    exit();

} else {
    echo "Database Error: " . $conn->error;
}
?>