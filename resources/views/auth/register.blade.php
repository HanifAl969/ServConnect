<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Join ServeConnect - Create Your Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@400;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9f9ff; }
        h1, h2, .font-display { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="min-h-screen flex items-stretch">

<div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[#003fb1] items-center justify-center p-16">
    <div class="absolute inset-0 z-0">
        <img alt="Professional team" class="w-full h-full object-cover opacity-30 mix-blend-overlay" src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop"/>
    </div>
    <div class="absolute inset-0 bg-gradient-to-br from-[#003fb1] via-[#003fb1]/80 to-[#006c4a]/40 z-10"></div>
    
    <div class="relative z-20 text-white max-w-lg">
        <div class="mb-8">
            <span class="text-[#85f8c4] font-bold bg-white/10 px-4 py-2 rounded-lg border border-white/20">ServeConnect</span>
        </div>
        <h1 class="text-5xl font-extrabold mb-6 leading-tight text-white">Join ServeConnect</h1>
        <p class="text-lg opacity-90 leading-relaxed text-blue-100">Start your journey to professional excellence. Connect with elite service providers or expand your business reach in our premium marketplace.</p>
        
        <div class="mt-12 grid grid-cols-2 gap-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-[#85f8c4]" style="font-variation-settings: 'FILL' 1;">verified</span>
                <span class="font-bold text-sm">Verified Pros</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-[#85f8c4]" style="font-variation-settings: 'FILL' 1;">security</span>
                <span class="font-bold text-sm">Secure Escrow</span>
            </div>
        </div>
    </div>
</div>

<main class="w-full lg:w-1/2 bg-white flex flex-col justify-center items-center p-8 md:p-16 overflow-y-auto">
    <div class="w-full max-w-[440px] py-8">
        
        <div class="lg:hidden mb-8 flex flex-col items-center text-center">
            <h2 class="text-3xl font-extrabold text-[#003fb1] mb-1">ServeConnect</h2>
            <p class="text-gray-500">Join the professional network</p>
        </div>

        <div class="mb-10 text-center lg:text-left">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Create Account</h2>
            <p class="text-gray-500">Set up your profile to start exploring services.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1" for="name">Full Name</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">person</span>
                    <input name="name" id="name" type="text" value="{{ old('name') }}" required autofocus
                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="Enter your full name"/>
                </div>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1" for="email">Email Address</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">mail</span>
                    <input name="email" id="email" type="email" value="{{ old('email') }}" required
                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="name@company.com"/>
                </div>
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1" for="password">Password</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">lock</span>
                    <input name="password" id="password" type="password" required
                           class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="Min. 8 characters"/>
                </div>
                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1" for="password_confirmation">Confirm Password</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">lock_reset</span>
                    <input name="password_confirmation" id="password_confirmation" type="password" required
                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="Repeat your password"/>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Daftar Sebagai</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#003fb1] transition-all has-[:checked]:bg-blue-50 has-[:checked]:border-[#003fb1]">
                        <input type="radio" name="role" value="user" checked class="text-[#003fb1] focus:ring-[#003fb1]">
                        <div>
                            <span class="font-semibold text-sm">User</span>
                            <p class="text-xs text-gray-400">Cari jasa</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#003fb1] transition-all has-[:checked]:bg-blue-50 has-[:checked]:border-[#003fb1]">
                        <input type="radio" name="role" value="vendor" class="text-[#003fb1] focus:ring-[#003fb1]">
                        <div>
                            <span class="font-semibold text-sm">Vendor</span>
                            <p class="text-xs text-gray-400">Tawarkan jasa</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- KTP Upload (User) --}}
            <div id="ktp-section" class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Foto KTP</label>
                <p class="text-xs text-gray-400 ml-1 mb-2">Lampirkan foto KTP Anda untuk verifikasi identitas.</p>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">badge</span>
                    <input name="ktp_photo" id="ktp_photo" type="file" accept="image/jpg,image/jpeg,image/png"
                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003fb1] file:text-white hover:file:bg-blue-700"/>
                </div>
                <div id="ktp-preview" class="hidden mt-2">
                    <img id="ktp-preview-img" class="max-h-40 rounded-lg border border-gray-200" />
                </div>
                @error('ktp_photo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Vendor Type + Certificates (Vendor) --}}
            <div id="vendor-section" class="space-y-6 hidden">

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Tipe Vendor</label>
                    <p class="text-xs text-gray-400 ml-1 mb-2">Pilih tipe vendor Anda.</p>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#003fb1] transition-all has-[:checked]:bg-blue-50 has-[:checked]:border-[#003fb1]">
                            <input type="radio" name="vendor_type" value="umkm" class="text-[#003fb1] focus:ring-[#003fb1]">
                            <div>
                                <span class="font-semibold text-sm">UMKM</span>
                                <p class="text-xs text-gray-400">Usaha kecil/menengah</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#003fb1] transition-all has-[:checked]:bg-blue-50 has-[:checked]:border-[#003fb1]">
                            <input type="radio" name="vendor_type" value="enterprise" class="text-[#003fb1] focus:ring-[#003fb1]">
                            <div>
                                <span class="font-semibold text-sm">Perusahaan</span>
                                <p class="text-xs text-gray-400">Bersertifikat resmi</p>
                            </div>
                        </label>
                    </div>
                    @error('vendor_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Sertifikat Kompetensi</label>
                    <p class="text-xs text-gray-400 ml-1 mb-2">Lampirkan sertifikat kompetensi (BNSP, dll). Minimal 1.</p>
                    <div id="certificates-container" class="space-y-3">
                        <div class="certificate-item relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">assignment</span>
                            <input type="file" name="certificates[]" accept="image/jpg,image/jpeg,image/png"
                                   class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003fb1] file:text-white hover:file:bg-blue-700"/>
                        </div>
                    </div>
                    <button type="button" id="add-certificate-btn"
                            class="mt-2 text-sm text-[#003fb1] font-semibold hover:text-blue-700 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        Tambah Sertifikat
                    </button>
                    <div id="certificates-preview" class="grid grid-cols-3 gap-2 mt-2"></div>
                    @error('certificates') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    @error('certificates.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-[#003fb1] text-white rounded-xl font-bold text-lg shadow-lg shadow-blue-100 active:scale-[0.98] transition-all hover:bg-blue-700">
                Create Account
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 font-medium">
                Already have an account? 
                <a class="text-[#003fb1] font-bold hover:underline ml-1" href="{{ route('login') }}">Sign In</a>
            </p>
        </div>

        <footer class="mt-12 pt-8 w-full border-t border-gray-100">
            <div class="flex justify-between items-center text-xs text-gray-400 font-bold uppercase tracking-widest">
                <span>© 2026 ServeConnect</span>
                <div class="flex gap-4">
                    <a class="hover:text-[#003fb1] transition-colors" href="#">Help</a>
                    <a class="hover:text-[#003fb1] transition-colors" href="#">Privacy</a>
                </div>
            </div>
        </footer>
    </div>
</main>
<script>
(function() {
    const roleRadios = document.querySelectorAll('input[name="role"]');
    const ktpSection = document.getElementById('ktp-section');
    const vendorSection = document.getElementById('vendor-section');
    const ktpInput = document.getElementById('ktp_photo');
    const ktpPreview = document.getElementById('ktp-preview');
    const ktpPreviewImg = document.getElementById('ktp-preview-img');
    const container = document.getElementById('certificates-container');
    const addBtn = document.getElementById('add-certificate-btn');
    const certsPreview = document.getElementById('certificates-preview');

    function toggleSections(role) {
        ktpSection.classList.toggle('hidden', role !== 'user');
        vendorSection.classList.toggle('hidden', role !== 'vendor');
        if (role === 'user') {
            document.querySelectorAll('[name="vendor_type"]').forEach(r => r.checked = false);
        }
    }

    roleRadios.forEach(r => r.addEventListener('change', function() {
        toggleSections(this.value);
    }));
    toggleSections(document.querySelector('input[name="role"]:checked')?.value || 'user');

    ktpInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                ktpPreview.classList.remove('hidden');
                ktpPreviewImg.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    let certIndex = 1;

    addBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'certificate-item relative group';
        div.innerHTML =
            '<span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 group-focus-within:text-[#003fb1] transition-colors">assignment</span>' +
            '<input type="file" name="certificates[]" accept="image/jpg,image/jpeg,image/png" class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003fb1] file:text-white hover:file:bg-blue-700"/>';
        container.appendChild(div);
        certIndex++;

        div.querySelector('input').addEventListener('change', function() {
            previewCertificate(this);
        });
    });

    document.querySelectorAll('input[name="certificates[]"]').forEach(function(input) {
        input.addEventListener('change', function() {
            previewCertificate(this);
        });
    });

    function previewCertificate(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const idx = Array.from(container.querySelectorAll('input')).indexOf(input);
            reader.onload = function(e) {
                let img = certsPreview.querySelectorAll('img')[idx];
                if (!img) {
                    img = document.createElement('img');
                    img.className = 'h-20 w-20 object-cover rounded-lg border border-gray-200';
                    certsPreview.appendChild(img);
                }
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
})();
</script>
</body>
</html>