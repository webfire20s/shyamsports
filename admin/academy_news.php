<?php
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

include('../includes/db_connect.php');
include('includes/sidebar.php');

$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $img = $_FILES['image'];
    $path = "";

    if($img['error'] == 0){
        $dir = "../uploads/news/";

        if(!is_dir($dir)) mkdir($dir,0777,true);

        $name = time() . "_" . basename($img['name']);
        $target = $dir . $name;

        if(move_uploaded_file($img['tmp_name'], $target)){
            $path = "uploads/news/" . $name; 
        }
    }

    $stmt = $conn->prepare("INSERT INTO academy_news (title, image, category, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $path, $category);
    
    if($stmt->execute()){
        $message = "News Bulletin Published Successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post News | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex min-h-screen">

    <div class="flex-1 p-10">
        <div class="mb-10">
            <h2 class="text-3xl font-black text-slate-800 uppercase italic">Publish <span class="text-orange-600">News</span></h2>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Broadcast updates to the academy dashboard</p>
        </div>

        <?php if($message): ?>
            <div class="bg-emerald-500 text-white p-4 mb-8 text-xs font-black uppercase tracking-widest shadow-lg">
                <i class="fas fa-bullhorn mr-2"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="max-w-2xl bg-white shadow-xl border-t-4 border-slate-900">
            <div class="p-8">
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">News Title / Headline</label>
                        <input type="text" name="title" required placeholder="E.G. ANNUAL SPORTS MEET 2026"
                            class="w-full border-2 border-slate-100 p-4 text-sm font-bold focus:outline-none focus:border-orange-500 transition-colors uppercase">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Category / Tag</label>
                        <input type="text" name="category" placeholder="E.G. TOURNAMENT, ANNOUNCEMENT, ETC."
                            class="w-full border-2 border-slate-100 p-4 text-sm font-bold focus:outline-none focus:border-orange-500 transition-colors uppercase">
                    </div>

                    <div class="bg-slate-50 p-6 border-2 border-dashed border-slate-200">
                        <label class="block text-[10px] font-black uppercase text-slate-500 mb-4 tracking-widest text-center text-xs">Featured Image</label>
                        <input type="file" name="image" required 
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-orange-600 transition cursor-pointer">
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full bg-orange-600 text-white py-4 font-black uppercase text-xs tracking-widest hover:bg-slate-900 transition-all shadow-lg">
                            <i class="fas fa-plus-circle mr-2"></i> Publish Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 text-slate-400 text-[10px] font-bold uppercase tracking-tighter">
            <i class="fas fa-info-circle mr-1 text-orange-500"></i> Tip: Use short, punchy category names like "CRICKET" or "ALERTS".
        </div>
    </div>

</body>
</html>