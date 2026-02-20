<?php include('includes/header.php'); ?>

<section class="bg-navy py-20 border-b-8 border-orange-600">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-black italic text-white uppercase tracking-tighter">
            Event <span class="text-orange-500">Specifications</span>
        </h1>
        <p class="text-gray-400 mt-4 font-bold uppercase text-[10px] tracking-[0.3em]">Official AFI & International Standards</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="lg:w-1/3 space-y-4">
                <h2 class="text-2xl font-black text-navy italic mb-8 uppercase">Select <span class="text-orange-600">Phase</span></h2>
                
                <button onclick="showSpec('grassroots')" class="spec-btn active-spec" id="btn-grassroots">
                    <span class="text-2xl">01</span>
                    <div class="text-left">
                        <p class="font-black text-lg uppercase italic">Grassroots</p>
                        <p class="text-[10px] font-bold opacity-70">AGES Under-4 — Under-10</p>
                    </div>
                </button>

                <button onclick="showSpec('junior')" class="spec-btn" id="btn-junior">
                    <span class="text-2xl">02</span>
                    <div class="text-left">
                        <p class="font-black text-lg uppercase italic">Junior Development</p>
                        <p class="text-[10px] font-bold opacity-70">AGES Under-12 — Under-16</p>
                    </div>
                </button>

                <button onclick="showSpec('elite')" class="spec-btn" id="btn-elite">
                    <span class="text-2xl">03</span>
                    <div class="text-left">
                        <p class="font-black text-lg uppercase italic">Elite & Pro</p>
                        <p class="text-[10px] font-bold opacity-70">AGES Under-18 — Senior/U23</p>
                    </div>
                </button>
            </div>

            <div class="lg:w-2/3 bg-slate-50 p-8 border-2 border-slate-100 rounded-sm">
                
                <div id="grassroots" class="spec-content animate__animated animate__fadeIn">
                    <h3 class="text-3xl font-black text-navy mb-6 italic uppercase underline decoration-orange-500 underline-offset-8">Phase 01: Grassroots</h3>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="bg-white p-4 shadow-sm border-l-4 border-green-500">
                                <h4 class="font-black text-navy uppercase text-sm">Under-4 to Under-6 (Toddlers)</h4>
                                <p class="text-[10px] text-gray-500 font-bold mb-3">FOCUS: MOVEMENT EDUCATION</p>
                                <ul class="text-xs space-y-2 font-bold text-gray-700">
                                    <li>• Animal Runs (Rabbit, Frog, Duck)</li>
                                    <li>• 5m-20m "Run to Parent" Games</li>
                                    <li>• Foam Ball / Bucket Target Throws</li>
                                    <li>• Balance: Hoop Step-in & One-leg Balance</li>
                                </ul>
                            </div>
                            <div class="bg-white p-4 shadow-sm border-l-4 border-green-500">
                                <h4 class="font-black text-navy uppercase text-sm">Under-8 to Under-10 (Kids)</h4>
                                <p class="text-[10px] text-gray-500 font-bold mb-3">FOCUS: COORDINATION</p>
                                <ul class="text-xs space-y-2 font-bold text-gray-700">
                                    <li>• Sprints: 30m, 40m, 50m, 60m</li>
                                    <li>• Hurdles: 30cm - 45cm (Soft Plastic)</li>
                                    <li>• Throws: Tennis Ball & Foam Javelin (250g)</li>
                                    <li>• Jumping: Standing Long Jump</li>
                                </ul>
                            </div>
                        </div>
                        <div class="bg-navy p-6 text-white rounded-sm">
                            <h4 class="font-black uppercase text-orange-500 text-xs mb-4">Safety & Philosophy</h4>
                            <p class="text-xs leading-relaxed font-bold opacity-80">
                                Strictly No Starting Blocks. No Spikes. Focus on participation certificates rather than timing pressure. 1-2 events maximum per child.
                            </p>
                            
                        </div>
                    </div>
                </div>

                <div id="junior" class="spec-content hidden animate__animated animate__fadeIn">
                    <h3 class="text-3xl font-black text-navy mb-6 italic uppercase underline decoration-orange-500 underline-offset-8">Phase 02: Junior Development</h3>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div class="bg-white p-5 border-l-4 border-blue-500 shadow-sm">
                                <h4 class="font-black text-navy uppercase">U12 - U14 (NIDJAM Focus)</h4>
                                <ul class="text-xs font-bold text-gray-600 mt-3 space-y-2">
                                    <li>• Events: 60m, 600m, 80m Hurdles</li>
                                    <li>• High Jump: <span class="text-orange-600">Scissor Kick Only</span></li>
                                    <li>• Shot Put: 2kg (U12) / 3kg (U14)</li>
                                    <li>• Special: Triathlon A, B, and C</li>
                                </ul>
                            </div>
                            <div class="bg-white p-5 border-l-4 border-blue-500 shadow-sm">
                                <h4 class="font-black text-navy uppercase">Under-16 (National Level)</h4>
                                <ul class="text-xs font-bold text-gray-600 mt-3 space-y-2">
                                    <li>• Runs: 100m, 200m, 400m, 800m, 2000m</li>
                                    <li>• Throws: Shot (4kg), Discus (1.25kg), Javelin (600g)</li>
                                    <li>• Jumping: Long Jump, High Jump, Hammer</li>
                                    <li>• Combined: Pentathlon Events</li>
                                </ul>
                            </div>
                        </div>
                        <div class="border-2 border-dashed border-blue-200 p-6">
                            <h4 class="text-xs font-black text-blue-600 uppercase mb-4">AFI Competition Rules</h4>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-tighter">
                                Transition phase from Standing Start to Starting Blocks. Increased technical focus on "Medley Relays" and multi-event endurance.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="elite" class="spec-content hidden animate__animated animate__fadeIn">
                    <h3 class="text-3xl font-black text-navy mb-6 italic uppercase underline decoration-orange-500 underline-offset-8">Phase 03: Elite Performance</h3>
                    
                    <div class="bg-white overflow-x-auto p-4 shadow-xl">
                        <table class="w-full text-left text-[11px] font-black uppercase tracking-tighter">
                            <thead class="bg-navy text-white">
                                <tr>
                                    <th class="p-3">Event Type</th>
                                    <th class="p-3">U18 Youth</th>
                                    <th class="p-3">U20 Junior</th>
                                    <th class="p-3">Senior / U23</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <tr class="border-b">
                                    <td class="p-3 bg-slate-50 font-black text-orange-600">Shot Put</td>
                                    <td class="p-3">5kg (B) / 3kg (G)</td>
                                    <td class="p-3">6kg (M) / 4kg (W)</td>
                                    <td class="p-3 text-navy">7.26kg / 4kg</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="p-3 bg-slate-50 font-black text-orange-600">Discus</td>
                                    <td class="p-3">1.5kg / 1kg</td>
                                    <td class="p-3">1.75kg / 1kg</td>
                                    <td class="p-3 text-navy">2.0kg / 1.0kg</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="p-3 bg-slate-50 font-black text-orange-600">Steeple</td>
                                    <td class="p-3">2000m</td>
                                    <td class="p-3">3000m</td>
                                    <td class="p-3 text-navy">3000m (Full)</td>
                                </tr>
                                <tr>
                                    <td class="p-3 bg-slate-50 font-black text-orange-600">Combined</td>
                                    <td class="p-3">Decathlon (Modified)</td>
                                    <td class="p-3">Decathlon</td>
                                    <td class="p-3 text-navy">Deca / Hepta</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 grid grid-cols-3 gap-4">
                         <div class="p-3 bg-orange-600 text-white text-center rounded">
                             <p class="text-[10px] font-black uppercase">Standard Hurdles</p>
                             <p class="font-bold text-xs mt-1">110mH / 400mH</p>
                         </div>
                         <div class="p-3 bg-navy text-white text-center rounded">
                             <p class="text-[10px] font-black uppercase">Relay Formats</p>
                             <p class="font-bold text-xs mt-1">4x100 / 4x400 Mixed</p>
                         </div>
                         <div class="p-3 bg-slate-200 text-navy text-center rounded">
                             <p class="text-[10px] font-black uppercase">Endurance</p>
                             <p class="font-bold text-xs mt-1">5000m / 10000m</p>
                         </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
    .spec-btn {
        @apply w-full flex items-center gap-6 p-6 border-2 border-slate-100 transition-all hover:bg-slate-50;
    }
    .active-spec {
        @apply border-orange-500 bg-white shadow-lg translate-x-2;
    }
    .active-spec span { @apply text-orange-600; }
</style>

<script>
function showSpec(id) {
    // Hide all contents
    document.querySelectorAll('.spec-content').forEach(content => content.classList.add('hidden'));
    // Show selected
    document.getElementById(id).classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.spec-btn').forEach(btn => btn.classList.remove('active-spec'));
    document.getElementById('btn-' + id).classList.add('active-spec');
}
</script>

<?php include('includes/footer.php'); ?>