<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TresKudos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        .food-bg {
            background-image:
                linear-gradient(to right, rgba(0,0,0,0.85) 40%, rgba(0,0,0,0.3) 100%),
                url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
        input:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.15); }
        .btn-login {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.2s;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(249,115,22,0.4); }
    </style>
</head>
<body class="min-h-screen food-bg flex">

    <!-- Left Panel — Branding -->
    <div class="hidden lg:flex flex-col justify-between w-1/2 p-16 text-white">
        <div>
            <a href="/" class="text-3xl font-black tracking-tight" style="font-family:'Playfair Display',serif;">
                TresKudos 🍽️
            </a>
        </div>
        <div>
            <h1 class="text-6xl font-black leading-tight mb-6">
                Every Recipe<br>Tells a<br><span class="text-orange-400">Story.</span>
            </h1>
            <p class="text-white/60 text-lg leading-relaxed max-w-sm">
                Discover, create, and share recipes from kitchens around the world. Your next favorite dish is waiting.
            </p>
        </div>
        <div class="flex gap-8 text-white/40 text-sm">
            <span>🍜 Hundreds of recipes</span>
            <span>👨‍🍳 Community chefs</span>
        </div>
    </div>

    <!-- Right Panel — Form -->
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">

            <!-- Mobile logo -->
            <div class="lg:hidden mb-8">
                <a href="/" class="text-2xl font-black text-orange-500" style="font-family:'Playfair Display',serif;">
                    TresKudos 🍽️
                </a>
            </div>

            <h2 class="text-3xl font-black text-gray-900 mb-2">Welcome back</h2>
            <p class="text-gray-400 text-sm mb-8">Sign in to access your recipes and favorites</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="you@example.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                   <div class="relative">
                            <input type="password" name="password" id="password" required
                                     placeholder="••••••••"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm pr-12 focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    </button>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="accent-orange-500">
                    <label for="remember" class="text-sm text-gray-500">Remember me</label>
                </div>
                <button type="submit" class="btn-login w-full text-white font-semibold py-3.5 rounded-xl text-sm">
                    Sign In →
                </button>
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-4 text-gray-400">or continue with</span>
                    </div>
                </div>
                <a href="{{ route('auth.google') }}"
                    class="mt-4 flex items-center justify-center gap-3 w-full border border-gray-200 hover:border-gray-300 text-gray-600 font-medium py-3 rounded-xl text-sm transition">
                     <svg width="18" height="18" viewBox="0 0 18 18">
                        <path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z"/>
                        <path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z"/>
                        <path fill="#FBBC05" d="M3.964 10.707c-.18-.54-.282-1.117-.282-1.707s.102-1.167.282-1.707V4.961H.957C.347 6.175 0 7.55 0 9s.348 2.826.957 4.039l3.007-2.332z"/>
                        <path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.961L3.964 7.293C4.672 5.166 6.656 3.58 9 3.58z"/>
                    </svg>
                        Continue with Google
                    </a>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-400">
                    New to TresKudos?
                    <a href="{{ route('register') }}" class="text-orange-500 font-medium hover:text-orange-600">Create an account</a>
                </p>
            </div>
        </div>
    </div>
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const eye = document.getElementById('eye-' + id);
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
</body>
</html>