<?php include('includes/header.php'); ?>

<section class="relative h-[400px] bg-navy flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-blue-900/80 to-transparent z-10"></div>
    <img src="assets/images/about-banner.jpg" class="absolute inset-0 w-full h-full object-cover opacity-30 scale-110 animate-slow-zoom">
    
    <div class="container mx-auto px-4 relative z-20 animate__animated animate__fadeInLeft">
        <span class="bg-orange-600 text-white px-4 py-1 text-[10px] font-black uppercase tracking-[0.3em]">Our Legacy</span>
        <h1 class="text-6xl md:text-7xl font-black text-white italic uppercase tracking-tighter mt-4 leading-none font-oswald">
            The <span class="text-orange-500">Academy</span>
        </h1>
        <nav class="flex items-center gap-3 text-gray-400 font-bold text-[10px] mt-6 uppercase tracking-[0.2em]">
            <a href="index.php" class="hover:text-orange-500 transition">Home</a>
            <span class="w-1 h-1 bg-gray-600 rounded-full"></span>
            <span class="text-white">The Institution</span>
        </nav>
    </div>
</section>

<section class="py-24 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="animate__animated animate__fadeIn">
                    <h2 class="text-orange-600 text-xs font-black uppercase tracking-[0.5em] mb-4">Vision & Mission</h2>
                    <h3 class="text-5xl font-black text-blue-950 leading-none mb-8 font-oswald uppercase italic">
                        Forging the <br><span class="text-navy">Champions of Tomorrow</span>
                    </h3>
                    <div class="space-y-6 text-lg text-gray-600 leading-relaxed font-medium">
                        <p>The Firozabad Sports Academy stands as a vanguard of athletic development, operating under the <span class="text-navy font-bold">Shyamveer Dadda Sports Development Trust</span>.</p>
                        <p class="border-l-4 border-orange-500 pl-6 italic bg-slate-50 py-4">"Our mandate is simple: To bridge the gap between rural talent and Olympic podiums through scientific intervention and elite coaching."</p>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute -inset-4 bg-navy/5 rounded-full scale-95 group-hover:scale-100 transition duration-700"></div>
                    <img src="assets/images/academy-vision.jpg" class="relative rounded-2xl shadow-2xl grayscale hover:grayscale-0 transition duration-700">
                    <div class="absolute -bottom-6 -left-6 bg-orange-600 text-white p-8 shadow-xl hidden md:block">
                        <span class="block text-4xl font-black italic">15+</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Years of Excellence</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-50 border-y border-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-blue-950 uppercase italic font-oswald">Elite <span class="text-orange-600">Infrastructure</span></h2>
            <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px] mt-2">National Center of Excellence (NCOE) Specifications</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-2 shadow-xl group hover:-translate-y-2 transition duration-500">
                <div class="overflow-hidden relative h-64">
                    <img src="assets/images/ncoe-center.jpg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 group-hover:bg-transparent transition"></div>
                </div>
                <div class="p-8">
                    <h4 class="text-xl font-black text-navy uppercase mb-3">Scientific Testing</h4>
                    <p class="text-sm text-gray-500">High-performance labs equipped with biomechanical analysis tools for every athlete.</p>
                </div>
            </div>

            <div class="bg-white p-2 shadow-xl group hover:-translate-y-2 transition duration-500">
                <div class="overflow-hidden h-64 relative">
                    <img src="assets/images/diet-center.jpg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 group-hover:bg-transparent transition"></div>
                </div>
                <div class="p-8">
                    <h4 class="text-xl font-black text-navy uppercase mb-3">Nutrition Wing</h4>
                    <p class="text-sm text-gray-500">Individualized dietary programs prescribed by international sports nutritionists.</p>
                </div>
            </div>

            <div class="bg-white p-2 shadow-xl group hover:-translate-y-2 transition duration-500">
                <div class="overflow-hidden h-64 relative">
                    <img src="assets/images/hostel.jpg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 group-hover:bg-transparent transition"></div>
                </div>
                <div class="p-8">
                    <h4 class="text-xl font-black text-navy uppercase mb-3">Residential Block</h4>
                    <p class="text-sm text-gray-500">Premium housing designed to ensure optimal recovery and mental focus for trainees.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-navy text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-orange-600/10 -skew-x-12 translate-x-32"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-black uppercase italic font-oswald border-l-8 border-orange-500 pl-6">Sports Sciences <span class="text-orange-500">Faculty</span></h2>
                <p class="text-gray-400 mt-4 font-medium uppercase tracking-widest text-xs">Our programs are backed by rigorous scientific methodology</p>
            </div>
        </div>
        
        
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php 
            $faculties = [
                ['Exercise Physiology', 'Scientific Training'],
                ['Sports Nutrition', 'Dietary Management'],
                ['Physiotherapy', 'Injury Prevention'],
                ['Sports Psychology', 'Mental Resilience']
            ];
            foreach($faculties as $f): 
            ?>
            <div class="bg-white/5 backdrop-blur-md p-8 border border-white/10 hover:border-orange-500 transition group cursor-default">
                <div class="w-12 h-1 text-orange-600 bg-orange-600 mb-6 group-hover:w-full transition-all duration-500"></div>
                <h5 class="font-black text-2xl mb-2 font-oswald uppercase tracking-tighter"><?php echo $f[0]; ?></h5>
                <p class="text-[10px] text-orange-500 uppercase tracking-[0.2em] font-black"><?php echo $f[1]; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-navy text-xs font-black uppercase tracking-[0.4em] mb-4">Leadership</h2>
            <h3 class="text-5xl font-black text-blue-950 font-oswald uppercase italic">Founding <span class="text-orange-600">Pillars</span></h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-4xl mx-auto">
            <div class="flex flex-col items-center text-center group">
                <div class="w-48 h-48 rounded-full overflow-hidden border-8 border-slate-50 mb-6 group-hover:border-orange-600 transition duration-500">
                    <img src="assets/images/trustee1.jpg" class="w-full h-full object-cover">
                </div>
                <h4 class="text-2xl font-black text-navy uppercase font-oswald tracking-tighter">Chairman Name</h4>
                <p class="text-orange-600 font-bold uppercase text-[10px] tracking-widest">Managing Trustee</p>
                <p class="mt-4 text-sm text-gray-500 italic">"A vision to bring world-class facilities to the heart of Uttar Pradesh."</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="w-48 h-48 rounded-full overflow-hidden border-8 border-slate-50 mb-6 group-hover:border-orange-600 transition duration-500">
                    <img src="assets/images/trustee2.jpg" class="w-full h-full object-cover">
                </div>
                <h4 class="text-2xl font-black text-navy uppercase font-oswald tracking-tighter">Secretary Name</h4>
                <p class="text-orange-600 font-bold uppercase text-[10px] tracking-widest">Operations Director</p>
                <p class="mt-4 text-sm text-gray-500 italic">"Dedicated to the scientific development of underprivileged athletes."</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-orange-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white uppercase italic font-oswald mb-8">Ready to join our elite training program?</h2>
        <a href="registration.php" class="inline-block bg-navy text-white px-12 py-5 font-black text-sm tracking-[0.2em] uppercase hover:bg-black transition-all shadow-2xl">
            Register for UID 2026 ⚡
        </a>
    </div>
</section>

<style>
@keyframes slow-zoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.1); }
}
.animate-slow-zoom {
    animation: slow-zoom 20s infinite alternate linear;
}
</style>

<?php include('includes/footer.php'); ?>