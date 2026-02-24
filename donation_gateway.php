<?php
session_start();
// FIX 1: Include the database connection
include('includes/db_connect.php'); 

// Check if data was actually posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // FIX 2: Store POST data in Session so we can use it in donation_success.php
    $_SESSION['donor_name'] = mysqli_real_escape_string($conn, $_POST['donor_name']);
    $_SESSION['donor_email'] = mysqli_real_escape_string($conn, $_POST['donor_email']);
    $_SESSION['donation_amount'] = mysqli_real_escape_string($conn, $_POST['amount']);
    
    $api_key = "YOUR_RAZORPAY_KEY"; 
    $amount_in_paise = $_SESSION['donation_amount'] * 100;

    // NOTE: We do NOT insert into SQL here. We do it in donation_success.php 
    // after the payment is actually successful.
} else {
    header("Location: donate.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing Donation...</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body { background: #0f172a; display: flex; align-items: center; justify-content: center; height: 100vh; color: white; font-family: sans-serif; }
        .loader { border: 4px solid rgba(255,255,255,0.1); border-top: 4px solid #ff6600; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto 20px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <div class="loader"></div>
        <h2 style="text-transform: uppercase; letter-spacing: 2px;">Securing Gateway...</h2>
        <p style="color: #94a3b8; font-size: 14px;">Preparing your donation of ₹<?php echo $_SESSION['donation_amount']; ?></p>
    </div>

    <script>
    var options = {
        "key": "<?php echo $api_key; ?>",
        "amount": "<?php echo $amount_in_paise; ?>",
        "currency": "INR",
        "name": "Firozabad Sports Academy",
        "description": "Donation for Athlete Development",
        "image": "assets/images/logo.png",
        "handler": function (response){
            // This only triggers if payment succeeds
            window.location.href = "donation_success.php?pay_id=" + response.razorpay_payment_id;
        },
        "prefill": {
            "name": "<?php echo $_SESSION['donor_name']; ?>",
            "email": "<?php echo $_SESSION['donor_email']; ?>"
        },
        "theme": { "color": "#ff6600" },
        "modal": {
            "ondismiss": function(){
                window.location.href = "donate.php?status=cancelled";
            }
        }
    };
    var rzp1 = new Razorpay(options);
    window.onload = function() {
        rzp1.open();
    };
    </script>
</body>
</html>