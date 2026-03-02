<?php 
include('includes/db_connect.php');
include('includes/header.php'); 

$success_msg = false;

// Form Submission Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_inquiries (full_name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql)) {
        $success_msg = true;
    }
}
?>

<section class="bg-navy pt-24 pb-16 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-orange-600/10 skew-x-12 translate-x-20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl animate__animated animate__fadeIn">
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-orange-500 mb-6">
                <a href="index.php" class="hover:text-white">Home</a>
                <span>/</span>
                <span class="text-white">Contact Hub</span>
            </nav>
            <h1 class="text-6xl md:text-8xl font-black text-white italic uppercase tracking-tighter font-oswald leading-none">
                Connect <span class="text-orange-500">With Us</span>
            </h1>
            <p class="text-gray-400 font-medium text-lg mt-6 leading-relaxed">
                Whether you're a prospective athlete, a donor, or a member of the press, our specialized wings are ready to assist you.
            </p>
        </div>
    </div>
</section>

<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <div class="lg:col-span-7 bg-white p-10 md:p-16 shadow-[0_30px_100px_rgba(0,0,0,0.05)] border-t-8 border-navy relative -mt-32 z-30">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-black text-navy uppercase italic font-oswald tracking-tight">Direct <span class="text-orange-600">Inquiry</span></h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-ping"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Response: < 24 hrs</span>
                    </div>
                </div>

                <?php if($success_msg): ?>
                <div class="mb-10 p-6 bg-green-50 border-l-4 border-green-500 animate__animated animate__headShake">
                    <p class="text-green-700 font-black uppercase text-xs tracking-widest">Message Transmitted Successfully!</p>
                    <p class="text-green-600 text-xs mt-1">Our team will reach out to you within 24 hours.</p>
                </div>
                <?php endif; ?>

                <form action="contact.php" method="POST" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative border-b-2 border-gray-100 focus-within:border-orange-500 transition-all group">
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 group-focus-within:text-orange-600">Full Name</label>
                            <input type="text" name="full_name" required placeholder="Your Name" class="w-full pb-4 bg-transparent outline-none text-navy font-bold placeholder:text-gray-200">
                        </div>
                        <div class="relative border-b-2 border-gray-100 focus-within:border-orange-500 transition-all group">
                            <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 group-focus-within:text-orange-600">Email Address</label>
                            <input type="email" name="email" required placeholder="Your Email Address" class="w-full pb-4 bg-transparent outline-none text-navy font-bold placeholder:text-gray-200">
                        </div>
                    </div>

                    <div class="relative border-b-2 border-gray-100 focus-within:border-orange-500 transition-all group">
                        <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 group-focus-within:text-orange-600">Inquiry Subject</label>
                        <select name="subject" class="w-full pb-4 bg-transparent outline-none text-navy font-black appearance-none cursor-pointer">
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="UID Registration Issue">UID Registration Issue</option>
                            <option value="Sponsorship & Donation">Sponsorship & Donation</option>
                            <option value="Media & Press Relations">Media & Press Relations</option>
                        </select>
                    </div>

                    <div class="relative border-b-2 border-gray-100 focus-within:border-orange-500 transition-all group">
                        <label class="block text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 group-focus-within:text-orange-600">Message</label>
                        <textarea name="message" rows="4" required placeholder="How can we help you today?" class="w-full pb-4 bg-transparent outline-none text-navy font-medium placeholder:text-gray-200 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-navy text-white font-black py-6 uppercase tracking-[0.3em] text-xs hover:bg-orange-600 transition-all duration-500 shadow-xl group">
                        Transmitting Message <span class="inline-block ml-4 group-hover:translate-x-2 transition-transform">→</span>
                    </button>
                </form>
            </div>
            
            <div class="lg:col-span-5 space-y-8">
                <div class="h-[400px] grayscale hover:grayscale-0 transition-all duration-700 shadow-2xl border-4 border-white overflow-hidden">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113890.35515250002!2d78.3305545!3d27.1511218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39744123516548d1%3A0x6731997970e7e108!2sFirozabad%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

                <div class="bg-slate-50 p-10 border-l-4 border-orange-600">
                    <h4 class="text-navy font-black uppercase text-xs tracking-widest mb-4">Academy Headquarters</h4>
                    <p class="text-gray-500 font-medium text-sm leading-relaxed">
                        Shyamveer Dadda Sports Development Trust,<br>
                        Main Sports Complex, Sector 4-B,<br>
                        Firozabad, Uttar Pradesh - 283203
                    </p>
                    <p class="text-gray-500 font-medium text-sm leading-relaxed">Email - shyamvirdaddasportsdevelopment@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-white/10">
            <div class="p-12 border-b md:border-b-0 md:border-r border-white/10 group hover:bg-orange-600 transition-all duration-500">
                <span class="text-orange-500 group-hover:text-white font-black text-xs uppercase tracking-widest mb-10 block underline underline-offset-8">Coaching Cell</span>
                <p class="text-gray-400 group-hover:text-white/80 text-xs uppercase font-bold tracking-tighter mb-2">Trials & High Performance</p>
                <h4 class="text-2xl font-black italic font-oswald mb-6 tracking-tight">+91 9675847376</h4>
                <a href="mailto:shyamvirdaddasportsdevelopment@gmail.com" class="text-[10px] font-black uppercase tracking-widest text-orange-500 group-hover:text-white border border-orange-500 group-hover:border-white px-4 py-2">Email Department</a>
            </div>
            
            <div class="p-12 border-b md:border-b-0 md:border-r border-white/10 group hover:bg-navy transition-all duration-500">
                <span class="text-orange-500 font-black text-xs uppercase tracking-widest mb-10 block underline underline-offset-8">Admin Wing</span>
                <p class="text-gray-400 group-hover:text-white/80 text-xs uppercase font-bold tracking-tighter mb-2">UID & Registrations</p>
                <h4 class="text-2xl font-black italic font-oswald mb-6 tracking-tight">+91 9259822664</h4>
                <a href="mailto:shyamvirdaddasportsdevelopment@gmail.com" class="text-[10px] font-black uppercase tracking-widest text-orange-500 border border-orange-500 px-4 py-2 group-hover:border-white group-hover:text-white">Email Department</a>
            </div>

            <div class="p-12 group hover:bg-white transition-all duration-500">
                <span class="text-orange-500 font-black text-xs uppercase tracking-widest mb-10 block underline underline-offset-8">Media Cell</span>
                <p class="text-gray-400 group-hover:text-gray-500 text-xs uppercase font-bold tracking-tighter mb-2">Press & Archive Access</p>
                <h4 class="text-2xl font-black italic font-oswald mb-6 tracking-tight group-hover:text-navy">+91 9675847376</h4>
                <a href="mailto:shyamvirdaddasportsdevelopment@gmail.com" class="text-[10px] font-black uppercase tracking-widest text-orange-500 border border-orange-500 px-4 py-2 group-hover:border-navy group-hover:text-navy">Email Department</a>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h4 class="text-navy text-[10px] font-black uppercase tracking-[0.5em] mb-4">Looking for something else?</h4>
        <div class="flex flex-wrap justify-center gap-4 mt-8">
            <a href="tournaments.php" class="bg-slate-100 px-8 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition">Tournament FAQ</a>
            <a href="gallery.php" class="bg-slate-100 px-8 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition">Media Assets</a>
            <a href="donate.php" class="bg-slate-100 px-8 py-4 text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition">Sponsorship Kit</a>
        </div>
    </div>
</section>

<style>
/* Custom Oswald for Headlines */
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap');
.font-oswald { font-family: 'Oswald', sans-serif; }
</style>

<?php include('includes/footer.php'); ?>