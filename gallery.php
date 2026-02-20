<?php include('includes/header.php'); ?>

<section class="relative h-[450px] bg-navy flex items-center justify-center text-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-900/80 via-blue-900/60 to-navy z-10"></div>
    <img src="assets/images/gallery-main-bg.jpg" class="absolute inset-0 w-full h-full object-cover scale-105 animate-slow-zoom">
    
    <div class="relative z-20 animate__animated animate__fadeInUp px-4">
        <span class="bg-orange-600 text-white px-4 py-1 text-[10px] font-black uppercase tracking-[0.4em] mb-4 inline-block">Visual Archive</span>
        <h1 class="text-6xl md:text-8xl font-black text-white italic uppercase tracking-tighter font-oswald leading-none">
            Media <span class="text-orange-500">Center</span>
        </h1>
        <p class="text-gray-300 font-bold uppercase tracking-[0.2em] text-xs mt-6 max-w-xl mx-auto leading-relaxed">
            Capturing the sweat, the grit, and the glory of Firozabad's rising athletic stars.
        </p>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-7 group relative h-[500px] overflow-hidden shadow-2xl border-b-8 border-blue-900">
                <img src="assets/images/photo-preview.jpg" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-12 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <h2 class="text-white text-5xl font-black uppercase italic font-oswald leading-none">Action<br><span class="text-orange-500">Photographs</span></h2>
                    <p class="text-gray-300 text-sm mt-6 font-medium max-w-md opacity-0 group-hover:opacity-100 transition-opacity duration-700">High-definition captures of training sessions, regional tournaments, and award ceremonies.</p>
                    <a href="photo-gallery.php" class="mt-8 inline-block bg-white text-navy px-8 py-4 font-black text-xs uppercase tracking-widest hover:bg-orange-600 hover:text-white transition-all">Enter Photo Vault</a>
                </div>
                <div class="absolute top-8 right-8 bg-white/10 backdrop-blur-md px-6 py-2 border border-white/20 text-white text-[10px] font-black tracking-widest">
                    1,200+ ASSETS
                </div>
            </div>

            <div class="lg:col-span-5 group relative h-[500px] overflow-hidden shadow-2xl border-b-8 border-orange-600">
                <img src="assets/images/news-preview.jpg" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-12">
                    <h2 class="text-white text-5xl font-black uppercase italic font-oswald leading-none">Press<br><span class="text-orange-500">Clippings</span></h2>
                    <p class="text-gray-300 text-sm mt-6 font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-700">Official media coverage and newspaper features.</p>
                    <a href="news-gallery.php" class="mt-8 inline-block border-2 border-white text-white px-8 py-4 font-black text-xs uppercase tracking-widest hover:bg-white hover:text-black transition-all">Read Archive</a>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-24 bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
        <div class="absolute inset-0" style="background-image: url('assets/images/pattern.png'); background-repeat: repeat;"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <h2 class="text-4xl font-black uppercase italic font-oswald border-l-8 border-orange-600 pl-6">Video <span class="text-orange-600">Highlights</span></h2>
                <p class="text-gray-400 mt-4 font-bold uppercase tracking-widest text-[10px]">Cinematic footage of our top athletes</p>
            </div>
            <div class="mt-6 md:mt-0 flex gap-4">
                <div class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center hover:bg-orange-600 cursor-pointer transition">←</div>
                <div class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center hover:bg-orange-600 cursor-pointer transition">→</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative group cursor-pointer overflow-hidden">
                <img src="assets/images/vid-thumb-1.jpg" class="w-full aspect-video object-cover opacity-60 group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-20 h-20 bg-orange-600 rounded-full flex items-center justify-center pl-2 group-hover:scale-125 transition duration-500 shadow-2xl">
                        <svg class="w-8 h-8 text-white fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 p-8 w-full bg-gradient-to-t from-black to-transparent">
                    <h4 class="font-black uppercase text-xl italic tracking-tighter">Cricket Selection Trials 2026</h4>
                    <p class="text-xs text-orange-500 font-bold tracking-widest mt-1 uppercase">Event Coverage</p>
                </div>
            </div>
            <div class="relative group cursor-pointer overflow-hidden">
                <img src="assets/images/vid-thumb-2.jpg" class="w-full aspect-video object-cover opacity-60 group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center pl-2 group-hover:bg-orange-600 transition duration-500">
                        <svg class="w-8 h-8 text-white fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 p-8 w-full bg-gradient-to-t from-black to-transparent">
                    <h4 class="font-black uppercase text-xl italic tracking-tighter">Badminton High-Performance Camp</h4>
                    <p class="text-xs text-orange-500 font-bold tracking-widest mt-1 uppercase">Training Shorts</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h3 class="text-navy text-[10px] font-black uppercase tracking-[0.5em] mb-4">Social Media</h3>
        <h2 class="text-5xl font-black text-navy uppercase italic font-oswald mb-12">#FSA<span class="text-orange-600">InAction</span></h2>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <?php for($i=1; $i<=5; $i++): ?>
            <div class="aspect-square bg-gray-100 relative group overflow-hidden cursor-pointer shadow-lg">
                <img src="assets/images/insta-<?php echo $i; ?>.jpg" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                <div class="absolute inset-0 bg-navy/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300">
                    <span class="text-white font-black text-xs uppercase tracking-widest">View Post</span>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<section class="bg-navy py-16">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between border-y border-white/10 py-10">
        <div class="text-center md:text-left mb-8 md:mb-0">
            <h4 class="text-white font-black uppercase text-3xl italic font-oswald">Are you a member of the press?</h4>
            <p class="text-gray-400 text-sm mt-2 font-medium tracking-wide">Access high-resolution assets and official statements.</p>
        </div>
        <a href="contact.php" class="bg-orange-600 text-white px-12 py-5 font-black text-xs uppercase tracking-widest hover:bg-white hover:text-navy transition-all shadow-2xl">Contact Media Cell</a>
    </div>
</section>

<style>
@keyframes slow-zoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.15); }
}
.animate-slow-zoom {
    animation: slow-zoom 25s infinite alternate ease-in-out;
}
</style>

<?php include('includes/footer.php'); ?>