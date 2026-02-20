<?php 
session_start();
include('includes/header.php'); 

$pay_id = $_GET['pay_id'] ?? 'N/A';
$amount = $_SESSION['donation_amount'] ?? '0';
?>

<section class="py-20 bg-slate-50 text-center">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto bg-white p-12 shadow-2xl border-t-8 border-green-500 animate__animated animate__zoomIn">
            <div class="text-6xl mb-6">🙏</div>
            <h1 class="text-4xl font-black text-blue-900 uppercase italic mb-4">Thank You!</h1>
            <p class="text-gray-600 mb-8 font-medium">Your generous contribution of <span class="text-navy font-black">INR <?php echo number_format($amount, 2); ?></span> has been received. You are now a part of Firozabad's sporting revolution.</p>
            
            <div class="bg-gray-100 p-6 rounded text-left mb-8">
                <div class="flex justify-between mb-2 text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Transaction ID:</span>
                    <span class="text-navy font-black"><?php echo $pay_id; ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400 font-bold uppercase tracking-widest">Date:</span>
                    <span class="text-navy font-black"><?php echo date('d M, Y'); ?></span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <button onclick="window.print()" class="flex-1 bg-navy text-white py-3 font-bold uppercase hover:bg-black transition">Print Acknowledgment</button>
                <a href="index.php" class="flex-1 bg-orange-600 text-white py-3 font-bold uppercase hover:bg-navy transition">Return Home</a>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>