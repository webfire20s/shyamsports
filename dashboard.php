<?php
session_start();
include('includes/db_connect.php');

// 🔐 Security Check
if(!isset($_SESSION['athlete_uid'])) { 
    header("Location: registration.php"); 
    exit(); 
}

$uid = $_SESSION['athlete_uid'];

// Fetch athlete data
$query = "SELECT * FROM athletes WHERE uid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

include('includes/header.php');
?>

<section class="py-12 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4">

        <!-- 🔷 PROFILE HEADER -->
        <div class="bg-white shadow-2xl overflow-hidden border-t-8 border-[#001e5f]">
            <div class="p-8 flex flex-col md:flex-row items-center gap-8">

                <!-- Profile Image -->
                <div class="h-32 w-32 rounded-full border-4 border-orange-500 overflow-hidden flex items-center justify-center bg-gray-100 text-4xl font-black text-navy shadow-lg">
                    <?php if(!empty($user['photo'])): ?>
                        <img src="<?php echo $user['photo']; ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                    <?php endif; ?>
                </div>

                <!-- Basic Info -->
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-black text-blue-900 uppercase italic">
                        <?php echo $user['full_name']; ?>
                    </h2>

                    <p class="text-gray-500 font-bold uppercase tracking-widest text-xs mt-2">
                        <?php echo $user['sport'] ?: 'N/A'; ?> Athlete |
                        UID: <span class="text-orange-600"><?php echo $user['uid']; ?></span> |
                        Category: <?php echo $user['athlete_category'] ?: 'N/A'; ?>
                    </p>

                    <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">
                        Registered on: <?php echo date('d M Y', strtotime($user['registration_date'])); ?>
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="registration.php?success=1&id=<?php echo $user['id']; ?>" 
                       class="bg-orange-600 text-white px-5 py-2 text-xs font-bold uppercase hover:bg-[#001e5f] transition shadow-md text-center">
                        View ID Card
                    </a>

                    <a href="generate_receipt.php?uid=<?php echo $user['uid']; ?>" 
                       class="bg-[#001e5f] text-white px-5 py-2 text-xs font-bold uppercase hover:bg-orange-600 transition shadow-md text-center">
                        Receipt
                    </a>

                    <a href="logout.php" 
                       class="bg-red-600 text-white px-5 py-2 text-xs font-bold uppercase hover:bg-black transition shadow-md text-center">
                        Logout
                    </a>
                </div>

            </div>
        </div>

        <!-- 🔷 PROFILE DETAILS -->
        <div class="mt-8 bg-white shadow-xl p-8 border-t-4 border-[#001e5f]">

            <h3 class="text-2xl font-black text-blue-900 uppercase italic mb-8">
                Athlete Profile
            </h3>
            

            <!-- 🔹 PERSONAL DETAILS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm font-bold text-gray-700">

                <div>
                    <p class="text-gray-400 text-xs uppercase">Full Name</p>
                    <p><?php echo $user['full_name']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">UID</p>
                    <p><?php echo $user['uid']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Mobile</p>
                    <p><?php echo $user['mobile']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Email</p>
                    <p><?php echo $user['email'] ?? 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">DOB</p>
                    <p><?php echo date('d-m-Y', strtotime($user['dob'])); ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Gender</p>
                    <p><?php echo $user['gender']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Sport</p>
                    <p><?php echo $user['sport']; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Height / Weight</p>
                    <p><?php echo $user['height_cm'] ?: '-'; ?> cm / <?php echo $user['weight_kg'] ?: '-'; ?> kg</p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Blood Group</p>
                    <p><?php echo $user['blood_group'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Father Name</p>
                    <p><?php echo $user['father_name'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Mother Name</p>
                    <p><?php echo $user['mother_name'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Address</p>
                    <p><?php echo $user['address_line'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">District</p>
                    <p><?php echo $user['district'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">State</p>
                    <p><?php echo $user['state'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Pincode</p>
                    <p><?php echo $user['pincode'] ?: 'N/A'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Passport</p>
                    <p><?php echo $user['passport_number'] ?: 'Not Provided'; ?></p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs uppercase">Fee Paid</p>
                    <p>₹<?php echo $user['fee_paid']; ?></p>
                </div>

            </div>

            <!-- 🔹 DOCUMENT SECTION -->
            <div class="mt-10">
                <h4 class="text-lg font-black text-orange-600 uppercase mb-6">
                    Uploaded Documents
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- PHOTO -->
                    <div class="bg-slate-50 p-4 text-center border">
                        <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Photo</p>
                        <?php if(!empty($user['photo'])): ?>
                            <img src="<?php echo $user['photo']; ?>" class="w-32 h-32 object-cover mx-auto rounded shadow">
                        <?php else: ?>
                            <p class="text-red-500 text-xs">Not Uploaded</p>
                        <?php endif; ?>
                    </div>

                    <!-- AADHAAR -->
                    <div class="bg-slate-50 p-4 text-center border">
                        <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Aadhaar Document</p>
                        <?php if(!empty($user['aadhar_doc'])): ?>
                            <a href="<?php echo $user['aadhar_doc']; ?>" target="_blank"
                            class="text-blue-600 underline text-sm font-bold">
                                View Document
                            </a>
                        <?php else: ?>
                            <p class="text-red-500 text-xs">Not Uploaded</p>
                        <?php endif; ?>
                    </div>

                    <!-- PASSPORT -->
                    <div class="bg-slate-50 p-4 text-center border">
                        <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Passport</p>
                        <?php if(!empty($user['passport_doc'])): ?>
                            <a href="<?php echo $user['passport_doc']; ?>" target="_blank"
                            class="text-blue-600 underline text-sm font-bold">
                                View Document
                            </a>
                        <?php else: ?>
                            <p class="text-gray-400 text-xs">Not Provided</p>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>

        <!-- 🔷 QUICK ACTIONS -->
        <div class="grid grid-cols-1 md:grid-cols-3 mt-8 text-center">

            <a href="tournaments.php" class="p-8 bg-white shadow hover:bg-gray-50 transition">
                <h4 class="font-black text-blue-900 uppercase italic">Tournaments</h4>
                <p class="text-xs text-gray-400 mt-2">Apply & View Events</p>
            </a>

            <a href="registration.php?success=1&id=<?php echo $user['id']; ?>" class="p-8 bg-white shadow hover:bg-gray-50 transition">
                <h4 class="font-black text-blue-900 uppercase italic">ID Card</h4>
                <p class="text-xs text-gray-400 mt-2">Print / Download</p>
            </a>

            <div class="p-8 bg-white shadow hover:bg-gray-50 transition">
                <h4 class="font-black text-blue-900 uppercase italic">Schedule</h4>
                <p class="text-xs text-gray-400 mt-2">Coming Soon</p>
            </div>

        </div>
        
        <!-- 🔷 CERTIFICATES SECTION -->
        <div class="mt-8 bg-white shadow-xl p-6 border-t-4 border-green-600">

            <h3 class="text-xl font-black text-blue-900 uppercase italic mb-6">
                Your Certificates
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <?php
            $uid = $_SESSION['athlete_uid'];

            $res = mysqli_query($conn, "SELECT * FROM certificates WHERE uid='$uid'");

            if(mysqli_num_rows($res) > 0){
                while($cert = mysqli_fetch_assoc($res)){
            ?>

                <div class="p-4 border bg-slate-50 shadow-sm">
                    <p class="font-bold text-blue-900 uppercase">
                        <?php echo $cert['certificate_type']; ?>
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Event: <?php echo $cert['event_name']; ?>
                    </p>

                    <p class="text-xs text-gray-500">
                        Date: <?php echo date('d M Y', strtotime($cert['event_date'])); ?>
                    </p>

                    <a href="<?php echo $cert['file_path']; ?>" target="_blank"
                    class="inline-block mt-3 bg-orange-600 text-white px-4 py-2 text-xs font-bold uppercase hover:bg-[#001e5f] transition">
                        View / Download
                    </a>
                </div>

            <?php 
                }
            } else {
                echo "<p class='text-gray-400 text-sm'>No certificates available yet.</p>";
            }
            ?>

            </div>
        </div>

        <!-- 🔷 STATUS BAR -->
        <div class="mt-8 bg-[#001e5f] p-4 text-center">
            <p class="text-white font-black uppercase tracking-widest text-xs">
                Status: <span class="text-green-400">Active</span> |
                Payment: <span class="text-orange-400">₹<?php echo $user['fee_paid']; ?> Paid</span>
            </p>
        </div>

    </div>
</section>

<?php include('includes/footer.php'); ?>