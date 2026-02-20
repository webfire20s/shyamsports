<?php
session_start();
include('../includes/db_connect.php');

// Redirect if already logged in
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_with_str($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_user'] = $user['username'];
            
            // Update last login
            $conn->query("UPDATE admin_users SET last_login = NOW() WHERE id = " . $user['id']);
            
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials. Authentication failed.";
        }
    } else {
        $error = "Admin account not found.";
    }
}

// Helper function for security
function mysqli_real_escape_with_str($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | FSA 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-1 bg-orange-600"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-600/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>

    <div class="w-full max-w-md p-4 animate__animated animate__fadeInUp">
        <div class="bg-slate-900 border border-white/10 p-8 shadow-2xl relative">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black italic text-white uppercase tracking-tighter">
                    FSA<span class="text-orange-500">ADMIN</span>
                </h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.4em] mt-2">Command Center Access</p>
            </div>

            <?php if($error): ?>
                <div class="bg-red-500/10 border-l-4 border-red-500 p-4 mb-6 animate__animated animate__shakeX">
                    <p class="text-red-500 text-xs font-bold uppercase"><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">Username</label>
                    <input type="text" name="username" required 
                        class="w-full bg-slate-800 border border-white/5 p-4 text-white font-bold focus:outline-none focus:border-orange-500 transition-all"
                        placeholder="ADMIN ID">
                </div>

                <div>
                    <label class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">Password</label>
                    <input type="password" name="password" required 
                        class="w-full bg-slate-800 border border-white/5 p-4 text-white font-bold focus:outline-none focus:border-orange-500 transition-all"
                        placeholder="••••••••">
                </div>

                <button type="submit" 
                    class="w-full bg-orange-600 hover:bg-orange-500 text-white font-black py-4 uppercase tracking-[0.2em] transition-all shadow-lg shadow-orange-600/20 active:scale-[0.98]">
                    Authorize Access
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/5 text-center">
                <a href="../index.php" class="text-gray-600 hover:text-orange-500 text-[10px] font-black uppercase transition tracking-widest">
                    ← Back to Main Site
                </a>
            </div>
        </div>
        
        <p class="text-center mt-6 text-gray-700 text-[9px] font-black uppercase tracking-widest">
            Firozabad Sports Academy Security System v2.0
        </p>
    </div>

</body>
</html>