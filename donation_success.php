<?php 
include('includes/header.php'); 

// ✅ CHECK REQUIRED DATA
if(!isset($_GET['txn']) || !isset($_GET['amount']) || !isset($_GET['name'])) {
    header("Location: donate.php");
    exit();
}

$txn = $_GET['txn'];
$amount = $_GET['amount'];
$donor_name = $_GET['name'];
$date = date('Y-m-d H:i:s');
?>

<section class="py-20 bg-slate-50 text-center">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto bg-white p-12 shadow-2xl border-t-8 border-green-500 animate__animated animate__zoomIn">
            <div class="text-6xl mb-6">🙏</div>
            <h1 class="text-4xl font-black text-slate-900 uppercase italic mb-4">Thank You!</h1>
            <p class="text-gray-600 mb-8 font-medium italic">
                Your generous contribution of <span class="text-orange-600 font-black">INR <?php echo number_format($amount, 2); ?></span> has been received. 
                You are now a part of Firozabad's sporting revolution.
            </p>
            
            <div class="bg-gray-100 p-6 rounded text-left mb-8 border-l-4 border-slate-900">
                <div class="flex justify-between mb-2 text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Donor:</span>
                    <span class="text-slate-900 font-black uppercase"><?php echo htmlspecialchars($donor_name); ?></span>
                </div>
                <div class="flex justify-between mb-2 text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Transaction ID:</span>
                    <span class="text-slate-900 font-black"><?php echo $txn; ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Date:</span>
                    <span class="text-slate-900 font-black"><?php echo date('d M, Y'); ?></span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <button onclick="window.print()" class="flex-1 bg-slate-900 text-white py-4 font-black uppercase tracking-widest text-xs hover:bg-orange-600 transition">
                    Print Acknowledgment
                </button>
                <a href="index.php" class="flex-1 border-2 border-slate-900 text-slate-900 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 hover:text-white transition text-center">
                    Return Home
                </a>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>