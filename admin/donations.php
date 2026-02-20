<?php
include('../includes/db_connect.php');
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// Calculate Total Donations
$total_res = $conn->query("SELECT SUM(amount) as total FROM donations WHERE transaction_status = 'Completed'");
$total_row = $total_res->fetch_assoc();
$grand_total = $total_row['total'] ?? 0;

$donations = $conn->query("SELECT * FROM donations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donations | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        .text-navy { color: #001e5f; }
        .bg-navy { background-color: #001e5f; }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-8 md:p-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12">
            <div>
                <span class="text-orange-600 font-black uppercase tracking-[0.4em] text-[10px] mb-2 block">Financial Legacy</span>
                <h1 class="text-5xl font-black text-navy uppercase italic tracking-tighter font-oswald leading-none">
                    Donation <span class="text-slate-300">Tracker</span>
                </h1>
            </div>
            <div class="mt-6 md:mt-0 bg-navy p-6 text-white border-l-8 border-orange-600 shadow-xl">
                <span class="block text-[10px] font-black uppercase tracking-widest opacity-60">Total Impact Fund</span>
                <span class="text-3xl font-black font-oswald">₹<?php echo number_format($grand_total, 2); ?></span>
            </div>
        </div>

        <div class="bg-white shadow-2xl overflow-hidden border-b-4 border-navy">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy">Donor Details</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy">Date</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy">Amount</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $donations->fetch_assoc()): ?>
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                        <td class="p-6">
                            <span class="block font-black text-navy uppercase italic font-oswald text-lg"><?php echo $row['donor_name']; ?></span>
                            <span class="text-[10px] font-bold text-slate-400"><?php echo $row['donor_email']; ?></span>
                        </td>
                        <td class="p-6 text-xs font-bold text-slate-500 uppercase">
                            <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                        </td>
                        <td class="p-6">
                            <span class="text-xl font-black text-orange-600">₹<?php echo number_format($row['amount'], 2); ?></span>
                        </td>
                        <td class="p-6">
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-[9px] font-black uppercase rounded-full">
                                <?php echo $row['transaction_status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>