<?php include('includes/db_connect.php'); ?>
<?php include('includes/header.php'); ?>

<div class="bg-blue-950 text-white py-3 border-y border-white/10 relative z-50">
    <div class="container mx-auto px-4 flex items-center">
        <div class="bg-orange-600 px-3 py-1 text-[10px] font-black uppercase tracking-tighter mr-4 animate-pulse shrink-0">Live Updates</div>
        <div class="overflow-hidden relative flex-1">
            <div class="whitespace-nowrap animate-marquee font-bold text-sm tracking-wide uppercase italic">
                National Selection Trials for Athletics begins on April 20th <span class="mx-10 text-orange-500">•</span> 
                Now Offering 72 Disciplines from Grassroots to Elite level <span class="mx-10 text-orange-500">•</span> 
                Registration for the 2026 Season is now open!
            </div>
        </div>
    </div>
</div>

<section class="grid grid-cols-1 md:grid-cols-12 h-[700px] bg-black overflow-hidden border-b border-white/10">
    <div class="md:col-span-7 relative group border-r border-white/10">
        <img src="assets/images/hero1.jpg" class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-105 transition duration-[3s] ease-out">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/40"></div>
        <div class="relative h-full flex flex-col justify-end p-10 lg:p-20 animate__animated animate__fadeIn">
            <span class="text-orange-500 font-black tracking-[0.5em] text-xs mb-4 uppercase">Elite Athlete Development</span>
            <h2 class="text-6xl lg:text-8xl font-black text-white leading-none uppercase italic tracking-tighter">
                Raising the <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Gold Standard</span>
            </h2>
            <div class="mt-8 flex gap-4">
                <a href="registration.php" class="bg-white text-black px-10 py-5 font-black uppercase text-sm hover:bg-orange-600 hover:text-white transition-all duration-500">Apply Now</a>
                <a href="disciplines.php" class="border border-white/30 text-white px-10 py-5 font-black uppercase text-sm hover:bg-white hover:text-black transition-all">72 Disciplines</a>
            </div>
        </div>
    </div>

    <div class="md:col-span-5 grid grid-rows-2">
        <div class="relative group border-b border-white/10 overflow-hidden">
            <img src="assets/images/cricket.jpg" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-110 transition duration-700">
            <div class="relative h-full flex items-center p-12 bg-navy/20">
                <h3 class="text-white font-black text-4xl uppercase italic tracking-tighter">Track & Field<br><span class="text-xs font-normal text-gray-400 not-italic tracking-[0.3em]">AFI National Pathway</span></h3>
            </div>
        </div>
        <div class="relative group overflow-hidden">
            <img src="assets/images/badminton.jpg" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-110 transition duration-700">
            <div class="relative h-full flex items-center p-12 bg-navy/20">
                <h3 class="text-white font-black text-4xl uppercase italic tracking-tighter">Combat Sports<br><span class="text-xs font-normal text-gray-400 not-italic tracking-[0.3em]">Wrestling & Martial Arts</span></h3>
            </div>
        </div>
    </div>
</section>

<section class="relative -mt-12 z-40 px-4">
    <div class="container mx-auto">
        <div class="bg-white/95 backdrop-blur-xl shadow-2xl p-8 grid grid-cols-2 md:grid-cols-4 gap-4 border-b-8 border-orange-600">
            <div class="text-center border-r border-gray-100 last:border-0">
                <span class="text-5xl font-black text-blue-950 block italic">72</span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Active Disciplines</span>
            </div>
            <div class="text-center border-r border-gray-100 last:border-0">
                <span class="text-5xl font-black text-blue-950 block italic">U4-S</span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Age Categories</span>
            </div>
            <div class="text-center border-r border-gray-100 last:border-0">
                <span class="text-5xl font-black text-blue-950 block italic">85</span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">National Medals</span>
            </div>
            <div class="text-center">
                <span class="text-5xl font-black text-blue-950 block italic">20+</span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Expert Coaches</span>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4 mb-16 flex flex-col md:flex-row justify-between items-end gap-6">
        <div>
            <h2 class="text-5xl font-black text-blue-950 uppercase italic tracking-tighter">The <span class="text-orange-600">Master Roster</span></h2>
            <p class="text-gray-500 font-bold uppercase tracking-widest text-xs mt-2">72 Specialized Programs under one roof</p>
        </div>
        <a href="disciplines.php" class="bg-blue-950 text-white px-8 py-4 font-black text-[10px] uppercase tracking-widest hover:bg-orange-600 transition">Explore All Disciplines</a>
    </div>

    <div class="bg-blue-950 py-12 -mx-4 overflow-hidden border-y-4 border-orange-600">
        <div class="flex whitespace-nowrap animate-ticker gap-12 items-center">
            <?php 
            $sports_ticker = ["Athletics", "Kabbadi", "Mallakhamb", "Gatka", "Silambam", "Wrestling", "Shooting", "Modern Pentathlon", "Archery", "Boxing", "Yogasana"];
            foreach(array_merge($sports_ticker, $sports_ticker) as $s): ?>
                <span class="text-white text-4xl font-black italic uppercase tracking-tighter opacity-20"><?php echo $s; ?></span>
                <div class="w-3 h-3 bg-orange-600 rotate-45"></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-50 relative">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black text-blue-950 uppercase italic tracking-tighter">Scientific <span class="text-orange-600">Pathway</span></h2>
            <p class="text-gray-500 font-bold uppercase tracking-widest text-xs mt-2">Long-Term Athlete Development (LTAD) Model</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 shadow-xl border-t-8 border-green-500 group hover:-translate-y-2 transition-all">
                <span class="text-6xl font-black text-slate-100 group-hover:text-green-50 absolute right-4 top-4 transition-colors">01</span>
                <h4 class="font-black text-blue-950 uppercase text-xl mb-4 italic">Discovery Phase</h4>
                <p class="text-[10px] font-black text-green-600 uppercase mb-4 tracking-widest">Ages Under-4 — Under-10</p>
                <ul class="text-sm text-gray-500 space-y-2 font-medium">
                    <li>• Animal Movement Play & Balance</li>
                    <li>• Basic Coordination Fun Relays</li>
                    <li>• Soft Equipment & Mini Javelin</li>
                </ul>
            </div>

            <div class="bg-white p-10 shadow-xl border-t-8 border-blue-500 group hover:-translate-y-2 transition-all">
                <span class="text-6xl font-black text-slate-100 group-hover:text-blue-50 absolute right-4 top-4 transition-colors">02</span>
                <h4 class="font-black text-blue-950 uppercase text-xl mb-4 italic">Pre-Professional</h4>
                <p class="text-[10px] font-black text-blue-600 uppercase mb-4 tracking-widest">Ages Under-12 — Under-16</p>
                <ul class="text-sm text-gray-500 space-y-2 font-medium">
                    <li>• NIDJAM National Trial Prep</li>
                    <li>• High Jump (Scissor Kick) Technique</li>
                    <li>• 4kg Shot Put / Pentathlon Training</li>
                </ul>
            </div>

            <div class="bg-white p-10 shadow-xl border-t-8 border-orange-600 group hover:-translate-y-2 transition-all">
                <span class="text-6xl font-black text-slate-100 group-hover:text-orange-50 absolute right-4 top-4 transition-colors">03</span>
                <h4 class="font-black text-blue-950 uppercase text-xl mb-4 italic">Olympic Standard</h4>
                <p class="text-[10px] font-black text-orange-600 uppercase mb-4 tracking-widest">Ages Under-18 — Senior</p>
                <ul class="text-sm text-gray-500 space-y-2 font-medium">
                    <li>• 7.26kg Shot Put / 800g Javelin</li>
                    <li>• 3000m Steeplechase & Endurance</li>
                    <li>• Decathlon / Heptathlon Specialization</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-blue-950 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-orange-600/5 skew-x-12 transform translate-x-20"></div>
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-20">
        <div class="animate__animated animate__fadeInLeft">
            <h2 class="text-4xl font-black border-b-4 border-orange-500 inline-block mb-12 uppercase italic tracking-tighter">Bulletin Board</h2>
            <div class="space-y-6">
                <?php for($i=0; $i<3; $i++): ?>
                <div class="flex gap-6 border-b border-white/5 pb-6 group cursor-pointer">
                    <div class="bg-white/10 p-3 text-center h-16 w-16 flex-shrink-0 group-hover:bg-orange-600 transition duration-500">
                        <span class="block text-xl font-black leading-none mt-1">15</span>
                        <span class="text-[9px] uppercase font-black opacity-60">Mar '26</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg group-hover:text-orange-400 transition">Updated Trial List for All 72 Sports Disciplines</h4>
                        <p class="text-xs text-gray-500 mt-2 uppercase tracking-widest">Category: Admissions</p>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="relative animate__animated animate__fadeInRight">
            <div class="bg-white/5 p-4 rounded shadow-2xl backdrop-blur-sm border border-white/10">
                <video class="w-full rounded" controls poster="assets/images/video-thumb.jpg">
                    <source src="assets/video/academy-tour.mp4" type="video/mp4">
                </video>
                <div class="pt-6 px-4">
                    <h4 class="text-2xl font-black uppercase italic italic">Life At Academy</h4>
                    <p class="text-gray-400 text-sm mt-2">A glimpse into our high-performance training routine.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-24 bg-white border-y">
    <div class="container mx-auto px-4 text-center mb-16">
        <h2 class="text-5xl font-black text-blue-950 uppercase italic tracking-tighter">
            Athlete <span class="text-orange-600">Documents</span>
        </h2>
        <p class="text-gray-400 uppercase tracking-widest text-xs mt-2">
            Download official forms & guidelines
        </p>
    </div>

    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        $docs = $conn->query("SELECT * FROM athlete_docs ORDER BY id DESC LIMIT 6");

        if($docs && $docs->num_rows > 0):
            while($doc = $docs->fetch_assoc()):
        ?>
            <div class="p-6 bg-slate-50 border hover:shadow-xl transition">
                <h3 class="font-black text-blue-950 uppercase text-lg mb-3">
                    <?php echo htmlspecialchars($doc['title']); ?>
                </h3>

                <div class="flex gap-3 mt-4">
                    
                    <!-- PREVIEW -->
                    <a href="<?php echo $doc['file_path']; ?>" target="_blank"
                       class="flex-1 text-center border border-blue-950 text-blue-950 py-3 text-xs font-black uppercase hover:bg-blue-950 hover:text-white transition">
                        Preview
                    </a>

                    <!-- DOWNLOAD -->
                    <a href="<?php echo $doc['file_path']; ?>" download
                       class="flex-1 text-center bg-orange-600 text-white py-3 text-xs font-black uppercase hover:bg-blue-950 transition">
                        Download
                    </a>

                </div>
            </div>
        <?php 
            endwhile;
        else:
        ?>
            <p class="col-span-3 text-center text-gray-400 uppercase font-bold">
                No documents available yet.
            </p>
        <?php endif; ?>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4 text-center mb-16">
        <h2 class="text-5xl font-black text-blue-950 uppercase tracking-tighter italic inline-block relative">
            Academy In News
            <span class="absolute -bottom-2 left-0 w-full h-2 bg-orange-600/20"></span>
        </h2>
    </div>

    <div class="container mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php
        include('includes/db_connect.php');

        $query = "SELECT * FROM academy_news ORDER BY created_at DESC LIMIT 4";
        $result = mysqli_query($conn, $query);

        if($result && mysqli_num_rows($result) > 0):
            while($row = mysqli_fetch_assoc($result)):
        ?>
            <div class="group relative aspect-[3/4] overflow-hidden bg-black cursor-pointer shadow-xl">
                <img src="<?php echo $row['image']; ?>" 
     class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-1000">

                <div class="absolute inset-0 bg-gradient-to-t from-orange-600/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-6">
                    <span class="text-white text-[10px] font-black uppercase tracking-widest mb-1">
                        <?php echo htmlspecialchars($row['category']); ?>
                    </span>
                    <p class="text-white font-bold text-sm leading-tight uppercase">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </p>
                </div>
            </div>
        <?php 
            endwhile;
        else:
            // 🔒 FALLBACK (so design never breaks)
            for($j=1; $j<=4; $j++):
        ?>
            <div class="group relative aspect-[3/4] overflow-hidden bg-black cursor-pointer shadow-xl">
                <img src="assets/images/news<?php echo $j; ?>.jpg" 
                     class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-1000">
            </div>
        <?php endfor; endif; ?>
    </div>
</section><section class="py-24 bg-slate-50">
    <div class="container mx-auto px-4 text-center mb-16">
        <span class="text-orange-600 font-black uppercase tracking-[0.3em] text-[10px] mb-2 block">Wall of Fame</span>
        <h2 class="text-5xl font-black text-blue-950 uppercase tracking-tighter italic inline-block relative font-oswald">
            Daily <span class="text-slate-400">Champions</span>
            <span class="absolute -bottom-2 left-0 w-full h-2 bg-orange-600/20"></span>
        </h2>
    </div>

    <div class="container mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php 
        $winners = $conn->query("SELECT * FROM winners ORDER BY id DESC LIMIT 4");
        if($winners->num_rows > 0):
            while($win = $winners->fetch_assoc()):
        ?>
        <div class="group relative aspect-[3/4] overflow-hidden bg-black cursor-pointer shadow-xl">
            <img src="<?php echo $win['image_path']; ?>" 
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
            
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-6">
                <span class="text-orange-500 text-[10px] font-black uppercase tracking-widest mb-1">
                    <?php echo htmlspecialchars($win['event_name']); ?>
                </span>
                <p class="text-white font-black text-lg leading-tight uppercase italic">
                    <?php echo htmlspecialchars($win['winner_name']); ?>
                </p>
                <div class="w-8 h-1 bg-orange-600 mt-2 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
            </div>
        </div>
        <?php 
            endwhile; 
        else:
            // Fallback if no winners are uploaded yet
            echo "<p class='col-span-4 text-center text-slate-400 font-bold uppercase italic tracking-widest'>Champions of the day will appear here.</p>";
        endif; 
        ?>
    </div>
</section>

<section class="bg-orange-600 py-16">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center text-white text-center md:text-left">
        <div class="mb-8 md:mb-0">
            <h2 class="text-4xl lg:text-5xl font-black uppercase italic tracking-tighter">Your Journey Starts Here</h2>
            <p class="text-white/80 font-bold uppercase tracking-widest text-sm mt-2">Enrollments open for 72+ sports disciplines</p>
        </div>
        <a href="registration.php" class="bg-blue-950 text-white px-16 py-6 font-black text-xl hover:bg-black transition-all shadow-2xl animate__animated animate__pulse animate__infinite">REGISTER NOW</a>
    </div>
</section>

<style>
@keyframes ticker {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-ticker {
   
    animation: ticker 12s linear infinite;
}
@keyframes marquee {    
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-marquee {
    display: inline-block;
    animation: marquee 30s linear infinite;
}
.animate-marquee:hover {
    animation-play-state: paused;
}
</style>

<?php include('includes/footer.php'); ?>