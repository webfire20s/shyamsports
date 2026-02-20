<?php
include('../includes/db_connect.php');
session_start();

// Security Check
if(!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Handle Status Update (Mark as Read)
if(isset($_GET['read'])) {
    $id = intval($_GET['read']);
    $conn->query("UPDATE contact_inquiries SET status = 'Read' WHERE id = $id");
    header("Location: inquiries.php");
}

// Handle Deletion
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM contact_inquiries WHERE id = $id");
    header("Location: inquiries.php?msg=deleted");
}

$inquiries = $conn->query("SELECT * FROM contact_inquiries ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        .text-navy { color: #001e5f; }
        .bg-navy { background-color: #001e5f; }
    </style>
</head>
<body class="bg-slate-100 flex min-h-screen">

    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-8 md:p-12">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div class="animate__animated animate__fadeInDown">
                <span class="bg-orange-600 text-white px-3 py-1 text-[10px] font-black uppercase tracking-[0.3em] mb-3 inline-block">Communication Hub</span>
                <h2 class="text-5xl font-black text-navy uppercase italic font-oswald leading-none">
                    Direct <span class="text-orange-500">Inquiries</span>
                </h2>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-white px-6 py-4 shadow-lg border-b-4 border-navy">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Messages</span>
                    <span class="text-2xl font-black text-navy"><?php echo $inquiries->num_rows; ?></span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <?php if($inquiries->num_rows > 0): ?>
                <?php while($row = $inquiries->fetch_assoc()): ?>
                <div class="bg-white shadow-xl overflow-hidden group border-r-4 <?php echo ($row['status'] == 'New') ? 'border-orange-600' : 'border-transparent'; ?> transition-all hover:translate-x-1">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        
                        <div class="lg:col-span-3 p-8 bg-slate-50 border-r border-slate-100">
                            <span class="inline-block px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-tighter mb-4 <?php echo ($row['status'] == 'New') ? 'bg-orange-100 text-orange-600' : 'bg-slate-200 text-slate-500'; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                            <h4 class="text-navy font-black uppercase italic font-oswald text-xl leading-tight mb-2">
                                <?php echo htmlspecialchars($row['full_name']); ?>
                            </h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase truncate mb-4"><?php echo htmlspecialchars($row['email']); ?></p>
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">
                                <?php echo date('d M Y | H:i', strtotime($row['created_at'])); ?>
                            </p>
                        </div>

                        <div class="lg:col-span-7 p-8">
                            <span class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] block mb-2">
                                Subject: <?php echo htmlspecialchars($row['subject']); ?>
                            </span>
                            <div class="text-slate-600 leading-relaxed font-medium italic">
                                "<?php echo nl2br(htmlspecialchars($row['message'])); ?>"
                            </div>
                        </div>

                        <div class="lg:col-span-2 p-8 flex flex-col justify-center gap-3 bg-slate-50/50">
                            <?php if($row['status'] == 'New'): ?>
                            <a href="inquiries.php?read=<?php echo $row['id']; ?>" class="w-full text-center bg-navy text-white text-[10px] font-black uppercase py-3 tracking-widest hover:bg-orange-600 transition">
                                Mark Read
                            </a>
                            <?php endif; ?>
                            
                            <a href="mailto:<?php echo $row['email']; ?>" class="w-full text-center border-2 border-navy text-navy text-[10px] font-black uppercase py-3 tracking-widest hover:bg-navy hover:text-white transition">
                                Reply
                            </a>
                            
                            <a href="inquiries.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Archive this inquiry forever?')" class="w-full text-center text-red-400 hover:text-red-600 text-[9px] font-black uppercase tracking-widest mt-2">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bg-white p-20 text-center shadow-xl border-t-8 border-slate-200">
                    <div class="text-slate-300 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="font-oswald text-2xl font-black text-slate-400 uppercase italic">Inbox is Empty</h3>
                    <p class="text-slate-400 text-xs uppercase font-bold tracking-widest mt-2">No new messages from the field.</p>
                </div>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>