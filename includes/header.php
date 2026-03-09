<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firozabad Sports Academy | Path to National Glory</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --navy: #001e5f;
            --academy-orange: #ff6600;
        }
        body { font-family: 'Inter', sans-serif; }
        .font-oswald { font-family: 'Oswald', sans-serif; }
        
        .bg-navy { background-color: var(--navy); }
        .text-orange { color: var(--academy-orange); }
        
        /* Premium Underline Animation */
        .nav-link { position: relative; transition: all 0.3s ease; }
        .nav-link::after { 
            content: ''; position: absolute; width: 0; height: 3px; 
            bottom: 0; left: 0; background-color: var(--academy-orange); 
            transition: width 0.3s ease; 
        }
        .nav-link:hover::after { width: 100%; }
        .nav-link:hover { color: var(--academy-orange); }

        /* Glassmorphism for Navbar */
        .glass-nav {
            background: rgba(0, 30, 95, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Hero Text Gradient */
        .trust-title {
            background: linear-gradient(to right, #001e5f, #1e40af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50">

<header class="bg-white py-6 border-b border-gray-100 relative z-50">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-6">
            <a href="index.php" class="shrink-0">
                <img src="assets/images/logo.png" alt="FSA Logo" class="h-16 md:h-24 hover:scale-105 transition-transform duration-500">
            </a>
            <div class="h-16 w-[2px] bg-gray-200 hidden md:block"></div>
            <div>
                <h1 class="trust-title text-2xl md:text-4xl font-black font-oswald tracking-tighter uppercase leading-none">
                    SHYAMVEER DADDA <br> <span class="text-lg md:text-xl text-gray-500 tracking-widest font-sans font-bold italic">SPORTS DEVELOPMENT TRUST</span>
                </h1>
            </div>
        </div>
        
        <div class="hidden lg:flex items-center gap-8">
            <div class="text-right">
                <p class="text-[10px] font-black text-gray-400 uppercase">Registered Office</p>
                <p class="text-xs font-bold text-navy uppercase">Firozabad, Uttar Pradesh</p>
                <p class="text-xs font-bold text-navy uppercase">shyamvirdaddasportsdevelopment@gmail.com</p>
            </div>
            <div class="bg-navy h-14 w-14 rounded-full flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-medal"></i>
                <span class="font-black text-xs">SDSDT</span>
            </div>
        </div>
    </div>
</header>

<nav class="glass-nav sticky top-0 z-[100] shadow-2xl border-b border-white/10">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center">
            
            <button class="md:hidden text-white p-4 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>

            <ul class="hidden md:flex items-center text-white text-[13px] font-black tracking-widest uppercase h-16">
                <li><a href="index.php" class="nav-link py-6 px-5 block">Home</a></li>
                <li><a href="about.php" class="nav-link py-6 px-5 block">About Us</a></li>
                <li><a href="disciplines.php" class="nav-link py-6 px-5 block">Discover</a></li>
                <li class="relative group h-full">
                    <a href="gallery.php" class="nav-link py-6 px-5 block flex items-center gap-1">Gallery <span class="text-[8px] opacity-50 italic">▼</span></a>
                    <ul class="absolute top-16 left-0 hidden group-hover:block bg-white text-black w-56 shadow-2xl border-t-4 border-orange-600 animate__animated animate__fadeInUp">
                        <li><a href="news-gallery.php" class="block px-6 py-4 hover:bg-slate-50 hover:text-orange-600 border-b border-gray-100 transition">News Room</a></li>
                        <li><a href="photo-gallery.php" class="block px-6 py-4 hover:bg-slate-50 hover:text-orange-600 transition">Action Photos</a></li>
                    </ul>
                </li>
                <li><a href="tournaments.php" class="nav-link py-6 px-5 block">Tournaments</a></li>
                <li><a href="donate.php" class="nav-link py-6 px-5 block">Donate</a></li>
                <li><a href="contact.php" class="nav-link py-6 px-5 block">Contact</a></li>
            </ul>

            <div class="flex items-center">
                <a href="registration.php" class="bg-[#ff6600] text-white px-8 h-16 flex items-center justify-center font-black text-xs tracking-[0.2em] uppercase hover:bg-black transition-all duration-500 shadow-inner group">
                    <span class="mr-2 group-hover:animate-bounce">⚡</span> Registration (UID)
                </a>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-navy pb-6 px-4">
            <ul class="text-white space-y-4 font-bold text-sm uppercase pt-4"> 
                <li><a href="index.php" class="block py-2 border-b border-white/10">Home</a></li>
                <li><a href="about.php" class="block py-2 border-b border-white/10">About Us</a></li>
                <li><a href="gallery.php" class="block py-2 border-b border-white/10">Gallery</a></li>
                <li><a href="tournaments.php" class="block py-2 border-b border-white/10">Tournaments</a></li>
                <li><a href="donate.php" class="block py-2 border-b border-white/10">Donate</a></li>
                <li><a href="contact.php" class="block py-2 border-b border-white/10">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>