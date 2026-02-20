<?php
include('includes/sidebar.php');
include('../includes/db_connect.php');
session_start();

// Basic Security Check
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); }

// Fetch Stats
$total_athletes = $conn->query("SELECT count(*) as total FROM athletes")->fetch_assoc()['total'];
$total_revenue = $conn->query("SELECT sum(fee_paid) as total FROM athletes")->fetch_assoc()['total'];
$recent_regs = $conn->query("SELECT * FROM athletes ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FSA | Admin Command Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex">

    

    <div class="flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-black text-slate-800 uppercase italic">Command <span class="text-orange-600">Center</span></h2>
            <div class="flex items-center gap-4">
                <span class="text-xs font-bold text-slate-400 italic">SYSTEM STATUS: ONLINE</span>
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 border-b-4 border-orange-500 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Total Enrolments</p>
                <h3 class="text-4xl font-black text-slate-800"><?php echo $total_athletes; ?></h3>
            </div>
            <div class="bg-white p-6 border-b-4 border-blue-900 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Revenue Collected</p>
                <h3 class="text-4xl font-black text-slate-800">₹<?php echo number_format($total_revenue); ?></h3>
            </div>
            <div class="bg-white p-6 border-b-4 border-slate-900 shadow-sm">
                <p class="text-xs font-bold text-slate-400 uppercase">Active Disciplines</p>
                <h3 class="text-4xl font-black text-slate-800">72</h3>
            </div>
        </div>

        <div class="bg-white shadow-xl">
            <div class="p-6 border-b flex justify-between items-center">
                <h4 class="font-black uppercase italic text-slate-700">Recent Athlete Onboarding</h4>
                <a href="athletes.php" class="text-xs font-bold text-orange-600 hover:underline">VIEW ALL ATHLETES →</a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400">
                    <tr>
                        <th class="p-4">UID</th>
                        <th class="p-4">Athlete Name</th>
                        <th class="p-4">Sport</th>
                        <th class="p-4">Payment ID</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php while($row = $recent_regs->fetch_assoc()): ?>
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="p-4 font-black text-blue-900"><?php echo $row['uid']; ?></td>
                        <td class="p-4 font-bold text-slate-700"><?php echo $row['full_name']; ?></td>
                        <td class="p-4"><span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-[10px] font-bold uppercase"><?php echo $row['sport']; ?></span></td>
                        <td class="p-4 text-xs font-mono"><?php echo $row['payment_id']; ?></td>
                        <td class="p-4 text-right">
                            <a href="view_athlete.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase">Edit Profile</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>