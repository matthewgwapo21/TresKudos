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
        <a href="{{ auth()->check() ? route('recipes.index') : route('home') }}"
           class="brand text-2xl font-black text-gray-900">
            Tres<span class="text-orange-500">Kudos</span>
        </a>

        <!-- Right side -->
        <div class="flex items-center gap-3">
            @auth
                <!-- Notification bell -->
                <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications()->count())
                        <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold">
                            {{ auth()->user()->unreadNotifications()->count() > 9 ? '9+' : auth()->user()->unreadNotifications()->count() }}
                        </span>
                    @endif
                </a>

                <!-- Add Recipe button -->
                <a href="{{ route('recipes.create') }}"
                   class="btn-primary text-white text-sm font-medium px-5 py-2 rounded-xl hidden md:block">
                    + Add Recipe
                </a>

                <!-- User dropdown -->
                <div class="relative" id="user-menu">
                    <button onclick="toggleDropdown()"
                            class="flex items-center gap-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl px-3 py-2 transition">
                        @if(auth()->user()->avatar && str_starts_with(auth()->user()->avatar, 'http'))
                            <img src="{{ auth()->user()->avatar }}"
                                 class="w-6 h-6 rounded-full object-cover" alt="">
                        @else
                            <div class="w-6 h-6 rounded-full bg-orange-400 flex items-center justify-center text-xs font-black text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700 hidden md:block max-w-24 truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdown-menu"
                         class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">

                        <!-- User info -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    @if(auth()->user()->isPremium())
                                    <span class="bg-orange-100 text-orange-600 text-xs font-bold px-2 py-0.5 rounded-full">⭐ Premium</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <!-- Main links -->
                        <div class="py-1">
                            <a href="{{ route('recipes.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">🍽️</span> Browse Recipes
                            </a>
                            
                            <a href="{{ route('profile.show') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">👤</span> My Profile
                            </a>
                            <a href="{{ route('favorites.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">❤️</span> Favorites
                            </a>
                            <a href="{{ route('meal-plan.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">📅</span> Meal Plan
                            </a>
                            <a href="{{ route('shopping-list.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">🛒</span> Shopping List
                            </a>
                            <a href="{{ route('forum.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-orange-50 hover:text-orange-600 transition">
                                <span class="text-base">💬</span> Forum
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