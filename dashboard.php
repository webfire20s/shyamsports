
<?php
session_start();
if(!isset($_SESSION['athlete_uid'])) { header("Location: registration.php"); exit(); }
include('includes/header.php');
?>

<section class="py-12 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="bg-white shadow-2xl rounded-sm overflow-hidden border-t-8 border-navy">
            <div class="p-8 flex flex-col md:flex-row items-center gap-8">
                <div class="h-32 w-32 bg-gray-200 rounded-full border-4 border-orange-500 flex items-center justify-center text-4xl font-black text-navy">
                    <?php echo substr($_SESSION['athlete_name'], 0, 1); ?>
                </div>
                
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-black text-blue-900 uppercase italic"><?php echo $_SESSION['athlete_name']; ?></h2>
                    <p class="text-gray-500 font-bold uppercase tracking-widest text-sm"><?php echo $_SESSION['athlete_sport']; ?> Athlete | UID: <?php echo $_SESSION['athlete_uid']; ?></p>
                </div>

                <div class="flex gap-4">
                    <a href="generate_receipt.php?uid=<?php echo $_SESSION['athlete_uid']; ?>" class="bg-navy text-white px-6 py-3 font-bold text-xs uppercase hover:bg-orange-600 transition">Download Receipt</a>
                    <a href="logout.php" class="bg-red-600 text-white px-6 py-3 font-bold text-xs uppercase hover:bg-black transition">Logout</a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 border-t bg-gray-50 text-center">
                <a href="tournaments.php" class="p-10 border-r hover:bg-white transition group">
                    <h4 class="font-black text-blue-900 group-hover:text-orange-600 uppercase">Apply for Tournaments</h4>
                    <p class="text-xs text-gray-400 mt-2">View upcoming trials and championships</p>
                </a>
                <div class="p-10 border-r opacity-50 cursor-not-allowed">
                    <h4 class="font-black text-blue-900 uppercase">Digital ID Card</h4>
                    <p class="text-xs text-gray-400 mt-2">Coming Soon: Official Academy ID</p>
                </div>
                <div class="p-10">
                    <h4 class="font-black text-blue-900 uppercase">Training Schedule</h4>
                    <p class="text-xs text-gray-400 mt-2">Access your coaching time-table</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>