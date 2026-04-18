<?php
session_start();
// Security check
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

include('../includes/db_connect.php');
include('includes/sidebar.php');

/* ================================
    🔴 HANDLE APPROVE
================================ */
if(isset($_GET['approve'])){
    $id = intval($_GET['approve']);
    $res = mysqli_query($conn, "SELECT * FROM athletes WHERE id = $id");
    $user = mysqli_fetch_assoc($res);

    if($user){
        $uid = "SDSDT-" . str_pad($id, 5, '0', STR_PAD_LEFT);
        $password = password_hash($user['mobile'], PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE athletes 
            SET uid='$uid', password='$password', payment_status='approved' 
            WHERE id=$id");

        header("Location: admin_approvals.php?success=approved");
        exit();
    }
}

/* ================================
    🔴 HANDLE REJECT
================================ */
if(isset($_GET['reject'])){
    $id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE athletes 
        SET payment_status='rejected' 
        WHERE id=$id");

    header("Location: admin_approvals.php?success=rejected");
    exit();
}

/* ================================
    🔴 FETCH PENDING USERS
================================ */
$result = mysqli_query($conn, "SELECT * FROM athletes WHERE payment_status='pending' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Approvals | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex min-h-screen">

    <div class="flex-1 p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 uppercase italic">Payment <span class="text-orange-600">Approvals</span></h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Verify transactions and generate athlete UIDs</p>
            </div>
            
            <div class="flex gap-2">
                <span class="bg-slate-800 text-white px-6 py-2 text-[10px] font-black uppercase tracking-widest">
                    Pending: <?php echo mysqli_num_rows($result); ?>
                </span>
            </div>
        </div>

        <?php if(isset($_GET['success'])): ?>
            <div class="bg-emerald-500 text-white p-4 mb-6 text-xs font-black uppercase tracking-widest shadow-lg animate-bounce">
                <i class="fas fa-check-circle mr-2"></i> Action Completed Successfully
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-xl overflow-x-auto border-t-4 border-orange-600">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-900 text-[10px] uppercase font-black text-slate-400">
                    <tr>
                        <th class="p-5">Athlete Info</th>
                        <th class="p-5">Sport & Category</th>
                        <th class="p-5 text-center">Payment Proof</th>
                        <th class="p-5">Amount</th>
                        <th class="p-5 text-right">Verification</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php if($result && mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b hover:bg-orange-50/50 transition group">
                            <td class="p-5">
                                <div class="font-bold text-slate-800 uppercase italic"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Mob: <?php echo $row['mobile']; ?></div>
                                <div class="text-[9px] bg-slate-100 px-2 py-0.5 rounded font-bold uppercase text-slate-400 inline-block mt-1">
                                    ID: #<?php echo $row['id']; ?>
                                </div>
                            </td>

                            <td class="p-5">
                                <span class="block font-black text-orange-600 uppercase text-xs"><?php echo $row['sport']; ?></span>
                                <span class="text-[10px] text-slate-500 font-bold uppercase"><?php echo $row['athlete_category']; ?></span>
                            </td>

                            <td class="p-5 text-center">
                                <a href="<?php echo $row['payment_screenshot']; ?>" target="_blank" class="inline-block relative group">
                                    <img src="<?php echo $row['payment_screenshot']; ?>" 
                                         class="w-20 h-12 object-cover border-2 border-slate-200 group-hover:border-orange-500 transition shadow-sm">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                                        <i class="fas fa-search-plus text-white text-xs"></i>
                                    </div>
                                </a>
                            </td>

                            <td class="p-5">
                                <div class="font-black text-slate-800 tracking-tighter text-lg">₹<?php echo $row['fee_paid']; ?></div>
                                <div class="text-[9px] text-emerald-600 font-black uppercase">Pending Review</div>
                            </td>

                            <td class="p-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="?approve=<?php echo $row['id']; ?>" 
                                       onclick="return confirm('APPROVE & GENERATE UID?')"
                                       class="bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 font-black text-[10px] uppercase tracking-widest transition-all shadow-md">
                                        Approve
                                    </a>
                                    <a href="?reject=<?php echo $row['id']; ?>" 
                                       onclick="return confirm('REJECT PAYMENT?')"
                                       class="bg-slate-200 text-slate-600 hover:bg-red-600 hover:text-white px-4 py-2 font-black text-[10px] uppercase tracking-widest transition-all">
                                        Reject
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center font-bold text-slate-400 uppercase italic">
                                <i class="fas fa-check-double mb-4 text-3xl block text-emerald-500"></i>
                                No pending approvals. Everything is verified.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>