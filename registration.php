<?php 
include('includes/db_connect.php'); 
include('includes/header.php'); 

$error_msg = "";

// --- NEW: UID CARD DISPLAY LOGIC (Triggers after successful registration) ---
if(isset($_GET['success']) && isset($_GET['id'])) {
    $athlete_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM athletes WHERE id = '$athlete_id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if($data) {
        $uid_display = "SDSDT-" . str_pad($data['id'], 4, '0', STR_PAD_LEFT);
        $name = $data['full_name'];
        $dob = $data['dob'];
        $gender = $data['gender'];
        // Use the uploaded photo if exists, otherwise default
        $photo_path = !empty($data['photo']) ? $data['photo'] : 'assets/images/default-user.png';
?>
    <style>
        @media print {
            body * { visibility: hidden; }
            #id-card-print, #id-card-print * { visibility: visible; }
            #id-card-print { position: absolute; left: 0; top: 0; width: 100%; display: flex !important; flex-direction: row !important; gap: 20px; justify-content: center; }
            .no-print { display: none !important; }
        }
        .id-card {
            width: 350px;
            height: 220px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border: 1px solid #d1d5db;
        }
        .wave-container {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 70px;
            background: #24333c;
            clip-path: polygon(0 35%, 100% 0, 100% 100%, 0% 100%);
            z-index: 1;
        }
        .cyan-divider {
            position: absolute;
            bottom: 68px;
            width: 100%;
            height: 4px;
            background: #00d4ff;
            z-index: 2;
        }
    </style>

    <section class="py-20 bg-slate-200 min-h-screen animate__animated animate__fadeIn">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-10 no-print">
                <div class="inline-block bg-green-600 text-white px-6 py-2 rounded-full font-black uppercase tracking-widest text-xs mb-4 shadow-lg">Success: Registration Confirmed</div>
                <h2 class="text-4xl font-black text-navy italic">ATHLETE <span class="text-orange-600">IDENTITY CARD</span></h2>
                <p class="text-slate-500 font-bold mt-2">Your unique ID has been generated. Please print or save this card.</p>
            </div>

            <div id="id-card-print" class="flex flex-col md:flex-row gap-10 justify-center items-center">
                
                <div class="id-card shadow-2xl relative bg-white">
                    <div class="bg-[#24333c] p-2 flex items-center gap-2 relative z-10 border-b-2 border-yellow-500">
                        <img src="assets/images/logo.png" class="w-10 h-10 bg-white rounded-full p-1">
                        <div class="text-left">
                            <h3 class="text-[9px] font-black text-white leading-tight uppercase">Shyamvir Dadda Sports Development Trust</h3>
                            <p class="text-[6px] text-cyan-400 font-bold">Shekhupur, Block Narkhi, Dist. Firozabad, U.P. 283203</p>
                        </div>
                    </div>

                    <div class="p-3 flex gap-4 relative z-10">
                        <div class="w-20 h-24 border-2 border-slate-200 bg-slate-50 overflow-hidden shadow-inner">
                            <img src="<?php echo $photo_path; ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="text-left space-y-1.5 pt-1">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-tighter">Name</p>
                            <p class="text-[12px] font-bold text-navy uppercase leading-none"><?php echo $name; ?></p>
                            
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <div>
                                    <p class="text-[8px] font-black text-slate-500 uppercase">DOB</p>
                                    <p class="text-[10px] font-bold text-navy"><?php echo date('d-m-Y', strtotime($dob)); ?></p>
                                </div>
                                <div>
                                    <p class="text-[8px] font-black text-slate-500 uppercase">Gender</p>
                                    <p class="text-[10px] font-bold text-navy uppercase"><?php echo $gender; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cyan-divider"></div>
                    <div class="wave-container"></div>
                    
                    <div class="absolute bottom-2 w-full px-3 flex justify-between items-end z-10">
                        <div class="bg-white px-2 py-1 border border-navy shadow-sm">
                            <span class="text-[10px] font-black italic text-navy">UID: <?php echo $uid_display; ?></span>
                        </div>
                        <div class="text-center pb-1">
                            <img src="assets/images/signature.png" class="h-5 mx-auto brightness-0 invert opacity-80">
                            <p class="text-[5px] font-black text-white uppercase tracking-widest">Authorized Signatory</p>
                        </div>
                    </div>
                </div>

                <div class="id-card shadow-2xl relative flex flex-col justify-between bg-white">
                    <div class="p-5 text-left">
                        <h3 class="text-sm font-black text-navy mb-3 italic border-b border-orange-500 inline-block">Terms & Conditions</h3>
                        <ul class="text-[8px] space-y-1.5 font-bold text-slate-600">
                            <li>• This card must be carried during all academy trials.</li>
                            <li>• The card is non-transferable and property of SDSDT.</li>
                            <li>• Loss of card should be reported immediately to the office.</li>
                            <li>• Misuse of this card will lead to disqualification.</li>
                        </ul>
                    </div>

                    <div class="w-full">
                        <div class="h-1 bg-cyan-400 w-full"></div>
                        <div class="bg-[#24333c] p-3 text-center">
                            <p class="text-[8px] text-white font-bold mb-1">Emergency Contact: +91 9675847376</p>
                            <p class="text-[7px] text-slate-400 font-medium italic">shyamvirdaddasportsdevelopment@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 no-print flex flex-col md:flex-row gap-4 justify-center">
                <button onclick="window.print()" class="bg-navy text-white px-10 py-4 font-black uppercase tracking-widest hover:bg-orange-600 transition shadow-xl">
                    Print / Download PDF
                </button>
                <a href="index.php" class="bg-white text-navy border-2 border-navy px-10 py-4 font-black uppercase tracking-widest hover:bg-slate-100 transition">
                    Return to Home
                </a>
            </div>
        </div>
    </section>

<?php 
        include('includes/footer.php');
        exit(); 
    }
}
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
                <div class="bg-white p-8 shadow-2xl border-t-8 border-[#001e5f] sticky top-24">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-[#001e5f] text-white p-3 shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-blue-900 uppercase italic leading-none">Athlete<br><span class="text-orange-600 text-sm tracking-widest not-italic">Secure Login</span></h2>
                    </div>

                    <?php if(isset($_GET['error'])): ?>
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 animate__animated animate__shakeX">
                            <p class="text-[10px] font-black text-red-600 uppercase tracking-widest">
                                <?php 
                                    if($_GET['error'] == 'invalid_credentials') echo "Incorrect Password. Please try again.";
                                    elseif($_GET['error'] == 'user_not_found') echo "UID not found. Check your Receipt.";
                                    else echo "Login failed. Please contact support.";
                                ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <form action="login_process.php" method="POST" class="space-y-6">
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-focus-within:text-orange-500 transition">Enter UID</label>
                            <input type="text" name="uid" placeholder="SDSDT-2026-XXXX" 
                                class="w-full border-b-2 border-gray-100 p-3 focus:border-orange-500 outline-none transition bg-slate-50 font-bold text-navy placeholder:text-gray-300 uppercase" required>
                        </div>
                        
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 group-focus-within:text-orange-500 transition">Password (Your Mobile No.)</label>
                            <input type="password" name="password" placeholder="••••••••••" 
                                class="w-full border-b-2 border-gray-100 p-3 focus:border-orange-500 outline-none transition bg-slate-50 font-bold text-navy" required>
                        </div>

                        <button type="submit" class="w-full bg-[#001e5f] text-white font-black py-4 uppercase tracking-widest hover:bg-orange-600 transition shadow-xl flex items-center justify-center gap-2 group">
                            Access Dashboard
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                        
                        <div class="text-center space-y-2 mt-4">
                            <a href="#" class="block text-[10px] font-black text-gray-400 hover:text-navy uppercase tracking-widest transition">Forgot Credentials?</a>
                            <p class="text-[9px] text-slate-300 font-bold uppercase tracking-tighter italic">Default Password is your Registered Mobile Number</p>
                        </div>
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
                                    <input type="text" name="district" class="w-full border-2 border-slate-100 p-4 bg-gray-50 font-bold" >
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
                                            <input type="radio" name="fee_type" value="normal" checked onchange="updateFee(100)" class="h-5 w-5 accent-orange-600">
                                            <span class="font-black text-navy text-xs uppercase">General (₹100)</span>
                                        </label>
                                        <label class="flex items-center gap-4 cursor-pointer bg-white p-4 border border-orange-100 shadow-sm">
                                            <input type="radio" name="fee_type" value="ration" onchange="updateFee(50)" class="h-5 w-5 accent-orange-600">
                                            <span class="font-black text-red-600 text-xs uppercase italic">Ration Card (₹50)</span>
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
                                        <p>I agree to abide by the SHYAMVIR DADDA SPORTS DEVELOPMENT TRUST Code of Conduct and Anti-Doping regulations.</p>
                                    </div>
                                </div>
                                <div class="mt-12 pt-10 border-t border-white/10">
                                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                                        <div class="text-center md:text-left">
                                            <span class="text-[10px] uppercase font-black tracking-widest text-orange-500">Payable Amount:</span>
                                            <h4 id="finalFee" class="text-6xl font-black tracking-tighter italic">₹100</h4>
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
    function validateStep1() {
        const aadhaar = document.getElementById('aadhaar_no').value;
        const status = document.getElementById('aadhaar_status');
        
        if(aadhaar.length !== 12 || isNaN(aadhaar)) {
            status.innerText = "Error: Aadhaar must be exactly 12 digits.";
            status.className = "text-[8px] font-black uppercase mt-1 block text-red-600";
            return false;
        }
        nextStep(2);
    }

    function calculateCategory() {
        const dobInput = document.getElementById('dob').value;
        if (!dobInput) return;

        const dob = new Date(dobInput);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) { age--; }
        
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
        rationUpload.classList.toggle('hidden', amount !== 50);
    }
</script>

<?php include('includes/footer.php'); ?>