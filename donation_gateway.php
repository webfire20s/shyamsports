<?php
session_start();

// Check if data was actually posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['donor_name']);
    $email = mysqli_real_escape_string($conn, $_POST['donor_email']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    
    $api_key = "YOUR_RAZORPAY_KEY"; // Replace with actual key from Boss
    $amount_in_paise = $_SESSION['donation_amount'] * 100;
    // For now, we assume direct "Completion" since it's a demo/manual record
    $sql = "INSERT INTO donations (donor_name, donor_email, amount, transaction_status) 
            VALUES ('$name', '$email', '$amount', 'Completed')";

    if ($conn->query($sql)) {
        header("Location: donate.php?status=success");
    } else {
        header("Location: donate.php?status=error");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing Donation...</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body { background: #001e5f; display: flex; align-items: center; justify-content: center; height: 100vh; color: white; font-family: sans-serif; }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h2>Processing Secure Payment...</h2>
        <p>Please do not refresh or close this window.</p>
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
            // Redirect to a specific donation success page
            window.location.href = "donation_success.php?pay_id=" + response.razorpay_payment_id;
        },
        "prefill": {
            "name": "<?php echo $_SESSION['donor_name']; ?>",
            "email": "<?php echo $_SESSION['donor_email']; ?>"
        },
        "theme": { "color": "#ff6600" } // Use the Academy Orange for the donation button
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
    </script>
</body>
</html>