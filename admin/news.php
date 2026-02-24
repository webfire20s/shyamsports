<?php
include('../includes/db_connect.php');
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// 1. Handle Bulk News Clipping Upload
if(isset($_POST['upload_news'])) {
    $source = mysqli_real_escape_string($conn, $_POST['source']);
    $date = $_POST['date'];
    
    $target_dir = "../assets/images/news/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    if(!empty($_FILES['news_imgs']['name'][0])) {
        foreach($_FILES['news_imgs']['tmp_name'] as $key => $tmp_name) {
            $original_name = $_FILES['news_imgs']['name'][$key];
            $file_ext = pathinfo($original_name, PATHINFO_EXTENSION);
            
            // Unique filename using timestamp and index
            $file_name = "news_" . time() . "_" . $key . "." . $file_ext;
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Simplified INSERT: No title, No description
                $conn->query("INSERT INTO news (news_source, news_date, image_path) 
                              VALUES ('$source', '$date', '$file_name')");
            }
        }
        header("Location: news.php?msg=success");
        exit();
    }
}

// 2. Handle Delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT image_path FROM news WHERE id = $id");
    if($row = $res->fetch_assoc()) {
        $file_path = "../assets/images/news/" . $row['image_path'];
        if(file_exists($file_path)) {
            unlink($file_path);
        }
        $conn->query("DELETE FROM news WHERE id = $id");
    }
    header("Location: news.php");
    exit();
}

$all_news = $conn->query("SELECT * FROM news ORDER BY news_date DESC, id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News Manager | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        .text-navy { color: #001e5f; }
        .bg-navy { background-color: #001e5f; }
    </style>
</head>
<body class="bg-slate-100 flex min-h-screen">
    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-12">
        <h2 class="text-5xl font-black text-navy uppercase italic font-oswald mb-12">
            Press <span class="text-orange-600">Archive</span>
        </h2>

        <div class="bg-white p-10 shadow-2xl mb-16 border-t-8 border-navy">
            <h4 class="font-oswald text-xl font-black uppercase mb-6 italic text-navy">Bulk <span class="text-orange-600">Clipping Upload</span></h4>
            <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Publication Source</label>
                    <input type="text" name="source" placeholder="e.g. Amar Ujala" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold" required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Publish Date</label>
                    <input type="date" name="date" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold" required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Select Multiple Clippings</label>
                    <input type="file" name="news_imgs[]" multiple class="w-full p-3 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                </div>
                <button type="submit" name="upload_news" class="bg-navy text-white font-black py-5 uppercase text-[10px] tracking-widest hover:bg-orange-600 transition shadow-lg">
                    Upload to Archive →
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if($all_news->num_rows > 0): ?>
                <?php while($n = $all_news->fetch_assoc()): ?>
                <div class="bg-white p-3 shadow-lg group relative overflow-hidden">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-100">
                        <img src="../assets/images/news/<?php echo $n['image_path']; ?>" 
                             class="w-full h-full object-cover object-top grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    
                    <div class="mt-4 flex justify-between items-start">
                        <div>
                            <span class="text-[9px] font-black text-orange-600 uppercase tracking-widest block">
                                <?php echo $n['news_source']; ?>
                            </span>
                            <span class="text-[10px] text-slate-400 font-bold italic">
                                <?php echo date('M d, Y', strtotime($n['news_date'])); ?>
                            </span>
                        </div>
                        <a href="news.php?delete=<?php echo $n['id']; ?>" 
                           onclick="return confirm('Remove this clipping from archive?')" 
                           class="bg-red-50 text-red-600 p-2 hover:bg-red-600 hover:text-white transition rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center bg-white border-2 border-dashed border-slate-200">
                    <p class="font-oswald text-2xl text-slate-300 uppercase italic">No clippings archived</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>