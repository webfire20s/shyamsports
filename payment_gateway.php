<?php
session_start();
include('includes/db_connect.php'); // Required to check for duplicates

/** * We capture the data and check for duplicate Aadhaar
 */
$aadhaar_no = mysqli_real_escape_string($conn, $_POST['aadhaar_no']);

// 1. Check if Aadhaar already exists in DB
$check_sql = "SELECT id FROM athletes WHERE aadhaar_no = '$aadhaar_no'";
$result = $conn->query($check_sql);

if($result && $result->num_rows > 0) {
    // If Aadhaar exists, redirect back to registration with an error message
    header("Location: registration.php?status=duplicate_aadhaar");
    exit();
}

// Store POST data in session for retrieval in payment_success.php
$_SESSION['reg_data'] = $_POST;

// Handle file uploads (Moving them to a temp folder or storing names in session)
// Note: Actual moving should happen in success page, but we track names here
if(isset($_FILES['photo'])) { $_SESSION['reg_files']['photo'] = $_FILES['photo']; }
if(isset($_FILES['aadhar_doc'])) { $_SESSION['reg_files']['aadhar_doc'] = $_FILES['aadhar_doc']; }

// Standardizing the fee logic
$amount = ($_POST['fee_type'] == 'ration') ? 500 : 1000;

// Placeholder for your Razorpay Key
$api_key = "YOUR_RAZORPAY_KEY"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Securing Payment Gateway...</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">

    <div class="text-center animate__animated animate__fadeIn">
        <div class="inline-block w-16 h-16 border-4 border-orange-600 border-t-transparent rounded-full animate-spin mb-6"></div>
        <h2 class="text-white font-black uppercase italic tracking-widest text-xl">Connecting to Gateway</h2>
        <p class="text-gray-400 text-xs mt-2 uppercase">Please do not refresh or close this window...</p>
        
        <div class="mt-8 bg-white/5 p-4 rounded border border-white/10">
            <p class="text-gray-400 text-[10px] uppercase font-bold">Athlete: <?php echo htmlspecialchars($_POST['fullname']); ?></p>
            <p class="text-orange-500 text-[10px] uppercase font-bold">Aadhaar: <?php echo htmlspecialchars($_POST['aadhaar_no']); ?></p>
            <p class="text-gray-400 text-[10px] uppercase font-bold">Category: <?php echo htmlspecialchars($_POST['athlete_category']); ?></p>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    var options = {
        "key": "<?php echo $api_key; ?>", 
        "amount": "<?php echo $amount * 100; ?>", // Amount in paise
        "currency": "INR",
        "name": "Firozabad Sports Academy",
        "description": "Registration Fee - <?php echo $_POST['athlete_category']; ?>",
        "image": "assets/images/logo.png",
        "handler": function (response){
            // Redirecting to success page to save data to DB and generate UID
            window.location.href = "payment_success.php?pay_id=" + response.razorpay_payment_id;
        },
        "prefill": {
            "name": "<?php echo $_POST['fullname']; ?>",
            "email": "<?php echo $_POST['email']; ?>",
            "contact": "<?php echo $_POST['mobile']; ?>"
        },
        "theme": { 
            "color": "#001e5f"
        },
        "modal": {
            "ondismiss": function(){
                window.location.href = "registration.php?status=cancelled";
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