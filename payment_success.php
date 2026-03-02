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

// --- NEW: HANDLE PHOTO UPLOAD BEFORE INSERT ---
$photo_path = 'assets/images/default-user.png'; // Fallback
if(isset($_SESSION['reg_files']['photo'])) {
    $file = $_SESSION['reg_files']['photo'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_name = "athlete_" . time() . "_" . rand(1000, 9999) . "." . $ext;
    $target = "assets/uploads/photos/" . $new_name;
    
    if(move_uploaded_file($file['tmp_name'], $target)) {
        $photo_path = $target;
    }
}

// 1. Generate Professional UID (FSA-2026-XXXX)
$year = date('Y');
$random = rand(1000, 9999);
$new_uid = "SDSDT-" . $year . "-" . $random;

// 2. Security: Hash the password (using mobile as default)
$temp_pass = password_hash($data['mobile'], PASSWORD_DEFAULT);

// 3. Prepare additional fields
$mother_name = isset($data['mother_name']) ? $data['mother_name'] : 'NOT PROVIDED';
$state = isset($data['state']) ? $data['state'] : 'Uttar Pradesh'; 

/**
 * 4. MySQL Insert Query
 * types: s (string), d (double/decimal), i (integer)
 */
$sql = "INSERT INTO athletes (
    uid, password, full_name, aadhaar_no, dob, gender, 
    blood_group, email, mobile, athlete_category, 
    sport, height_cm, weight_kg, father_name, mother_name, 
    address_line, district, state, fee_paid, payment_id, photo
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$fee = ($data['fee_type'] == 'ration') ? 500 : 1000;

// CORRECTED BIND PARAM: 21 placeholders = 21 types
// Type string: s (uid), s (pass), s (name), s (aadhaar), s (dob), s (gender), s (blood), s (email), s (mob), s (cat), s (sport), d (h), d (w), s (f), s (m), s (addr), s (dist), s (state), d (fee), s (payid), s (photo)
$types = "sssssssssssddsssssdss"; 

$stmt->bind_param($types, 
    $new_uid, 
    $temp_pass, 
    $data['fullname'], 
    $data['aadhaar_no'], 
    $data['dob'], 
    $data['gender'], 
    $data['blood_group'], 
    $data['email'], 
    $data['mobile'], 
    $data['athlete_category'], 
    $data['sport'],
    $data['height'], 
    $data['weight'], 
    $data['father_name'], 
    $mother_name, 
    $data['address'],
    $data['district'], 
    $state, 
    $fee, 
    $pay_id,
    $photo_path
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful | FSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-900 font-sans">

<?php
if($stmt->execute()) {
    $inserted_id = $conn->insert_id;
    // Clear session to prevent duplicate entry
    unset($_SESSION['reg_data']);
    unset($_SESSION['reg_files']);
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
                    <span class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter italic">
                        <?php echo $new_uid; ?>
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-10 text-left">
                    <div class="border-l-4 border-orange-500 pl-4">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Sport Discipline</p>
                        <p class="font-black text-slate-800 uppercase italic"><?php echo htmlspecialchars($data['sport']); ?></p>
                    </div>
                    <div class="border-l-4 border-orange-500 pl-4">
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Aadhaar Number</p>
                        <p class="font-black text-slate-800 uppercase italic">XXXX-XXXX-<?php echo substr($data['aadhaar_no'], -4); ?></p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="registration.php?success=1&id=<?php echo $inserted_id; ?>" 
                       class="bg-orange-600 text-white px-10 py-4 font-black uppercase tracking-widest text-sm hover:bg-slate-900 transition-all flex items-center justify-center gap-2 shadow-xl">
                        View & Print ID Card
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
    echo "<div class='text-white p-20 text-center font-bold'>";
    echo "<h2 class='text-2xl text-red-500'>CRITICAL ERROR</h2>";
    echo "Data could not be saved. " . $conn->error;
    echo "<br>Contact support with Payment ID: <span class='text-orange-500'>$pay_id</span>";
    echo "</div>";
}
?>
</body>
</html>