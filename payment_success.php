<?php
include('includes/db_connect.php'); 
session_start();

// Redirect if accessed directly without payment
if(!isset($_GET['pay_id']) || !isset($_SESSION['reg_data'])) {
    header("Location: registration.php");
    exit();
}

$pay_id = $_GET['pay_id'];
$data = $_SESSION['reg_data'];

// 1. Generate Professional UID (FSA-2026-XXXX)
$year = date('Y');
$random = rand(1000, 9999);
$new_uid = "FSA-" . $year . "-" . $random;

// 2. Security: Hash the password (using mobile as default)
$temp_pass = password_hash($data['mobile'], PASSWORD_DEFAULT);

/**
 * 3. MySQL Insert Query
 * Updated to include: athlete_category, district, state, and secondary sport logic
 */
$sql = "INSERT INTO athletes (
    uid, password, full_name, dob, gender, 
    blood_group, email, mobile, athlete_category, 
    sport, height_cm, weight_kg, father_name, mother_name, 
    address_line, district, state, fee_paid, payment_id
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$fee = ($data['fee_type'] == 'ration') ? 500 : 1000;

// Mapping the variables for bind_param
$stmt->bind_param("ssssssssssddsssssds", 
    $new_uid, 
    $temp_pass, 
    $data['fullname'], 
    $data['dob'], 
    $data['gender'], 
    $data['blood_group'], 
    $data['email'], 
    $data['mobile'], 
    $data['athlete_category'], // New Field
    $data['sport'],           // From our dynamic dropdown
    $data['height'], 
    $data['weight'], 
    $data['father_name'], 
    $data['mother_name'], 
    $data['address'],
    $data['district'],         // New Field
    $data['state'],            // New Field
    $fee, 
    $pay_id
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful | FSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-900 font-sans">

<?php
if($stmt->execute()) {
    // Clear session to prevent duplicate entry on refresh
    unset($_SESSION['reg_data']);
?>
    <div class="container mx-auto min-h-screen flex items-center justify-center p-4">
        <div class="bg-white max-w-2xl w-full shadow-[0_20px_50px_rgba(0,0,0,0.5)] relative overflow-hidden animate__animated animate__zoomIn">
            
            <div class="bg-green-600 p-8 text-center text-white relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-white/20"></div>
                <div class="w-20 h-20 bg-white text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-3xl font-black uppercase italic tracking-tighter">Registration Complete</h2>
                <p class="text-green-100 font-bold text-sm tracking-widest uppercase mt-2">Elite Athlete Profile Created</p>
            </div>

            <div class="p-10 text-center">
                <p class="text-gray-500 font-medium mb-2 uppercase text-xs tracking-widest">Your Unique National ID (UID)</p>
                <div class="bg-slate-100 border-2 border-dashed border-slate-300 p-6 mb-8 group transition-all">
                    <span class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter italic selection:bg-orange-500 selection:text-white">
                        <?php echo $new_uid; ?>
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-10">
                    <div class="text-left border-l-4 border-orange-500 pl-4">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Sport Discipline</p>
                        <p class="font-black text-slate-800 uppercase italic"><?php echo $data['sport']; ?></p>
                    </div>
                    <div class="text-left border-l-4 border-orange-500 pl-4">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Category</p>
                        <p class="font-black text-slate-800 uppercase italic"><?php echo $data['athlete_category']; ?></p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="generate_receipt.php?uid=<?php echo $new_uid; ?>" 
                       class="bg-slate-900 text-white px-10 py-4 font-black uppercase tracking-widest text-sm hover:bg-orange-600 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Download ID Card
                    </a>
                    <a href="login.php" 
                       class="border-2 border-slate-900 text-slate-900 px-10 py-4 font-black uppercase tracking-widest text-sm hover:bg-slate-900 hover:text-white transition-all">
                        Athlete Login
                    </a>
                </div>
            </div>
            
            <div class="bg-slate-50 p-4 border-t text-center">
                <p class="text-[9px] text-gray-400 font-bold uppercase">Transaction ID: <?php echo $pay_id; ?> | Securely Processed by Razorpay</p>
            </div>
        </div>
    </div>
<?php
} else {
    echo "<div class='text-white p-20 text-center font-bold'>Error saving data. Please contact support with Payment ID: $pay_id</div>";
}
?>
</body>
</html> 