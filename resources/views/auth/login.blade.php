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
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm transition-all">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="accent-orange-500">
                    <label for="remember" class="text-sm text-gray-500">Remember me</label>
                </div>
                <button type="submit" class="btn-login w-full text-white font-semibold py-3.5 rounded-xl text-sm">
                    Sign In →
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-400">
                    New to TresKudos?
                    <a href="{{ route('register') }}" class="text-orange-500 font-medium hover:text-orange-600">Create an account</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>