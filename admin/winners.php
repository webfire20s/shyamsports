<?php
include('../includes/db_connect.php');
session_start();

// Security Check
if(!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Handle Deletion
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Optional: Add code here to unlink/delete the actual image file from folder
    $conn->query("DELETE FROM winners WHERE id = $id");
    header("Location: winners.php?msg=deleted");
}

// Handle Upload
if(isset($_POST['upload_winner'])) {
    $name = mysqli_real_escape_string($conn, $_POST['winner_name']);
    $event = mysqli_real_escape_string($conn, $_POST['event_name']);
    
    $target_dir = "../assets/images/winners/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["winner_img"]["name"]);
    $target_file = $target_dir . $file_name;
    $db_path = "assets/images/winners/" . $file_name;

    if (move_uploaded_file($_FILES["winner_img"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO winners (winner_name, event_name, image_path) VALUES ('$name', '$event', '$db_path')");
        header("Location: winners.php?msg=success");
    }
}

$winners = $conn->query("SELECT * FROM winners ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Champions Gallery | FSA Admin</title>
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
                <span class="bg-orange-600 text-white px-3 py-1 text-[10px] font-black uppercase tracking-[0.3em] mb-3 inline-block">Wall of Fame</span>
                <h2 class="text-5xl font-black text-navy uppercase italic font-oswald leading-none">
                    Daily <span class="text-orange-500">Champions</span>
                </h2>
            </div>
            
            <div class="bg-white px-6 py-4 shadow-lg border-b-4 border-navy">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Records</span>
                <span class="text-2xl font-black text-navy"><?php echo $winners->num_rows; ?></span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <div class="bg-white shadow-xl border-t-4 border-orange-600 p-8 sticky top-8">
                    <h3 class="font-oswald text-2xl font-black text-navy uppercase italic mb-6">New Entry</h3>
                    <form method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Winner's Full Name</label>
                            <input type="text" name="winner_name" required class="w-full border-2 border-slate-100 p-3 text-sm font-bold focus:border-navy outline-none transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Event / Category</label>
                            <input type="text" name="event_name" placeholder="e.g. Under-19 Cricket" required class="w-full border-2 border-slate-100 p-3 text-sm font-bold focus:border-navy outline-none transition">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Action Shot (Photo)</label>
                            <input type="file" name="winner_img" required class="w-full text-xs font-bold text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-navy file:text-white cursor-pointer">
                        </div>
                        <button type="submit" name="upload_winner" class="w-full bg-navy text-white text-[10px] font-black uppercase py-4 tracking-[0.2em] hover:bg-orange-600 transition shadow-lg">
                            Publish to Homepage
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-4">
                <?php if($winners->num_rows > 0): ?>
                    <?php while($row = $winners->fetch_assoc()): ?>
                    <div class="bg-white shadow-xl overflow-hidden group hover:translate-x-1 transition-all">
                        <div class="flex items-center">
                            <div class="w-32 h-32 bg-slate-200 overflow-hidden shrink-0">
                                <img src="../<?php echo $row['image_path']; ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                            </div>
                            <div class="flex-1 p-6 border-r border-slate-50">
                                <span class="text-[9px] font-black text-orange-500 uppercase tracking-widest mb-1 block"><?php echo $row['event_name']; ?></span>
                                <h4 class="text-navy font-black uppercase italic font-oswald text-xl leading-tight"><?php echo $row['winner_name']; ?></h4>
                                <p class="text-[9px] font-bold text-slate-300 uppercase mt-2"><?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                            </div>
                            <div class="p-6">
                                <a href="winners.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Remove this champion from the Wall of Fame?')" class="bg-slate-50 text-slate-400 hover:text-red-600 p-4 transition text-[10px] font-black uppercase tracking-widest">
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="bg-white p-20 text-center shadow-xl border-b-8 border-slate-200">
                        <h3 class="font-oswald text-2xl font-black text-slate-400 uppercase italic">No Champions Listed</h3>
                        <p class="text-slate-400 text-xs uppercase font-bold tracking-widest mt-2">Upload the first winner to activate the homepage section.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>
</body>
</html>