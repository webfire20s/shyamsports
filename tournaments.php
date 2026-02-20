<?php 
include('includes/db_connect.php');
include('includes/header.php'); 

// Fetch Active (Upcoming) Events
$upcoming = $conn->query("SELECT * FROM tournaments WHERE status = 'Upcoming' ORDER BY event_date ASC");

// Fetch Completed Events for the Archive
$archives = $conn->query("SELECT * FROM tournaments WHERE status = 'Completed' ORDER BY event_date DESC LIMIT 3");
?>

<section class="relative h-80 bg-navy flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-[url('assets/images/stadium-mesh.png')] opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-navy/90 to-transparent z-10"></div>
    
    <div class="container mx-auto px-4 relative z-20 animate__animated animate__fadeIn">
        <div class="flex items-center gap-4 mb-4">
            <span class="w-12 h-[2px] bg-orange-500"></span>
            <span class="text-orange-500 font-black uppercase tracking-[0.4em] text-[10px]">2026 Competitive Season</span>
        </div>
        <h1 class="text-6xl font-black text-white italic uppercase tracking-tighter font-oswald leading-none">
            Tournament <span class="text-orange-500">Arena</span>
        </h1>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs mt-4">Official Selection Trials & National Championships</p>
    </div>
</section>

<section class="bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
            <div class="border-l-8 border-navy pl-6">
                <h2 class="text-3xl font-black text-navy uppercase italic font-oswald">Active <span class="text-orange-600">Schedules</span></h2>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-1">Real-time update of upcoming fixtures</p>
            </div>
        </div>

        <div class="bg-white shadow-[0_20px_50px_rgba(0,30,95,0.1)] overflow-hidden border-t-4 border-navy">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-navy uppercase text-[11px] font-black tracking-widest border-b">
                            <th class="p-6">Event Details</th>
                            <th class="p-6">Discipline</th>
                            <th class="p-6">Venue & Location</th>
                            <th class="p-6">Date & Time</th>
                            <th class="p-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 font-bold text-sm">
                        <?php while($row = $upcoming->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-slate-50 transition group">
                            <td class="p-6">
                                <span class="block text-navy font-black text-lg group-hover:text-orange-600 transition"><?php echo $row['title']; ?></span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-tighter">ID: <?php echo $row['event_id']; ?></span>
                            </td>
                            <td class="p-6">
                                <span class="inline-flex items-center gap-2 bg-<?php echo $row['discipline_color']; ?>-50 text-<?php echo $row['discipline_color']; ?>-700 px-4 py-1.5 rounded-full text-[10px] uppercase font-black border border-<?php echo $row['discipline_color']; ?>-100">
                                    <span class="w-2 h-2 bg-<?php echo $row['discipline_color']; ?>-600 rounded-full animate-pulse"></span> <?php echo $row['discipline']; ?>
                                </span>
                            </td>
                            <td class="p-6">
                                <span class="block"><?php echo $row['venue']; ?></span>
                                <span class="text-xs text-gray-400 font-medium"><?php echo $row['sub_venue']; ?></span>
                            </td>
                            <td class="p-6 text-navy"><?php echo date('F d, Y', strtotime($row['event_date'])); ?> <br> <span class="text-xs text-gray-400 font-medium"><?php echo date('h:i A', strtotime($row['event_time'])); ?> IST</span></td>
                            <td class="p-6 text-center">
                                <a href="<?php echo $row['registration_url']; ?>" class="inline-block bg-orange-600 text-white px-8 py-3 text-[10px] font-black tracking-widest hover:bg-navy transition-all shadow-lg hover:shadow-orange-200 uppercase">Apply Now</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<section class="py-24 bg-navy relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-white uppercase italic font-oswald">The Road to <span class="text-orange-500">Glory</span></h2>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.4em] mt-2">Our 4-Step Professional Selection Protocol</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <?php 
            $steps = [
                ['01', 'UID Auth', 'FSA registered UID is mandatory for all entries.'],
                ['02', 'Portal Entry', 'Digital submission of performance credentials.'],
                ['03', 'Physical Trial', 'Elite on-ground assessment by high-performance coaches.'],
                ['04', 'Drafting', 'Official list release in the News Gallery.']
            ];
            foreach($steps as $s): ?>
            <div class="group bg-white/5 border border-white/10 p-10 hover:bg-orange-600 transition-all duration-500">
                <span class="block text-6xl font-black text-white/10 group-hover:text-white/20 font-oswald transition-colors"><?php echo $s[0]; ?></span>
                <h4 class="text-xl font-black text-white uppercase italic font-oswald mt-4"><?php echo $s[1]; ?></h4>
                <div class="w-8 h-1 bg-orange-600 group-hover:bg-white my-4 transition-all"></div>
                <p class="text-gray-400 group-hover:text-white/90 text-sm leading-relaxed"><?php echo $s[2]; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-6 mb-16">
            <h2 class="text-4xl font-black text-navy uppercase italic font-oswald leading-none">Championship <br><span class="text-orange-600 text-5xl">Archive</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php while($arc = $archives->fetch_assoc()): ?>
            <div class="relative group h-[450px] bg-black overflow-hidden shadow-2xl">
                <img src="assets/images/<?php echo $arc['archive_image']; ?>" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-110 transition duration-700 grayscale group-hover:grayscale-0">
                <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/40 to-transparent"></div>
                <div class="relative p-10 h-full flex flex-col justify-end">
                    <span class="bg-orange-600 text-white px-3 py-1 text-[10px] font-black uppercase tracking-widest self-start mb-4"><?php echo date('M Y', strtotime($arc['event_date'])); ?></span>
                    <h4 class="text-white font-black text-3xl uppercase italic font-oswald leading-tight"><?php echo $arc['title']; ?></h4>
                    <p class="text-gray-300 text-xs mt-4 font-medium italic border-l-2 border-orange-500 pl-4">"<?php echo $arc['archive_desc']; ?>"</p>
                    <a href="gallery.php" class="mt-8 text-white text-[10px] font-black uppercase tracking-widest hover:text-orange-500 flex items-center gap-2">View Highlight Reel <span>→</span></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="py-16 bg-slate-50 border-y">
    <div class="container mx-auto px-4">
        <div class="bg-white p-12 shadow-2xl flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-orange-600"></div>
            <div>
                <span class="text-orange-600 font-black uppercase text-[10px] tracking-[0.3em]">Official Rulebook</span>
                <h3 class="text-3xl font-black text-navy uppercase font-oswald mt-2 leading-tight">Competition Guidelines <span class="text-slate-300">2026</span></h3>
                <p class="text-gray-500 text-sm mt-2 max-w-xl">Download the mandatory anti-doping manual, age-verification protocol, and the 2026 Athlete Code of Conduct.</p>
            </div>
            <div class="shrink-0">
                <a href="assets/docs/rulebook.pdf" class="flex items-center gap-6 bg-navy text-white pl-8 pr-2 py-2 group hover:bg-orange-600 transition-all duration-500">
                    <span class="font-black uppercase text-xs tracking-widest">Download PDF Package</span>
                    <span class="bg-white/10 p-4 group-hover:bg-white/20 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Custom Oswald for Headlines */
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap');
.font-oswald { font-family: 'Oswald', sans-serif; }
</style>

<?php include('includes/footer.php'); ?>