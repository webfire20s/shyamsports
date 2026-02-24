<?php 
include('includes/db_connect.php'); // Ensure DB connection is included
include('includes/header.php'); 

$error_msg = "";

// Logic to check for duplicate Aadhaar if the form is submitted via AJAX or after the final step
// For this multi-step form, the check usually happens at the final submission in payment_gateway.php, 
// but I have added a frontend validation and the necessary input field below.
?>

<section class="bg-navy py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-black italic uppercase text-white tracking-tighter">Athlete <span class="text-orange-500">Portal</span></h1>
        <p class="text-gray-400 font-bold tracking-[0.3em] text-[10px] mt-2 uppercase">Official Firozabad Sports Academy Registration Gateway</p>
    </div>
</section>

<section class="py-16 bg-slate-100">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-4 order-2 lg:order-1">
                <div class="bg-white p-8 shadow-2xl border-t-8 border-navy sticky top-24">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-navy text-white p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-black text-blue-900 uppercase italic">Secure Login</h2>
                    </div>
                    
                    <form action="login_process.php" method="POST" class="space-y-6">
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-focus-within:text-orange-500 transition">Enter UID</label>
                            <input type="text" name="uid" placeholder="FSA-2026-XXXX" class="w-full border-b-2 border-gray-100 p-3 focus:border-orange-500 outline-none transition bg-slate-50 font-bold" required>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-focus-within:text-orange-500 transition">Password</label>
                            <input type="password" name="password" class="w-full border-b-2 border-gray-100 p-3 focus:border-orange-500 outline-none transition bg-slate-50 font-bold" required>
                        </div>
                        <button type="submit" class="w-full bg-navy text-white font-black py-4 uppercase tracking-widest hover:bg-orange-600 transition shadow-xl">Access Dashboard</button>
                        <a href="#" class="block text-center text-[10px] font-black text-gray-400 hover:text-navy mt-4 uppercase tracking-widest">Forgot Credentials?</a>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8 order-1 lg:order-2">
                <div class="bg-white shadow-2xl border-t-8 border-orange-600 overflow-hidden">
                    
                    <div class="p-8 border-b border-gray-50 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div>
                            <h2 class="text-3xl font-black text-blue-900 uppercase italic">Draft <span class="text-orange-600">Enrolment</span></h2>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Academic Year 2026-27</p>
                        </div>
                        
                        <div id="step-indicator" class="flex items-center gap-3">
                            <div class="flex items-center flex-col gap-1">
                                <span class="step-dot h-2 w-10 rounded-full bg-orange-600 transition-all duration-500"></span>
                                <span class="text-[8px] font-black text-navy uppercase">Personal</span>
                            </div>
                            <div class="flex items-center flex-col gap-1">
                                <span class="step-dot h-2 w-10 rounded-full bg-gray-200 transition-all duration-500"></span>
                                <span class="text-[8px] font-black text-gray-300 uppercase">Contact</span>
                            </div>
                            <div class="flex items-center flex-col gap-1">
                                <span class="step-dot h-2 w-10 rounded-full bg-gray-200 transition-all duration-500"></span>
                                <span class="text-[8px] font-black text-gray-300 uppercase">Verify</span>
                            </div>
                            <div class="flex items-center flex-col gap-1">
                                <span class="step-dot h-2 w-10 rounded-full bg-gray-200 transition-all duration-500"></span>
                                <span class="text-[8px] font-black text-gray-300 uppercase">Finish</span>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($_GET['status']) && $_GET['status'] == 'duplicate_aadhaar'): ?>
                        <div class="mb-6 p-4 bg-red-600 text-white font-black uppercase text-xs tracking-widest animate__animated animate__shakeX">
                            Error: This Aadhaar Number is already registered with us!
                        </div>
                    <?php endif; ?>

                    <form id="regForm" action="payment_gateway.php" method="POST" enctype="multipart/form-data" class="p-8 md:p-12">
                        
                        <div class="step-content animate__animated animate__fadeIn" id="step-1">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Full Name (As per Aadhaar)</label>
                                    <input type="text" name="fullname" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none focus:border-blue-900 font-bold uppercase" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Aadhaar Number (Unique 12 Digits)</label>
                                    <input type="text" name="aadhaar_no" id="aadhaar_no" maxlength="12" pattern="\d{12}" placeholder="0000 0000 0000" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none focus:border-orange-600 font-bold" required>
                                    <span id="aadhaar_status" class="text-[8px] font-bold uppercase mt-1 block"></span>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Blood Group</label>
                                    <select name="blood_group" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none font-bold">
                                        <option value="">Select</option>
                                        <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                                        <option>O+</option><option>O-</option><option>AB+</option><option>AB-</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" onchange="calculateCategory()" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none font-bold text-navy" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Gender</label>
                                    <select name="gender" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none font-bold">
                                        <option>Male</option><option>Female</option><option>Other</option>
                                    </select>
                                </div>

                                <div class="bg-navy/5 p-4 border-l-4 border-orange-500 flex flex-col justify-center">
                                    <label class="block text-[8px] font-black text-gray-400 uppercase tracking-widest">Calculated Category</label>
                                    <span id="categoryLabel" class="text-navy font-black italic uppercase">Select DOB First</span>
                                    <input type="hidden" name="athlete_category" id="athlete_category">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Sports Group</label>
                                    <select id="sport_group" onchange="updateSportList()" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none font-bold text-sm">
                                        <option value="">Select Group</option>
                                        <option value="Athletics">Athletics (Track & Field)</option>
                                        <option value="Combat">Combat Sports (Wrestling, Gatka)</option>
                                        <option value="Aquatic">Aquatic Sports</option>
                                        <option value="Indigenous">Indigenous Games</option>
                                        <option value="BallGames">Ball Games / Others</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Specific Discipline</label>
                                    <select name="sport" id="specific_sport" class="w-full bg-slate-50 border-2 border-slate-100 p-4 outline-none font-bold text-sm">
                                        <option value="">Select Group First</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Height (CM)</label>
                                    <input type="number" name="height" placeholder="e.g. 175" class="w-full bg-slate-50 border-2 border-slate-100 p-4 font-bold">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Weight (KG)</label>
                                    <input type="number" name="weight" placeholder="e.g. 65" class="w-full bg-slate-50 border-2 border-slate-100 p-4 font-bold">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Father's Name</label>
                                    <input type="text" name="father_name" class="w-full bg-slate-50 border-2 border-slate-100 p-4 font-bold uppercase">
                                </div>
                            </div>
                            <div class="mt-12 pt-8 border-t border-gray-100 flex justify-end">
                                <button type="button" onclick="validateStep1()" class="bg-orange-600 text-white px-12 py-4 font-black uppercase tracking-widest hover:bg-navy transition shadow-xl">Next: Contact Info →</button>
                            </div>
                        </div>

                        <div class="step-content hidden animate__animated animate__fadeIn" id="step-2">
                            <h3 class="text-xl font-black text-blue-900 mb-8 uppercase italic border-l-4 border-orange-600 pl-4">Contact & Residence</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest">Mobile Number*</label>
                                    <input type="tel" name="mobile" class="w-full border-2 border-slate-100 p-4 bg-slate-50 font-bold" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest">Email Address*</label>
                                    <input type="email" name="email" class="w-full border-2 border-slate-100 p-4 bg-slate-50 font-bold" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest">Full Communication Address*</label>
                                    <textarea name="address" rows="3" class="w-full border-2 border-slate-100 p-4 bg-slate-50 font-bold"></textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest">District</label>
                                    <input type="text" name="district" value="Firozabad" class="w-full border-2 border-slate-200 p-4 bg-gray-200 font-black" readonly>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 mb-2 uppercase tracking-widest">Pincode*</label>
                                    <input type="text" name="pincode" class="w-full border-2 border-slate-100 p-4 bg-slate-50 font-bold" required>
                                </div>
                            </div>
                            <div class="mt-12 pt-8 border-t border-gray-100 flex gap-4">
                                <button type="button" onclick="nextStep(1)" class="bg-gray-200 text-navy px-10 py-4 font-black uppercase tracking-widest hover:bg-gray-300">Back</button>
                                <button type="button" onclick="nextStep(3)" class="bg-orange-600 text-white px-12 py-4 font-black uppercase tracking-widest hover:bg-navy shadow-xl">Next: Documents →</button>
                            </div>
                        </div>

                        <div class="step-content hidden animate__animated animate__fadeIn" id="step-3">
                            <h3 class="text-xl font-black text-blue-900 mb-8 uppercase italic border-l-4 border-orange-600 pl-4">Document Verification</h3>
                            <div class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="border-2 border-dashed border-slate-200 p-8 text-center bg-slate-50 hover:border-orange-500 transition cursor-pointer">
                                        <label class="block text-[10px] font-black text-gray-500 mb-4 uppercase tracking-widest italic">Recent Photo (Max 2MB)</label>
                                        <input type="file" name="photo" class="text-xs font-bold" required>
                                    </div>
                                    <div class="border-2 border-dashed border-slate-200 p-8 text-center bg-slate-50 hover:border-orange-500 transition cursor-pointer">
                                        <label class="block text-[10px] font-black text-gray-500 mb-4 uppercase tracking-widest italic">Aadhaar Card (PDF)</label>
                                        <input type="file" name="aadhar_doc" class="text-xs font-bold" required>
                                    </div>
                                </div>

                                <div class="bg-blue-900/5 p-8 border-l-8 border-navy">
                                    <label class="flex items-center gap-4 cursor-pointer mb-0">
                                        <input type="checkbox" id="hasPassport" onchange="togglePassport()" class="h-6 w-6 accent-navy">
                                        <span class="font-black text-navy uppercase italic tracking-widest text-sm">I hold an Indian Passport</span>
                                    </label>
                                    <div id="passportField" class="hidden mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 animate__animated animate__slideInDown">
                                        <input type="text" name="passport_no" placeholder="Passport Number" class="w-full border-2 border-white p-4 bg-white shadow-sm font-bold">
                                        <input type="file" name="passport_doc" class="w-full border-2 border-white p-3 bg-white shadow-sm text-xs font-bold">
                                    </div>
                                </div>

                                <div class="bg-orange-50 p-8 border-l-8 border-orange-600">
                                    <h4 class="font-black text-orange-800 mb-6 uppercase italic tracking-widest">Fee Category Selection</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <label class="flex items-center gap-4 cursor-pointer bg-white p-4 border border-orange-100 shadow-sm">
                                            <input type="radio" name="fee_type" value="normal" checked onchange="updateFee(1000)" class="h-5 w-5 accent-orange-600">
                                            <span class="font-black text-navy text-xs uppercase">General (₹1,000)</span>
                                        </label>
                                        <label class="flex items-center gap-4 cursor-pointer bg-white p-4 border border-orange-100 shadow-sm">
                                            <input type="radio" name="fee_type" value="ration" onchange="updateFee(500)" class="h-5 w-5 accent-orange-600">
                                            <span class="font-black text-red-600 text-xs uppercase italic">Ration Card (₹500)</span>
                                        </label>
                                    </div>
                                    <div id="rationUpload" class="hidden mt-6 animate__animated animate__pulse">
                                        <label class="block text-[10px] font-black text-red-600 mb-2 uppercase">Upload Ration Card Proof*</label>
                                        <input type="file" name="ration_doc" class="w-full border-2 border-red-100 p-4 bg-white text-xs font-bold">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-12 pt-8 border-t border-gray-100 flex gap-4">
                                <button type="button" onclick="nextStep(2)" class="bg-gray-200 text-navy px-10 py-4 font-black uppercase tracking-widest hover:bg-gray-300">Back</button>
                                <button type="button" onclick="nextStep(4)" class="bg-orange-600 text-white px-12 py-4 font-black uppercase tracking-widest hover:bg-navy shadow-xl">Review & Finish →</button>
                            </div>
                        </div>

                        <div class="step-content hidden animate__animated animate__fadeIn" id="step-4">
                            <div class="bg-navy p-10 text-white shadow-2xl relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-600/20 rounded-full -mr-16 -mt-16"></div>
                                <h3 class="text-3xl font-black uppercase italic border-b border-white/10 pb-6 mb-8">Final <span class="text-orange-500">Declaration</span></h3>
                                <div class="space-y-6 text-sm text-gray-300 font-medium">
                                    <div class="flex gap-4">
                                        <span class="text-orange-500 font-black">01</span>
                                        <p>I hereby declare that all details provided (including Aadhaar No.) are true to my knowledge and documents are original.</p>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-orange-500 font-black">02</span>
                                        <p>I understand that any false documentation will lead to immediate cancellation of my UID and potential ban from trials.</p>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-orange-500 font-black">03</span>
                                        <p>I agree to abide by the Firozabad Sports Academy Code of Conduct and Anti-Doping regulations.</p>
                                    </div>
                                </div>
                                <div class="mt-12 pt-10 border-t border-white/10">
                                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                                        <div class="text-center md:text-left">
                                            <span class="text-[10px] uppercase font-black tracking-widest text-orange-500">Payable Amount:</span>
                                            <h4 id="finalFee" class="text-6xl font-black tracking-tighter italic">₹1,000</h4>
                                        </div>
                                        <button type="submit" class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-black px-16 py-6 text-xl shadow-2xl transition-all transform hover:scale-105 active:scale-95">PROCEED TO PAYMENT</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="nextStep(3)" class="mt-6 text-navy font-black uppercase text-[10px] tracking-widest hover:text-orange-500">Return to documentation</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // --- STEP VALIDATION FOR AADHAAR ---
    function validateStep1() {
        const aadhaar = document.getElementById('aadhaar_no').value;
        const status = document.getElementById('aadhaar_status');
        
        if(aadhaar.length !== 12 || isNaN(aadhaar)) {
            status.innerText = "Error: Aadhaar must be exactly 12 digits.";
            status.className = "text-[8px] font-black uppercase mt-1 block text-red-600";
            return false;
        }

        // Optional: Simple AJAX check for real-time validation if you have check_aadhaar.php
        /*
        fetch('includes/check_aadhaar.php?no=' + aadhaar)
            .then(response => response.json())
            .then(data => {
                if(data.exists) {
                    status.innerText = "Error: Aadhaar already registered.";
                    status.className = "text-[8px] font-black uppercase mt-1 block text-red-600";
                } else {
                    nextStep(2);
                }
            });
        */
        
        nextStep(2);
    }

    function calculateCategory() {
        const dobInput = document.getElementById('dob').value;
        if (!dobInput) return;

        const dob = new Date(dobInput);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        let category = "Senior";
        if (age < 4) category = "Toddler (U-4)";
        else if (age < 6) category = "Under-6";
        else if (age < 8) category = "Under-8";
        else if (age < 10) category = "Under-10";
        else if (age < 12) category = "Under-12";
        else if (age < 14) category = "Under-14";
        else if (age < 16) category = "Under-16";
        else if (age < 18) category = "Under-18";
        else if (age < 20) category = "Under-20";
        else if (age <= 23) category = "Under-23";

        document.getElementById('categoryLabel').innerText = category;
        document.getElementById('athlete_category').value = category;
    }

    const sportsData = {
        "Athletics": ["100m/200m Sprint", "Long Jump", "High Jump", "Shot Put", "Javelin", "800m Run", "3000m Steeplechase", "Decathlon"],
        "Combat": ["Wrestling (FS)", "Boxing", "Gatka", "Silambam", "Judo", "Thang-Ta", "Taekwondo"],
        "Aquatic": ["Swimming (Free)", "Swimming (Back)", "Diving", "Water Polo"],
        "Indigenous": ["Mallakhamb", "Kabbadi", "Kho-Kho", "Lagori", "Atya Patya"],
        "BallGames": ["Badminton", "Cricket", "Football", "Basketball", "Yogasana", "Archery", "Shooting"]
    };

    function updateSportList() {
        const group = document.getElementById('sport_group').value;
        const sportSelect = document.getElementById('specific_sport');
        sportSelect.innerHTML = '<option value="">Select Specific Sport</option>';
        
        if(sportsData[group]) {
            sportsData[group].forEach(sport => {
                let opt = document.createElement('option');
                opt.value = sport;
                opt.innerHTML = sport;
                sportSelect.appendChild(opt);
            });
        }
    }

    function nextStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('step-' + step).classList.remove('hidden');
        
        const dots = document.querySelectorAll('.step-dot');
        dots.forEach((dot, index) => {
            if (index < step) {
                dot.classList.replace('bg-gray-200', 'bg-orange-600');
            } else {
                dot.classList.replace('bg-orange-600', 'bg-gray-200');
            }
        });
        window.scrollTo({ top: 200, behavior: 'smooth' });
    }

    function togglePassport() {
        const field = document.getElementById('passportField');
        field.classList.toggle('hidden', !document.getElementById('hasPassport').checked);
    }

    function updateFee(amount) {
        document.getElementById('finalFee').innerText = '₹' + amount.toLocaleString();
        const rationUpload = document.getElementById('rationUpload');
        rationUpload.classList.toggle('hidden', amount !== 500);
    }
</script>

<?php include('includes/footer.php'); ?>