<?php include('includes/header.php'); ?>

<section class="relative h-[550px] bg-navy flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 via-blue-900/80 to-transparent z-10"></div>
    <img src="assets/images/donate-hero.jpg" class="absolute inset-0 w-full h-full object-cover opacity-30 scale-105 animate-slow-zoom">
    
    <div class="container mx-auto px-4 relative z-20 animate__animated animate__fadeInLeft">
        <span class="bg-orange-600 text-white px-4 py-1 text-[10px] font-black uppercase tracking-[0.4em] mb-4 inline-block">Invest in Excellence</span>
        <h1 class="text-6xl md:text-8xl font-black text-white italic uppercase tracking-tighter font-oswald leading-none">
            Fuel the <span class="text-orange-500">Dreams</span><br>of Firozabad
        </h1>
        <p class="text-gray-300 text-lg mt-8 max-w-2xl leading-relaxed font-medium">
            The <span class="text-white">Shyamveer Dadda Sports Development Trust</span> ensures that financial barriers never stand in the way of a podium finish. Your contribution builds the champions of 2028 and beyond.
        </p>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-navy text-xs font-black uppercase tracking-[0.5em] mb-4">How your contribution helps</h2>
            <h3 class="text-5xl font-black text-blue-950 font-oswald uppercase italic">Your Impact <span class="text-orange-600">Quantified</span></h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group p-10 border border-slate-100 bg-slate-50 hover:bg-navy transition-all duration-500 hover:-translate-y-2">
                <div class="w-16 h-16 bg-white shadow-lg rounded-full flex items-center justify-center text-3xl mb-8 group-hover:rotate-12 transition">🍎</div>
                <h4 class="font-black text-navy group-hover:text-white uppercase text-2xl font-oswald mb-4">Scientific Nutrition</h4>
                <p class="text-sm text-gray-500 group-hover:text-gray-400 leading-relaxed mb-6">Covers 30 days of high-protein dietary supplements and nutritionist-prescribed meals for one budding athlete.</p>
                <span class="text-orange-600 font-black text-sm uppercase tracking-widest">Est. Cost: ₹2,500</span>
            </div>
            <div class="group p-10 border border-slate-100 bg-slate-50 hover:bg-navy transition-all duration-500 hover:-translate-y-2">
                <div class="w-16 h-16 bg-white shadow-lg rounded-full flex items-center justify-center text-3xl mb-8 group-hover:rotate-12 transition">🏸</div>
                <h4 class="font-black text-navy group-hover:text-white uppercase text-2xl font-oswald mb-4">Pro Equipment</h4>
                <p class="text-sm text-gray-500 group-hover:text-gray-400 leading-relaxed mb-6">Provision of international-standard gear (rackets, bats, or shoes) ensuring our players compete on a level playing field.</p>
                <span class="text-orange-600 font-black text-sm uppercase tracking-widest">Est. Cost: ₹7,500</span>
            </div>
            <div class="group p-10 border border-slate-100 bg-slate-50 hover:bg-navy transition-all duration-500 hover:-translate-y-2">
                <div class="w-16 h-16 bg-white shadow-lg rounded-full flex items-center justify-center text-3xl mb-8 group-hover:rotate-12 transition">🏆</div>
                <h4 class="font-black text-navy group-hover:text-white uppercase text-2xl font-oswald mb-4">Tournament Fund</h4>
                <p class="text-sm text-gray-500 group-hover:text-gray-400 leading-relaxed mb-6">Covers travel, registration, and lodging for athletes to participate in National Selection trials and State Championships.</p>
                <span class="text-orange-600 font-black text-sm uppercase tracking-widest">Est. Cost: ₹15,000</span>
            </div>
        </div>
    </div>
</section>

<?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
<div class="fixed top-24 right-4 z-50 bg-green-500 text-white px-8 py-4 shadow-2xl animate__animated animate__bounceInRight">
    <p class="font-black uppercase text-xs tracking-widest">Contribution Received!</p>
    <p class="text-[10px] opacity-80">Thank you for fueling the champions of Firozabad.</p>
</div>
<?php endif; ?>

<section id="donate-now" class="py-24 bg-slate-50 border-y relative overflow-hidden">
    <div class="absolute top-0 right-0 w-1/4 h-full bg-orange-600/5 -skew-x-12 translate-x-20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto bg-white shadow-[0_40px_100px_rgba(0,0,0,0.1)] flex flex-col lg:flex-row border-t-8 border-orange-600">
            
            <div class="lg:w-2/3 p-10 md:p-16">
                <h2 class="text-4xl font-black text-navy uppercase italic font-oswald mb-8">Direct <span class="text-orange-600">Contribution</span></h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                    <button onclick="setAmount(2500)" class="amt-btn border-2 border-gray-100 py-4 font-black text-navy hover:border-orange-500 transition-all uppercase text-xs tracking-widest">₹2,500</button>
                    <button onclick="setAmount(7500)" class="amt-btn border-2 border-gray-100 py-4 font-black text-navy hover:border-orange-500 transition-all uppercase text-xs tracking-widest">₹7,500</button>
                    <button onclick="setAmount(15000)" class="amt-btn border-2 border-gray-100 py-4 font-black text-navy hover:border-orange-500 transition-all uppercase text-xs tracking-widest">₹15,000</button>
                    <button onclick="setAmount(0)" class="amt-btn border-2 border-gray-100 py-4 font-black text-navy hover:border-orange-500 transition-all uppercase text-xs tracking-widest">Custom</button>
                </div>

                <form action="donation_gateway.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Full Name / Entity</label>
                            <input type="text" name="donor_name" placeholder="Your Name" class="w-full p-4 border-b-2 border-slate-100 bg-slate-50 outline-none focus:border-navy transition" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Email Address</label>
                            <input type="email" name="donor_email" placeholder="Your E-mail Address" class="w-full p-4 border-b-2 border-slate-100 bg-slate-50 outline-none focus:border-navy transition" required>
                        </div>
                    </div>
                    <div class="relative pt-4">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1 block mb-2">Contribution Amount</label>
                        <span class="absolute left-4 bottom-4 font-black text-navy text-2xl">₹</span>
                        <input type="number" id="custom_amt" name="amount" placeholder="0.00" class="w-full p-4 pl-12 border-b-2 border-navy bg-slate-50 outline-none text-2xl font-black text-navy" required>
                    </div>
                    <button type="submit" class="w-full bg-orange-600 text-white font-black py-6 text-sm uppercase tracking-[0.3em] shadow-xl hover:bg-navy transition-all duration-500 group">
                        Confirm Secure Donation 
                        <span class="inline-block ml-2 group-hover:translate-x-2 transition-transform">→</span>
                    </button>
                </form>
            </div>

            <div class="lg:w-1/3 bg-navy p-10 md:p-16 text-white flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 -mr-16 -mt-16 rounded-full"></div>
                
                <div>
                    <h3 class="text-2xl font-black uppercase font-oswald mb-8 border-b border-white/10 pb-4 tracking-tighter">Security & Trust</h3>
                    <ul class="space-y-8">
                        <li class="flex gap-4 items-start">
                            <div class="w-6 h-6 rounded-full bg-orange-600 flex items-center justify-center shrink-0 mt-1 shadow-lg shadow-orange-600/20">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-black uppercase text-xs mb-1">Tax Exemption</h5>
                                <p class="text-[11px] text-gray-400 leading-relaxed">Donations are 100% tax-deductible under Section 80G of the Income Tax Act.</p>
                            </div>
                        </li>
                        <li class="flex gap-4 items-start">
                            <div class="w-6 h-6 rounded-full bg-orange-600 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-black uppercase text-xs mb-1">Direct Utilization</h5>
                                <p class="text-[11px] text-gray-400 leading-relaxed">No administrative overhead. 100% of your funds reach the athlete's training ecosystem.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-12 bg-white/5 p-6 border border-white/10 italic text-[11px] text-gray-400">
                    "Transparency is our foundation. For bank transfers or large-scale corporate CSR, please contact the Trustee's office directly."
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h4 class="text-gray-400 font-bold uppercase tracking-[0.5em] text-[10px] mb-12">Institutional Supporters</h4>
        <div class="flex flex-wrap justify-center items-center gap-16 opacity-40 grayscale hover:grayscale-0 transition-all duration-700">
            <img src="assets/images/sponsor1.png" class="h-10 hover:scale-110">
            <img src="assets/images/sponsor2.png" class="h-10 hover:scale-110">
            <img src="assets/images/sponsor3.png" class="h-10 hover:scale-110">
            <img src="assets/images/sponsor4.png" class="h-10 hover:scale-110">
        </div>
    </div>
</section>

<style>
@keyframes slow-zoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.1); }
}
.animate-slow-zoom {
    animation: slow-zoom 20s infinite alternate ease-in-out;
}
.font-oswald { font-family: 'Oswald', sans-serif; }
</style>

<script>
    function setAmount(val) {
        const input = document.getElementById('custom_amt');
        input.value = val === 0 ? '' : val;
        
        // Reset all buttons
        document.querySelectorAll('.amt-btn').forEach(btn => {
            btn.classList.remove('bg-orange-600', 'text-white', 'border-orange-600', 'shadow-xl');
            btn.classList.add('border-gray-100', 'text-navy');
        });
        
        // Style selected button
        if(val !== 0) {
            event.target.classList.add('bg-orange-600', 'text-white', 'border-orange-600', 'shadow-xl');
            event.target.classList.remove('border-gray-100', 'text-navy');
        }
    }
</script>

<?php include('includes/footer.php'); ?>