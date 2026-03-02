<?php
session_start();
include('includes/db_connect.php');

// Security: Kick out users who aren't logged in
if(!isset($_SESSION['athlete_uid'])) { 
    header("Location: registration.php"); 
    exit(); 
}

$uid = $_SESSION['athlete_uid'];

// Fetch the full profile from DB to get the ID and Photo
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
        <div class="bg-white shadow-2xl rounded-sm overflow-hidden border-t-8 border-[#001e5f]">
            <div class="p-8 flex flex-col md:flex-row items-center gap-8">
                <div class="h-32 w-32 bg-gray-200 rounded-full border-4 border-orange-500 overflow-hidden flex items-center justify-center text-4xl font-black text-navy shadow-lg">
                    <?php if(!empty($user['photo'])): ?>
                        <img src="<?php echo $user['photo']; ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php echo substr($user['full_name'], 0, 1); ?>
                    <?php endif; ?>
                </div>
                
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-black text-blue-900 uppercase italic"><?php echo $user['full_name']; ?></h2>
                    <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">
                        <?php echo $user['sport']; ?> Athlete | 
                        <span class="text-orange-600">UID: <?php echo $user['uid']; ?></span> |
                        Category: <?php echo $user['athlete_category']; ?>
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="generate_receipt.php?uid=<?php echo $user['uid']; ?>" class="bg-[#001e5f] text-white px-6 py-3 font-bold text-xs uppercase hover:bg-orange-600 transition text-center shadow-md">Download Receipt</a>
                    <a href="logout.php" class="bg-red-600 text-white px-6 py-3 font-bold text-xs uppercase hover:bg-black transition text-center shadow-md">Logout</a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 border-t bg-gray-50 text-center">
                <a href="tournaments.php" class="p-10 border-r hover:bg-white transition group border-b md:border-b-0">
                    <div class="mb-3 text-orange-600 flex justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="font-black text-blue-900 group-hover:text-orange-600 uppercase italic">Apply for Tournaments</h4>
                    <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">View upcoming trials and championships</p>
                </a>

                <a href="registration.php?success=1&id=<?php echo $user['id']; ?>" class="p-10 border-r hover:bg-white transition group border-b md:border-b-0">
                    <div class="mb-3 text-orange-600 flex justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="font-black text-blue-900 group-hover:text-orange-600 uppercase italic">View Identity Card</h4>
                    <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">Print Official Academy Athlete UID Card</p>
                </a>

                <div class="p-10 hover:bg-white transition group">
                    <div class="mb-3 text-orange-600 flex justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-black text-blue-900 uppercase italic">Training Schedule</h4>
                    <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">Access your coaching time-table</p>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-[#001e5f] p-4 text-center">
            <p class="text-white font-black uppercase italic tracking-[0.3em] text-[10px]">
                Registration Status: <span class="text-green-400">Verified & Active</span> | 
                Next Event: <span class="text-orange-500">Physical Verification (March 15)</span>
            </p>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>