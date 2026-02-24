<?php
include('../includes/db_connect.php');
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// 1. Handle Bulk Photo Upload
if(isset($_POST['upload_photo'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    $target_dir = "../assets/images/gallery/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    // Loop through multiple files
    if(!empty($_FILES['photos']['name'][0])) {
        foreach($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
            $original_name = $_FILES['photos']['name'][$key];
            $file_ext = pathinfo($original_name, PATHINFO_EXTENSION);
            
            // Unique filename to prevent overwriting
            $file_name = "fsa_" . time() . "_" . $key . "." . $file_ext;
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Insert into simplified table (no caption)
                $conn->query("INSERT INTO gallery (category, image_path) VALUES ('$category', '$file_name')");
            }
        }
        header("Location: manage_gallery.php?success=1");
        exit();
    }
}

// 2. Handle Deletion
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT image_path FROM gallery WHERE id = $id");
    if($row = $res->fetch_assoc()) {
        $file_to_delete = "../assets/images/gallery/" . $row['image_path'];
        if(file_exists($file_to_delete)) {
            unlink($file_to_delete);
        }
        $conn->query("DELETE FROM gallery WHERE id = $id");
    }
    header("Location: manage_gallery.php");
    exit();
}

$photos = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk Gallery Manager | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        .bg-navy { background-color: #001e5f; }
        .text-navy { color: #001e5f; }
    </style>
</head>
<body class="bg-slate-100 flex min-h-screen">
    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-12">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-5xl font-black text-navy uppercase italic font-oswald">
                Action <span class="text-orange-600">Vault Manager</span>
            </h2>
            <?php if(isset($_GET['success'])): ?>
                <span class="bg-green-100 text-green-700 px-4 py-2 text-[10px] font-black uppercase tracking-widest animate-pulse">Upload Successful</span>
            <?php endif; ?>
        </div>

        <div class="bg-white p-8 shadow-2xl border-t-8 border-navy mb-12">
            <h4 class="font-oswald text-xl font-black uppercase mb-6 italic text-navy">Bulk <span class="text-orange-600">Upload</span></h4>
            <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Category / Sport</label>
                    <select name="category" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold">
                        <option>Cricket</option>
                        <option>Badminton</option>
                        <option>Ceremonies</option>
                        <option>Training</option>
                        <option>General</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Select Multiple Photos</label>
                    <input type="file" name="photos[]" multiple class="w-full p-3 bg-slate-50 border-b-2 border-slate-200 outline-none font-bold" required>
                </div>
                <button type="submit" name="upload_photo" class="bg-navy text-white font-black py-5 uppercase text-[10px] tracking-widest hover:bg-orange-600 transition shadow-lg">
                    Add Multiple to Vault →
                </button>
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php if($photos->num_rows > 0): ?>
                <?php while($p = $photos->fetch_assoc()): ?>
                <div class="relative group bg-white p-2 shadow-md hover:shadow-xl transition">
                    <img src="../assets/images/gallery/<?php echo $p['image_path']; ?>" class="w-full h-40 object-cover">
                    
                    <div class="absolute inset-0 bg-navy/90 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center p-4 text-center">
                        <span class="text-orange-500 font-black text-[8px] uppercase tracking-widest mb-4"><?php echo $p['category']; ?></span>
                        <a href="manage_gallery.php?delete=<?php echo $p['id']; ?>" 
                           onclick="return confirm('Permanently remove this photo?')" 
                           class="bg-red-600 text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-white hover:text-red-600 transition">
                            Delete
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center bg-white border-2 border-dashed border-slate-200">
                    <p class="font-oswald text-2xl text-slate-300 uppercase italic">Vault is empty</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>