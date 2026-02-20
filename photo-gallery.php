<?php 
include('includes/db_connect.php');
include('includes/header.php'); 

// Fetch photos from DB
$gallery_items = $conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
?>
<section class="bg-white pt-20 pb-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b-2 border-slate-100 pb-10">
            <div class="animate__animated animate__fadeInLeft">
                <span class="text-orange-600 font-black uppercase tracking-[0.4em] text-[10px] mb-2 block">Visual Archive</span>
                <h1 class="text-6xl font-black text-navy uppercase italic tracking-tighter font-oswald leading-none">
                    Action <span class="text-slate-300">Vault</span>
                </h1>
            </div>
            
            <div class="mt-8 md:mt-0 flex flex-wrap gap-2 animate__animated animate__fadeInRight">
                <button class="px-6 py-2 bg-navy text-white text-[10px] font-black uppercase tracking-widest rounded-full">All Shots</button>
                <button class="px-6 py-2 bg-slate-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-orange-600 hover:text-white transition">Cricket</button>
                <button class="px-6 py-2 bg-slate-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-orange-600 hover:text-white transition">Badminton</button>
                <button class="px-6 py-2 bg-slate-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-orange-600 hover:text-white transition">Ceremonies</button>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
            
            <?php 
            $i = 0;
            if($gallery_items->num_rows > 0):
                while($row = $gallery_items->fetch_assoc()): 
                    $i++;
            ?>
            <div class="break-inside-avoid animate__animated animate__fadeInUp group" style="animation-delay: <?php echo $i * 0.05; ?>s">
                <div class="relative overflow-hidden bg-slate-100 shadow-sm transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                    
                    <img src="assets/images/gallery/<?php echo $row['image_path']; ?>" 
                         alt="FSA Action" 
                         class="w-full object-cover transition duration-[1.5s] group-hover:scale-125 group-hover:rotate-1">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">
                        <div class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="text-orange-500 font-black text-[9px] uppercase tracking-[0.3em]"><?php echo $row['category']; ?></span>
                            <h4 class="text-white font-black uppercase text-xl italic font-oswald leading-tight mt-1">
                                <?php echo htmlspecialchars($row['caption']); ?>
                            </h4>
                            <div class="flex items-center gap-4 mt-4">
                                <a href="assets/images/gallery/<?php echo $row['image_path']; ?>" download class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-orange-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>
                                <span class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">Download HD</span>
                            </div>
                        </div>
                    </div>

                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 text-navy text-[8px] font-black uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition duration-500">
                        <?php echo strtoupper($row['category']); ?> ARCHIVE
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            else:
            ?>
                <div class="col-span-full py-20 text-center border-4 border-dashed border-slate-100">
                    <p class="text-slate-300 font-black uppercase italic tracking-widest">No action shots in the vault yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50 relative overflow-hidden">
    <div class="absolute -right-20 -top-20 w-64 h-64 bg-navy opacity-[0.03] rounded-full"></div>
    <div class="absolute -left-20 -bottom-20 w-96 h-96 bg-orange-600 opacity-[0.03] rounded-full"></div>

    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white shadow-2xl flex flex-col md:flex-row overflow-hidden border-b-8 border-orange-600">
            <div class="md:w-1/2 p-12 bg-navy text-white flex flex-col justify-center">
                <h2 class="text-4xl font-black uppercase italic font-oswald leading-none">Capture <br>The <span class="text-orange-500">Grind</span></h2>
                <p class="text-gray-400 mt-6 text-sm leading-relaxed font-medium">
                    Are you a student or parent with great photos from our recent tournaments? Submit them to our media cell to be featured in the official vault.
                </p>
            </div>
            <div class="md:w-1/2 p-12 flex items-center justify-center text-center">
                <div>
                    <p class="text-navy font-black uppercase text-xs tracking-widest mb-6 italic">Join the Visual Legacy</p>
                    <a href="contact.php" class="inline-block border-4 border-navy text-navy px-10 py-4 font-black uppercase text-xs hover:bg-navy hover:text-white transition-all duration-500">
                        Submit Your Photos
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white text-center">
    <div class="container mx-auto px-4">
        <button class="group flex items-center gap-4 mx-auto text-navy">
            <span class="h-[1px] w-12 bg-slate-200 group-hover:w-20 group-hover:bg-orange-600 transition-all duration-500"></span>
            <span class="font-black uppercase text-xs tracking-[0.3em]">Load More Action</span>
            <span class="h-[1px] w-12 bg-slate-200 group-hover:w-20 group-hover:bg-orange-600 transition-all duration-500"></span>
        </button>
    </div>
</section>

<style>
/* Masonry Logic for Tailwind */
.columns-1 { column-count: 1; }
@media (min-width: 768px) { .columns-2 { column-count: 2; } }
@media (min-width: 1024px) { .columns-3 { column-count: 3; } }
@media (min-width: 1280px) { .columns-4 { column-count: 4; } }

.break-inside-avoid {
    break-inside: avoid;
}

.font-oswald {
    font-family: 'Oswald', sans-serif;
}

.text-navy {
    color: #001e5f;
}

.bg-navy {
    background-color: #001e5f;
}
</style>

<?php include('includes/footer.php'); ?>