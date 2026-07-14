<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login | ServeConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, .font-display { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27] antialiased overflow-hidden">
<main class="min-h-screen flex flex-col md:flex-row">
    
    <section class="hidden md:flex md:w-1/2 lg:w-3/5 relative overflow-hidden bg-[#003fb1]">
        <div class="absolute inset-0 z-10 bg-gradient-to-tr from-[#003fb1]/90 to-transparent"></div>
        <img alt="Professional team" class="absolute inset-0 w-full h-full object-cover" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976&auto=format&fit=crop"/>
        
        <div class="relative z-20 flex flex-col justify-between h-full p-16 text-white">
            <div>
                <h1 class="text-5xl font-extrabold tracking-tight mb-6">ServeConnect</h1>
                <p class="text-xl max-w-md opacity-90 leading-relaxed">Connecting world-class expertise with global demand. Your journey to professional excellence starts here.</p>
            </div>
            <div class="space-y-8">
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                    <div class="w-12 h-12 bg-[#006c4a] rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">verified</span>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Trusted Network</p>
                        <p class="text-xs opacity-80">Access over 50,000+ verified professionals worldwide.</p>
                    </div>
                </div>
                <p class="text-xs opacity-60">© 2026 ServeConnect. All rights reserved.</p>
            </div>
        </div>
    </section>

    <section class="w-full md:w-1/2 lg:w-2/5 bg-white flex flex-col justify-center items-center px-8 py-12 overflow-y-auto">
        <div class="w-full max-w-md">
            <div class="md:hidden mb-10 text-center">
                <h1 class="text-3xl font-extrabold text-[#003fb1]">ServeConnect</h1>
            </div>

            <header class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-extrabold text-gray-900">Sign In</h2>
                <p class="text-gray-500 mt-2">Welcome back! Please enter your details.</p>
            </header>

            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-xl border border-green-100">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-xl border border-green-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700" for="email">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#003fb1] transition-colors">mail</span>
                        <input name="email" id="email" type="email" value="{{ old('email') }}" required autofocus 
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all placeholder:text-gray-400 text-sm" 
                            placeholder="name@example.com"/>
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-bold text-gray-700" for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-[#003fb1] hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#003fb1] transition-colors">lock</span>
                        <input name="password" id="password" type="password" required 
                            class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all placeholder:text-gray-400 text-sm" 
                            placeholder="••••••••"/>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-300 text-[#003fb1] shadow-sm focus:ring-[#003fb1]">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600 font-medium">Remember this device</label>
                </div>

                <button type="submit" class="w-full py-4 bg-[#003fb1] text-white font-bold rounded-xl shadow-lg shadow-blue-100 hover:shadow-blue-200 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    Sign In
                </button>
            </form>

            <div class="relative flex items-center py-8">
                <div class="flex-grow border-t border-gray-100"></div>
                <span class="flex-shrink mx-4 text-xs text-gray-400 font-bold uppercase tracking-widest">or</span>
                <div class="flex-grow border-t border-gray-100"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <button class="flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all font-bold text-xs text-gray-700">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4" alt="Google"> Google
                </button>
                <button class="flex items-center justify-center gap-2 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all font-bold text-xs text-gray-700">
                    <img src="https://www.svgrepo.com/show/475635/apple-color.svg" class="w-4 h-4" alt="Apple"> Apple
                </button>
            </div>

            <footer class="mt-10 text-center">
                <p class="text-sm text-gray-500 font-medium">New to ServeConnect? 
                    <a class="text-[#003fb1] font-bold hover:underline ml-1" href="{{ route('register') }}">Create Account</a>
                </p>
            </footer>
        </div>
    </section>
</main>
</body>
</html>