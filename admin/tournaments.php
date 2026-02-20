<?php
include('../includes/db_connect.php');
session_start();

// Security Check
if(!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Handle New Event Submission
if(isset($_POST['add_tournament'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $disc = mysqli_real_escape_string($conn, $_POST['discipline']);
    $color = $_POST['color'];
    $date = $_POST['date'];
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    
    $conn->query("INSERT INTO tournaments (title, discipline, discipline_color, event_date, venue, status) 
                  VALUES ('$title', '$disc', '$color', '$date', '$venue', 'Upcoming')");
    header("Location: tournaments.php?msg=added");
}

// Handle Status Update
if(isset($_GET['complete'])) {
    $id = intval($_GET['complete']);
    $conn->query("UPDATE tournaments SET status = 'Completed' WHERE id = $id");
    header("Location: tournaments.php");
}

// Handle Deletion
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM tournaments WHERE id = $id");
    header("Location: tournaments.php");
}

$list = $conn->query("SELECT * FROM tournaments ORDER BY event_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager | FSA Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        .text-navy { color: #001e5f; }
        .bg-navy { background-color: #001e5f; }
    </style>
</head>
<body class="bg-slate-100 flex min-h-screen">

    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-8 md:p-12">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 animate__animated animate__fadeIn">
            <div>
                <span class="bg-orange-600 text-white px-3 py-1 text-[10px] font-black uppercase tracking-[0.3em] mb-3 inline-block">Event Logistics</span>
                <h2 class="text-5xl font-black text-navy uppercase italic font-oswald leading-none">
                    Tournament <span class="text-orange-500">Control</span>
                </h2>
            </div>
        </div>

        <div class="bg-white p-8 shadow-2xl border-t-8 border-navy mb-12 animate__animated animate__fadeInUp">
            <h4 class="font-oswald text-2xl font-black uppercase mb-6 italic text-navy">Schedule <span class="text-orange-600">New Event</span></h4>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Tournament Title</label>
                    <input type="text" name="title" placeholder="e.g. District Junior Open" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold" required>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Discipline</label>
                    <select name="discipline" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold">
                        <option>Badminton</option>
                        <option>Cricket</option>
                        <option>Athletics</option>
                    </select>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Theme Color</label>
                    <select name="color" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold">
                        <option value="blue">Blue (Badminton)</option>
                        <option value="green">Green (Cricket)</option>
                        <option value="orange">Orange (General)</option>
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Event Date</label>
                    <input type="date" name="date" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold" required>
                </div>
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Venue & Location</label>
                    <input type="text" name="venue" placeholder="e.g. Academy Indoor Hall, Zone 1" class="w-full p-4 bg-slate-50 border-b-2 border-slate-200 outline-none focus:border-orange-600 font-bold" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" name="add_tournament" class="w-full bg-navy text-white font-black py-5 uppercase text-[10px] tracking-widest hover:bg-orange-600 transition shadow-lg">
                        Post Event →
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-xl overflow-hidden border-b-4 border-navy animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy">Tournament</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy">Status</th>
                        <th class="p-6 text-[10px] font-black uppercase tracking-widest text-navy text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($list->num_rows > 0): ?>
                        <?php while($row = $list->fetch_assoc()): ?>
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                            <td class="p-6">
                                <span class="text-orange-600 font-black text-[9px] uppercase tracking-widest block mb-1">
                                    <?php echo $row['discipline']; ?> • <?php echo date('M d, Y', strtotime($row['event_date'])); ?>
                                </span>
                                <h4 class="font-black text-navy uppercase italic font-oswald text-xl"><?php echo $row['title']; ?></h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase"><?php echo $row['venue']; ?></p>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 text-[9px] font-black uppercase rounded-full <?php echo ($row['status'] == 'Upcoming') ? 'bg-green-100 text-green-600' : 'bg-slate-200 text-slate-500'; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <div class="flex justify-end gap-3">
                                    <?php if($row['status'] == 'Upcoming'): ?>
                                        <a href="tournaments.php?complete=<?php echo $row['id']; ?>" class="bg-navy text-white px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-orange-600 transition">Complete</a>
                                    <?php endif; ?>
                                    <a href="tournaments.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Remove this event?')" class="bg-red-50 text-red-600 px-4 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-20 text-center font-oswald text-2xl text-slate-300 uppercase italic">No tournaments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>
</body>
</html>