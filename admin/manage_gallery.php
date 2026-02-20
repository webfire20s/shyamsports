    <?php
include('../includes/db_connect.php');
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// 1. Handle Photo Upload
if(isset($_POST['upload_photo'])) {
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    $target_dir = "../assets/images/gallery/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
    $file_name = "fsa_" . time() . "." . $file_ext;
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO gallery (caption, category, image_path) VALUES ('$caption', '$category', '$file_name')");
        header("Location: manage_gallery.php?success=1");
    }
}

// 2. Handle Deletion
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT image_path FROM gallery WHERE id = $id");
    if($row = $res->fetch_assoc()) {
        unlink("../assets/images/gallery/" . $row['image_path']);
        $conn->query("DELETE FROM gallery WHERE id = $id");
    }
    header("Location: manage_gallery.php");
}

$photos = $conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery Manager | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100 flex min-h-screen">
    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-12">
        <h2 class="text-5xl font-black text-[#001e5f] uppercase italic font-oswald mb-12">Action <span class="text-orange-600">Vault Manager</span></h2>

        <div class="bg-white p-8 shadow-2xl border-t-8 border-[#001e5f] mb-12">
            <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2">Category</label>
                    <select name="category" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold">
                        <option>Cricket</option>
                        <option>Badminton</option>
                        <option>Ceremonies</option>
                        <option>Training</option>
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2">Caption</label>
                    <input type="text" name="caption" placeholder="Moment Name" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2">Select Image</label>
                    <input type="file" name="photo" class="w-full p-3 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                </div>
                <button type="submit" name="upload_photo" class="bg-[#001e5f] text-white font-black py-5 uppercase text-[10px] tracking-widest hover:bg-orange-600 transition">Add to Vault</button>
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php while($p = $photos->fetch_assoc()): ?>
            <div class="relative group bg-white p-2 shadow-md">
                <img src="../assets/images/gallery/<?php echo $p['image_path']; ?>" class="w-full h-32 object-cover">
                <div class="absolute inset-0 bg-navy/90 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <a href="manage_gallery.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Delete photo?')" class="bg-red-600 text-white p-2 text-[10px] font-black uppercase">Delete</a>
                </div>
                <p class="text-[8px] font-bold uppercase mt-2 truncate"><?php echo $p['caption']; ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
</html> 