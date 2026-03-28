<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TresKudos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #fafaf8; }
        .brand { font-family: 'Playfair Display', serif; }
        .btn-primary {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.2s;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(249,115,22,0.35); }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="brand text-2xl font-black text-gray-900">
                Tres<span class="text-orange-500">Kudos</span>
            </a>
            <div class="flex items-center gap-6">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-xs font-semibold uppercase tracking-widest text-orange-500 hover:text-orange-600">
                            Admin
                        </a>
                    @endif
                    <a href="{{ route('recipes.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Browse</a>
                    <a href="{{ route('favorites.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Favorites</a>
                    <a href="{{ route('meal-plan.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Meal Plan</a>
                    <a href="{{ route('shopping-list.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Shopping List</a>
                    <a href="{{ route('recipes.create') }}"
                       class="btn-primary text-white text-sm font-medium px-5 py-2 rounded-xl">
                        + Add Recipe
                    </a>
                    <a href="{{ route('profile.show') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">
                    {{ auth()->user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-400 hover:text-red-500 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Login</a>
                    <a href="{{ route('register') }}"
                       class="btn-primary text-white text-sm font-medium px-5 py-2 rounded-xl">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-4 w-full">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-7xl mx-auto px-6 mt-4 w-full">
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-6 py-10 flex-1 w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
            <span class="brand text-xl font-black text-gray-900">Tres<span class="text-orange-500">Kudos</span></span>
            <span class="text-sm text-gray-400">&copy; {{ date('Y') }} TresKudos. All rights reserved.</span>
        </div>
    </footer>

</body>
</html>