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

        <!-- Logo -->
        <a href="{{ route('home') }}" class="brand text-2xl font-black text-gray-900">
            Tres<span class="text-orange-500">Kudos</span>
        </a>

        <!-- Center links -->
        <div class="hidden md:flex items-center gap-6">
            @auth
                <a href="{{ route('recipes.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 transition {{ request()->routeIs('recipes.*') ? 'text-gray-900 font-medium' : '' }}">
                    Browse
                </a>
                <a href="{{ route('search') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 transition {{ request()->routeIs('search') ? 'text-gray-900 font-medium' : '' }}">
                    Search
                </a>
                <a href="{{ route('meal-plan.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 transition {{ request()->routeIs('meal-plan.*') ? 'text-gray-900 font-medium' : '' }}">
                    Meal Plan
                </a>
                <a href="{{ route('shopping-list.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-900 transition {{ request()->routeIs('shopping-list.*') ? 'text-gray-900 font-medium' : '' }}">
                    Shopping List
                </a>
            @endauth
        </div>

        <!-- Right side -->
        <div class="flex items-center gap-3">
            @auth
                <!-- Add Recipe button -->
                <a href="{{ route('recipes.create') }}"
                   class="btn-primary text-white text-sm font-medium px-5 py-2 rounded-xl hidden md:block">
                    + Add Recipe
                </a>

                <!-- User dropdown -->
                <div class="relative" id="user-menu">
                    <button onclick="toggleDropdown()"
                            class="flex items-center gap-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl px-3 py-2 transition">
                        <!-- Avatar -->
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                 class="w-6 h-6 rounded-full object-cover" alt="">
                        @else
                            <div class="w-6 h-6 rounded-full bg-orange-400 flex items-center justify-center text-xs font-black text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700 hidden md:block max-w-24 truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <!-- Chevron -->
                        <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdown-menu"
                         class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">

                        <!-- User info -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Links -->
                        <div class="py-1">
                            <a href="{{ route('profile.show') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">👤</span> My Profile
                            </a>
                            <a href="{{ route('favorites.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">❤️</span> Favorites
                            </a>
                            <a href="{{ route('meal-plan.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition md:hidden">
                                <span class="text-base">📅</span> Meal Plan
                            </a>
                            <a href="{{ route('shopping-list.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition md:hidden">
                                <span class="text-base">🛒</span> Shopping List
                            </a>
                            <a href="{{ route('recipes.create') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition md:hidden">
                                <span class="text-base">➕</span> Add Recipe
                            </a>
                        </div>

                        @if(auth()->user()->isAdmin())
                            <div class="border-t border-gray-100 py-1">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-orange-600 hover:bg-orange-50 transition font-medium">
                                    <span class="text-base">⚙️</span> Admin Dashboard
                                </a>
                            </div>
                        @endif

                        <div class="border-t border-gray-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition">
                                    <span class="text-base">🚪</span> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="btn-primary text-white text-sm font-medium px-5 py-2 rounded-xl">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
function toggleDropdown() {
    document.getElementById('dropdown-menu').classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const menu = document.getElementById('user-menu');
    if (menu && !menu.contains(e.target)) {
        document.getElementById('dropdown-menu').classList.add('hidden');
    }
});
</script>

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