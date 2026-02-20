<?php 
include('includes/db_connect.php');
include('includes/header.php'); 

$news_query = $conn->query("SELECT * FROM news ORDER BY news_date DESC");
?>

<section class="bg-slate-50 pt-16 pb-12 border-b">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="animate__animated animate__fadeInLeft">
                <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">
                    <a href="index.php" class="hover:text-orange-600">Home</a>
                    <span>/</span>
                    <a href="gallery.php" class="hover:text-orange-600">Gallery</a>
                    <span>/</span>
                    <span class="text-navy">News Room</span>
                </nav>
                <h1 class="text-6xl font-black text-navy uppercase italic tracking-tighter font-oswald leading-none">
                    Press <span class="text-orange-600">Clippings</span>
                </h1>
            </div>
            <div class="flex gap-3">
                <button class="px-6 py-2 bg-navy text-white text-[10px] font-black uppercase tracking-widest shadow-lg">All Coverage</button>
                <button class="px-6 py-2 bg-white text-navy text-[10px] font-black uppercase tracking-widest border hover:bg-gray-50 transition">National</button>
                <button class="px-6 py-2 bg-white text-navy text-[10px] font-black uppercase tracking-widest border hover:bg-gray-50 transition">Local</button>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-16">
            
            <?php 
            $count = 0;
            while($row = $news_query->fetch_assoc()): 
                $count++;
            ?>
            <div class="flex flex-col group animate__animated animate__fadeInUp" style="animation-delay: <?php echo $count * 0.1; ?>s">
                <div class="relative bg-slate-200 p-3 shadow-sm group-hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <div class="absolute inset-0 border-8 border-white/20 z-10 pointer-events-none"></div>
                    
                    <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-multiply bg-[url('https://www.transparenttextures.com/patterns/paper-fibers.png')]"></div>
                    
                    <img src="assets/images/news/<?php echo $row['image_path']; ?>" 
                         alt="Press Clipping" 
                         class="w-full h-[400px] object-cover object-top shadow-md grayscale group-hover:grayscale-0 transition duration-700 group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-navy/80 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-all duration-500 p-8 text-center">
                        <div class="w-12 h-12 rounded-full bg-orange-600 flex items-center justify-center mb-4 scale-50 group-hover:scale-100 transition-transform duration-500">
                             <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </div>
                        <p class="text-white font-black uppercase tracking-[0.2em] text-xs">View Full Article</p>
                    </div>
                </div>

                <div class="mt-8 relative pl-6 border-l-2 border-gray-100 group-hover:border-orange-600 transition-colors duration-500">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-orange-600 font-black text-[9px] uppercase tracking-widest py-1 px-2 bg-orange-50"><?php echo htmlspecialchars($row['news_source']); ?></span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="text-gray-400 font-bold text-[9px] uppercase tracking-widest"><?php echo date('M d, Y', strtotime($row['news_date'])); ?></span>
                    </div>
                    
                    <h3 class="text-2xl font-black text-navy leading-tight uppercase font-oswald group-hover:text-orange-600 transition-colors">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </h3>
                    
                    <p class="text-sm text-gray-500 mt-4 leading-relaxed line-clamp-2 italic">
                        "<?php echo htmlspecialchars($row['description']); ?>"
                    </p>

                    <button class="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-tighter text-navy group-hover:gap-4 transition-all">
                        Read Summary <span>→</span>
                    </button>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </div>
</section>
<section class="py-24 bg-navy relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-white/5 skew-x-12 translate-x-32"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-12 md:p-20 shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-black text-white uppercase italic font-oswald leading-none">Download <br><span class="text-orange-600 text-5xl">Media Kit 2026</span></h2>
                    <p class="text-gray-400 mt-6 text-lg">Are you a journalist or news editor? Download our high-resolution logos, campus images, and official trust backgrounder for your coverage.</p>
                </div>
                <div class="flex flex-col md:flex-row gap-4">
                    <a href="#" class="flex-1 bg-white text-navy p-6 flex items-center justify-between group hover:bg-orange-600 hover:text-white transition-all">
                        <span class="font-black uppercase text-xs tracking-widest">Official Logos (PNG/SVG)</span>
                        <span class="text-xl group-hover:translate-y-1 transition">↓</span>
                    </a>
                    <a href="#" class="flex-1 bg-white/10 text-white p-6 border border-white/20 flex items-center justify-between group hover:bg-white hover:text-navy transition-all">
                        <span class="font-black uppercase text-xs tracking-widest">Press Release PDF</span>
                        <span class="text-xl group-hover:translate-y-1 transition">↓</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
        <p class="text-gray-400 font-bold uppercase tracking-[0.3em] text-[10px] mb-4">Official Inquiry</p>
        <h2 class="text-3xl font-black text-navy uppercase italic font-oswald">For media interviews and site visits</h2>
        <a href="contact.php" class="mt-8 inline-block bg-orange-600 text-white px-12 py-5 font-black text-xs uppercase tracking-[0.2em] hover:bg-navy transition-all shadow-xl">Contact Press Liaison</a>
    </div>
</section>

<style>
/* Custom Oswald for Headlines */
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap');

.font-oswald {
    font-family: 'Oswald', sans-serif;
}

.text-navy {
    color: #001e5f;
}

.bg-navy {
    background-color: #001e5f;
}

/* Line clamping for cleaner grid */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
</style>

<?php include('includes/footer.php'); ?>