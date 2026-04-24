<?php
// session_start() MUST be at the very top before any output or includes
session_start();
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

include('../includes/db_connect.php');
// Sidebar is usually included after logic so it doesn't interfere with headers
include('includes/sidebar.php');

// Handle Search and Filters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sport_filter = isset($_GET['sport']) ? mysqli_real_escape_string($conn, $_GET['sport']) : '';

// Base Query
// Base Query (ONLY APPROVED USERS)
$query = "SELECT * FROM athletes WHERE payment_status = 'approved'";

if(!empty($search)) {
    $query .= " AND (full_name LIKE '%$search%' OR uid LIKE '%$search%' OR mobile LIKE '%$search%')";
}

if(!empty($sport_filter)) {
    $query .= " AND sport = '$sport_filter'";
}

$query .= " ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Athletes | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex min-h-screen">

    <div class="flex-1 p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-800 uppercase italic">Athlete <span class="text-orange-600">Roster</span></h2>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Database of all registered elite talent</p>
            </div>
            
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-slate-800 text-white px-6 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 transition">
                    <i class="fas fa-print mr-2"></i> Print Report
                </button>
            </div>
        </div>

        <div class="bg-white p-6 shadow-sm border-b-2 border-slate-200 mb-8">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by Name, UID, or Mobile..." 
                    class="flex-1 min-w-[250px] border border-slate-200 p-3 text-sm font-bold focus:outline-none focus:border-orange-500">
                
                <select name="sport" class="border border-slate-200 p-3 text-sm font-bold focus:outline-none focus:border-orange-500">
                    <option value="">All Disciplines</option>
                    <option value="Athletics" <?php if($sport_filter == 'Athletics') echo 'selected'; ?>>Athletics</option>
                    <option value="Cricket" <?php if($sport_filter == 'Cricket') echo 'selected'; ?>>Cricket</option>
                    <option value="Football" <?php if($sport_filter == 'Football') echo 'selected'; ?>>Football</option>
                    <option value="Kabaddi" <?php if($sport_filter == 'Kabaddi') echo 'selected'; ?>>Kabaddi</option>
                </select>

                <button type="submit" class="bg-orange-600 text-white px-8 py-3 font-black uppercase text-xs tracking-widest hover:bg-orange-700 transition">Filter</button>
                <a href="athletes.php" class="bg-slate-200 text-slate-600 px-6 py-3 font-black uppercase text-xs tracking-widest hover:bg-slate-300 flex items-center">Reset</a>
            </form>
        </div>

        <div class="bg-white shadow-xl overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-900 text-[10px] uppercase font-black text-slate-400">
                    <tr>
                        <th class="p-5">UID / Details</th>
                        <th class="p-5">Athlete Name</th>
                        <th class="p-5">Category & Sport</th>
                        <th class="p-5">Contact Info</th>
                        <th class="p-5">Location</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php if($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-orange-50/50 transition group">
                            <td class="p-5">
                                <div class="font-black text-blue-900 tracking-tighter mb-1"><?php echo $row['uid']; ?></div>
                                <span class="text-[9px] bg-slate-100 px-2 py-0.5 rounded font-bold uppercase text-slate-400">Aadhaar: <?php echo substr($row['aadhaar_no'], -4); ?> (Last 4)</span>
                            </td>
                            <td class="p-5">
                                <div class="font-bold text-slate-800 uppercase italic"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase">S/O: <?php echo htmlspecialchars($row['father_name']); ?></div>
                            </td>
                            <td class="p-5">
                                <span class="block font-black text-orange-600 uppercase text-xs"><?php echo $row['sport']; ?></span>
                                <span class="text-[10px] text-slate-500 font-bold uppercase"><?php echo $row['athlete_category']; ?></span>
                            </td>
                            <td class="p-5">
                                <div class="text-xs font-bold text-slate-700"><?php echo $row['mobile']; ?></div>
                                <div class="text-[10px] text-slate-400 lowercase italic"><?php echo htmlspecialchars($row['email']); ?></div>
                            </td>
                            <td class="p-5">
                                <div class="text-[10px] font-bold text-slate-600 uppercase"><?php echo $row['district']; ?>, <?php echo $row['state']; ?></div>
                            </td>
                            <td class="p-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="view_athlete.php?id=<?php echo $row['id']; ?>" 
                                       class="bg-slate-100 text-slate-600 hover:bg-slate-900 hover:text-white px-4 py-2 rounded font-black text-[10px] uppercase transition-all">
                                        View
                                    </a>
                                    </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-20 text-center font-bold text-slate-400 uppercase italic">
                                <i class="fas fa-search mb-4 text-3xl block"></i>
                                No athletes found matching your criteria.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>