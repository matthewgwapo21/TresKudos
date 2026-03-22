<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — TresKudos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        .food-bg {
            background-image:
                linear-gradient(to right, rgba(0,0,0,0.85) 40%, rgba(0,0,0,0.3) 100%),
                url('https://images.unsplash.com/photo-1543353071-873f17a7a088?w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
        input:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.15); }
        .btn-register {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.2s;
        }
        .btn-register:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(249,115,22,0.4); }
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
                Share Your<br>Culinary<br><span class="text-orange-400">Magic.</span>
            </h1>
            <p class="text-white/60 text-lg leading-relaxed max-w-sm">
                Join our community of food lovers. Submit your own recipes, discover new favorites, and connect with chefs worldwide.
            </p>
        </div>
        <div class="flex gap-8 text-white/40 text-sm">
            <span>🥘 Share recipes</span>
            <span>❤️ Save favorites</span>
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

            <h2 class="text-3xl font-black text-gray-900 mb-2">Create account</h2>
            <p class="text-gray-400 text-sm mb-8">Start your culinary journey today</p>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Juan dela Cruz"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="you@example.com"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           placeholder="At least 6 characters"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm password</label>
                    <input type="password" name="password_confirmation" required
                           placeholder="••••••••"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm transition-all">
                </div>
                <button type="submit" class="btn-register w-full text-white font-semibold py-3.5 rounded-xl text-sm mt-2">
                    Create Account →
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-orange-500 font-medium hover:text-orange-600">Sign in</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>