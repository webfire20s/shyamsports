<?php
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

include('../includes/db_connect.php');
include('includes/sidebar.php');

$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = $_POST['title'];
    $file = $_FILES['file'];
    $path = "";

    if($file['error'] == 0){

        // ✅ Only allow PDF
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if($ext !== 'pdf'){
            die("<div class='bg-red-600 text-white p-4 font-black uppercase text-xs'>Only PDF files allowed</div>");
        }

        // ✅ Upload to ROOT uploads (not admin folder)
        $dir = "../uploads/docs/";
        if(!is_dir($dir)) mkdir($dir,0777,true);

        $name = "doc_" . time() . "_" . rand(1000,9999) . ".pdf";
        $target = $dir . $name;

        if(move_uploaded_file($file['tmp_name'], $target)){
            $path = "uploads/docs/" . $name; // 🔥 important
        }
    }

    $stmt = $conn->prepare("INSERT INTO athlete_docs (title, file_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $path);
    
    if($stmt->execute()){
        $message = "PDF Uploaded Successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Docs | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex min-h-screen">

    <div class="flex-1 p-10">
        <div class="mb-10">
            <h2 class="text-3xl font-black text-slate-800 uppercase italic">Document <span class="text-orange-600">Vault</span></h2>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Upload official athlete PDF resources</p>
        </div>

        <?php if($message): ?>
            <div class="bg-emerald-500 text-white p-4 mb-8 text-xs font-black uppercase tracking-widest shadow-lg border-l-8 border-emerald-700">
                <i class="fas fa-file-pdf mr-2"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="max-w-2xl bg-white shadow-xl border-t-4 border-slate-900">
            <div class="p-8">
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 tracking-widest">Document Title</label>
                        <input type="text" name="title" required placeholder="E.G. SELECTION CRITERIA 2026"
                            class="w-full border-2 border-slate-100 p-4 text-sm font-bold focus:outline-none focus:border-orange-500 transition-colors uppercase">
                    </div>

                    <div class="bg-slate-50 p-8 border-2 border-dashed border-slate-200 text-center">
                        <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 mb-4"></i>
                        <label class="block text-[10px] font-black uppercase text-slate-500 mb-4 tracking-widest">Select PDF File</label>
                        <input type="file" name="file" required accept=".pdf"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-orange-600 transition cursor-pointer">
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full bg-orange-600 text-white py-4 font-black uppercase text-xs tracking-widest hover:bg-slate-900 transition-all shadow-lg">
                            Upload Document
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-8 text-slate-400 text-[10px] font-bold uppercase tracking-tighter">
            <i class="fas fa-shield-alt mr-1 text-orange-500"></i> Server Path: <span class="text-slate-600">../uploads/docs/</span>
        </div>
    </div>

</body>
</html>