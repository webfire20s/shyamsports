<?php
include('../includes/db_connect.php');
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// 1. Handle Upload
if(isset($_POST['upload_news'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);
    $date = $_POST['date'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // File Upload Logic
    $target_dir = "../assets/images/news/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["news_img"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["news_img"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO news (title, news_source, news_date, description, image_path) 
                      VALUES ('$title', '$source', '$date', '$desc', '$file_name')");
        header("Location: news.php?msg=success");
    }
}

// 2. Handle Delete
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT image_path FROM news WHERE id = $id");
    $row = $res->fetch_assoc();
    unlink("../assets/images/news/" . $row['image_path']); // Delete physical file
    $conn->query("DELETE FROM news WHERE id = $id");
    header("Location: news.php");
}

$all_news = $conn->query("SELECT * FROM news ORDER BY news_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News Manager | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100 flex min-h-screen">
    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-12">
        <h2 class="text-5xl font-black text-[#001e5f] uppercase italic font-oswald mb-12">Press <span class="text-orange-600">Archive</span></h2>

        <div class="bg-white p-10 shadow-2xl mb-16 border-t-8 border-[#001e5f]">
            <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <input type="text" name="title" placeholder="Headline" class="p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold col-span-2" required>
                <input type="text" name="source" placeholder="Source (e.g. Amar Ujala)" class="p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                <input type="date" name="date" class="p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                <input type="file" name="news_img" class="p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                <textarea name="description" placeholder="Short Summary" class="p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold col-span-3 h-24"></textarea>
                <button type="submit" name="upload_news" class="bg-[#001e5f] text-white font-black py-4 uppercase tracking-widest hover:bg-orange-600 transition col-span-3">Publish Clipping</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php while($n = $all_news->fetch_assoc()): ?>
            <div class="bg-white p-4 flex gap-6 items-center shadow-lg group">
                <img src="../assets/images/news/<?php echo $n['image_path']; ?>" class="w-24 h-24 object-cover grayscale group-hover:grayscale-0 transition">
                <div class="flex-1">
                    <span class="text-[9px] font-black text-orange-600 uppercase tracking-widest"><?php echo $n['news_source']; ?></span>
                    <h4 class="font-black text-navy uppercase italic text-sm line-clamp-1"><?php echo $n['title']; ?></h4>
                    <a href="news.php?delete=<?php echo $n['id']; ?>" onclick="return confirm('Delete news clipping?')" class="text-[10px] text-red-600 font-bold uppercase mt-2 inline-block">Remove Clipping</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html>