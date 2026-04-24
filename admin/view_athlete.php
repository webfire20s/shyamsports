<?php
include('../includes/db_connect.php');
session_start();

if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM athletes WHERE id = '$id'";
$result = $conn->query($query);
$athlete = $result->fetch_assoc();

if(!$athlete) { echo "Athlete not found."; exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dossier: <?php echo $athlete['full_name']; ?> | FSA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-200 min-h-screen py-10">

    <div class="container mx-auto max-w-4xl">
        <a href="athletes.php" class="inline-block mb-6 text-xs font-black uppercase tracking-widest text-slate-500 hover:text-orange-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Roster
        </a>

        <div class="bg-white shadow-2xl overflow-hidden rounded-sm border-t-8 border-orange-600">
            <div class="bg-slate-900 p-8 text-white flex justify-between items-center">
                <div>
                    <span class="bg-orange-600 text-[10px] font-black px-3 py-1 uppercase tracking-widest">
                        <?php echo $athlete['athlete_category']; ?>
                    </span>
                    <h1 class="text-4xl font-black italic uppercase mt-2 tracking-tighter">
                        <?php echo $athlete['full_name']; ?>
                    </h1>
                    <p class="text-slate-400 font-mono text-sm uppercase mt-1">UID: <?php echo $athlete['uid']; ?></p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Status</p>
                    <?php
                    $status = $athlete['payment_status'];

                    $color = $status == 'approved' ? 'green' : ($status == 'rejected' ? 'red' : 'yellow');
                    ?>

                    <span class="bg-<?php echo $color; ?>-500/10 text-<?php echo $color; ?>-500 border border-<?php echo $color; ?>-500/20 px-4 py-2 font-black text-xs uppercase italic">
                        <?php echo strtoupper($status); ?>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3">
                
                <div class="bg-slate-50 p-8 border-r border-slate-100">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 border-b pb-2">Physical Metrics</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Height</p>
                            <p class="text-xl font-black text-slate-800 tracking-tighter"><?php echo $athlete['height_cm']; ?> <span class="text-xs">CM</span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Weight</p>
                            <p class="text-xl font-black text-slate-800 tracking-tighter"><?php echo $athlete['weight_kg']; ?> <span class="text-xs">KG</span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Blood Group</p>
                            <p class="text-xl font-black text-red-600 tracking-tighter"><?php echo $athlete['blood_group']; ?></p>
                        </div>
                        <div class="pt-4">
                             <p class="text-[10px] font-black text-slate-400 uppercase">Gender / DOB</p>
                             <p class="text-sm font-bold text-slate-700 uppercase"><?php echo $athlete['gender']; ?> | <?php echo $athlete['dob']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 p-8">
                    <div class="grid grid-cols-2 gap-8 mb-10">
                        <div>
                            <h4 class="text-[10px] font-black text-orange-600 uppercase mb-2">Primary Discipline</h4>
                            <p class="text-2xl font-black text-slate-800 uppercase italic"><?php echo $athlete['sport']; ?></p>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black text-orange-600 uppercase mb-2">Secondary Interest</h4>
                            <p class="text-2xl font-black text-slate-800 uppercase italic">N/A</p>
                        </div>
                    </div>

                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4 border-b pb-2">Family & Contact</h3>
                    <div class="grid grid-cols-2 gap-6 mb-10">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Father's Name</p>
                            <p class="font-bold text-slate-800"><?php echo $athlete['father_name']; ?></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Mother's Name</p>
                            <p class="font-bold text-slate-800"><?php echo $athlete['mother_name']; ?></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Mobile Number</p>
                            <p class="font-bold text-slate-800"><?php echo $athlete['mobile']; ?></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Email Address</p>
                            <p class="font-bold text-slate-800 lowercase"><?php echo $athlete['email']; ?></p>
                        </div>
                    </div>

                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4 border-b pb-2">Residential Address</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-10">
                        <?php echo $athlete['address_line']; ?>,<br>
                        <strong><?php echo $athlete['district']; ?>, <?php echo $athlete['state']; ?></strong>
                    </p>

                    <div class="bg-slate-900 p-6 rounded-sm flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-slate-500 uppercase">Razorpay Payment ID</p>
                            <p class="text-orange-500 font-mono text-xs"><?php echo $athlete['payment_id']; ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-500 uppercase">Fee Paid</p>
                            <p class="text-white font-black text-xl italic">₹<?php echo $athlete['fee_paid']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white shadow-xl mt-6 p-8 border-t-4 border-blue-600">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 border-b pb-2">
                Documents & Verification
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                <!-- PHOTO -->
                <?php if(!empty($athlete['photo'])): ?>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Photo</p>
                    <img src="../<?php echo $athlete['photo']; ?>" 
                        class="w-full h-40 object-cover border shadow">
                </div>
                <?php endif; ?>

                <!-- PAYMENT PROOF -->
                <?php if(!empty($athlete['payment_screenshot'])): ?>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Payment Proof</p>
                    <a href="../<?php echo $athlete['payment_screenshot']; ?>" target="_blank">
                        <img src="../<?php echo $athlete['payment_screenshot']; ?>" 
                            class="w-full h-40 object-cover border shadow hover:scale-105 transition">
                    </a>
                </div>
                <?php endif; ?>

                <!-- AADHAAR (IF EXISTS) -->
                <?php if(isset($athlete['aadhar_doc']) && !empty($athlete['aadhar_doc'])): ?>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-2">Aadhaar</p>

                    <?php if(pathinfo($athlete['aadhar_doc'], PATHINFO_EXTENSION) === 'pdf'): ?>
                        <a href="../<?php echo $athlete['aadhar_doc']; ?>" target="_blank"
                        class="block bg-slate-900 text-white text-center py-6 font-bold uppercase text-xs">
                            View PDF
                        </a>
                    <?php else: ?>
                        <a href="../<?php echo $athlete['aadhar_doc']; ?>" target="_blank">
                            <img src="../<?php echo $athlete['aadhar_doc']; ?>" 
                                class="w-full h-40 object-cover border shadow">
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
        
        <div class="mt-6 flex gap-4">
            <button onclick="window.print()" class="bg-white border border-slate-300 px-6 py-3 font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition flex-1">
                Print Dossier
            </button>
            <a href="mailto:<?php echo $athlete['email']; ?>" class="bg-blue-600 text-white px-6 py-3 font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition flex-1 text-center">
                Contact Athlete
            </a>
            <button class="bg-red-100 text-red-600 px-6 py-3 font-black text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition flex-1">
                Delete Record
            </button>
        </div>
    </div>

</body>
</html>