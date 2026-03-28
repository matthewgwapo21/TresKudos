<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TresKudos — Share & Discover Recipes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .brand { font-family: 'Playfair Display', serif; }
        .btn-primary { background: linear-gradient(135deg, #f97316, #ea580c); transition: all 0.2s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(249,115,22,0.4); }
        .hero-bg {
            background-image: linear-gradient(to right, rgba(0,0,0,0.75) 45%, rgba(0,0,0,0.2)),
                url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
        .card-hover { transition: all 0.3s; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp 0.8s ease forwards; }
        .fade-up-2 { animation: fadeUp 0.8s ease 0.2s forwards; opacity: 0; }
        .fade-up-3 { animation: fadeUp 0.8s ease 0.4s forwards; opacity: 0; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="absolute top-0 left-0 right-0 z-50 px-6 py-5 flex items-center justify-between max-w-7xl mx-auto">
        <a href="/" class="brand text-2xl font-black text-white">
            Tres<span class="text-orange-400">Kudos</span>
        </a>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm transition">Login</a>
            <a href="{{ route('register') }}"
               class="btn-primary text-white text-sm font-medium px-5 py-2.5 rounded-xl">
                Get Started
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-bg min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-6 py-32">
            <div class="max-w-2xl">
                <p class="text-orange-400 font-medium text-sm uppercase tracking-widest mb-4 fade-up">
                    Community Recipe Database
                </p>
                <h1 class="brand text-6xl lg:text-7xl font-black text-white leading-tight mb-6 fade-up-2">
                    Every Recipe<br>Tells a<br><span class="text-orange-400">Story.</span>
                </h1>
                <p class="text-white/60 text-xl leading-relaxed mb-10 fade-up-3">
                    Discover, create, and share recipes from kitchens around the world.
                    Plan your meals, build your shopping list, and connect with food lovers.
                </p>
                <div class="flex flex-wrap gap-4 fade-up-3">
                    <a href="{{ route('register') }}"
                       class="btn-primary text-white font-semibold px-8 py-4 rounded-xl text-base">
                        Start Cooking →
                    </a>
                    <a href="{{ route('login') }}"
                       class="bg-white/10 hover:bg-white/20 text-white font-medium px-8 py-4 rounded-xl text-base transition backdrop-blur-sm">
                        Sign In
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex gap-10 mt-16 fade-up-3">
                    <div>
                        <p class="text-3xl font-black text-white">{{ $totalRecipes }}+</p>
                        <p class="text-white/40 text-sm">Recipes</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white">{{ $totalUsers }}+</p>
                        <p class="text-white/40 text-sm">Chefs</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white">{{ $totalCategories }}+</p>
                        <p class="text-white/40 text-sm">Categories</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <p class="text-orange-500 font-medium text-sm uppercase tracking-widest mb-3">About TresKudos</p>
                    <h2 class="brand text-5xl font-black text-gray-900 leading-tight mb-6">
                        A place for<br>food lovers to<br><span class="text-orange-500">connect.</span>
                    </h2>
                    <p class="text-gray-500 text-lg leading-relaxed mb-6">
                        TresKudos is a community-driven recipe database where anyone can submit their favorite dishes,
                        discover new ones, and plan their weekly meals — all in one place.
                    </p>
                    <p class="text-gray-500 leading-relaxed">
                        Whether you're a seasoned chef or a beginner in the kitchen, TresKudos gives you the tools
                        to explore flavors, organize your cooking, and share your culinary passion with the world.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?w=400&q=80"
                         class="rounded-2xl h-48 w-full object-cover" alt="">
                    <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=400&q=80"
                         class="rounded-2xl h-48 w-full object-cover mt-8" alt="">
                    <img src="https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=400&q=80"
                         class="rounded-2xl h-48 w-full object-cover" alt="">
                    <img src="https://images.unsplash.com/photo-1466637574441-749b8f19452f?w=400&q=80"
                         class="rounded-2xl h-48 w-full object-cover mt-8" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <p class="text-orange-500 font-medium text-sm uppercase tracking-widest mb-3">Features</p>
                <h2 class="brand text-5xl font-black text-gray-900">Everything you need</h2>
                <p class="text-gray-400 mt-4 text-lg">One platform for all your cooking needs</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="text-4xl mb-4">🍽️</div>
                    <h3 class="brand text-xl font-black text-gray-900 mb-2">Browse Recipes</h3>
                    <p class="text-gray-500 leading-relaxed">Explore hundreds of recipes across all categories — breakfast, lunch, dinner, desserts and more.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="text-4xl mb-4">✍️</div>
                    <h3 class="brand text-xl font-black text-gray-900 mb-2">Submit Recipes</h3>
                    <p class="text-gray-500 leading-relaxed">Share your own recipes with the community. Add ingredients, steps, photos and more.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="text-4xl mb-4">❤️</div>
                    <h3 class="brand text-xl font-black text-gray-900 mb-2">Save Favorites</h3>
                    <p class="text-gray-500 leading-relaxed">Bookmark recipes you love and access them anytime from your personal favorites list.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="text-4xl mb-4">📅</div>
                    <h3 class="brand text-xl font-black text-gray-900 mb-2">Meal Planner</h3>
                    <p class="text-gray-500 leading-relaxed">Plan your breakfast, lunch, and dinner for the whole week in one simple view.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="text-4xl mb-4">🛒</div>
                    <h3 class="brand text-xl font-black text-gray-900 mb-2">Shopping List</h3>
                    <p class="text-gray-500 leading-relaxed">Auto-generate a shopping list from your weekly meal plan. Check off items as you shop.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="text-4xl mb-4">⭐</div>
                    <h3 class="brand text-xl font-black text-gray-900 mb-2">Rate & Review</h3>
                    <p class="text-gray-500 leading-relaxed">Leave star ratings and reviews on recipes. See what the community thinks before you cook.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Recipes -->
    @if($latestRecipes->count())
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <p class="text-orange-500 font-medium text-sm uppercase tracking-widest mb-2">Fresh from the community</p>
                    <h2 class="brand text-4xl font-black text-gray-900">Latest Recipes</h2>
                </div>
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-medium text-sm">
                    View all →
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestRecipes as $recipe)
                    <div class="bg-gray-50 rounded-2xl overflow-hidden card-hover border border-gray-100">
                        @php
                            $imgUrl = $recipe->image
                                ? (str_starts_with($recipe->image, 'http') ? $recipe->image : asset('storage/' . $recipe->image))
                                : null;
                        @endphp
                        @if($imgUrl)
                            <div class="overflow-hidden h-48">
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="{{ $recipe->title }}">
                            </div>
                        @else
                            <div class="h-48 bg-orange-50 flex items-center justify-center text-5xl">🍽️</div>
                        @endif
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">{{ $recipe->title }}</h3>
                            <p class="text-gray-400 text-sm line-clamp-2 mb-3">{{ $recipe->description }}</p>
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                @if($recipe->prep_time || $recipe->cook_time)
                                    <span>⏱ {{ $recipe->prep_time + $recipe->cook_time }} min</span>
                                @endif
                                @if($recipe->category)
                                    <span class="bg-orange-50 text-orange-500 px-2.5 py-1 rounded-full font-medium">
                                        {{ $recipe->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Banner -->
    <section class="py-24 bg-orange-500">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="brand text-5xl font-black text-white mb-6">
                Ready to start cooking?
            </h2>
            <p class="text-orange-100 text-xl mb-10 leading-relaxed">
                Join thousands of food lovers on TresKudos. It's free and always will be.
            </p>
            <a href="{{ route('register') }}"
               class="inline-block bg-white text-orange-500 font-bold px-10 py-4 rounded-xl text-lg hover:bg-orange-50 transition">
                Create Free Account →
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div class="md:col-span-2">
                    <a href="/" class="brand text-2xl font-black text-white">
                        Tres<span class="text-orange-400">Kudos</span>
                    </a>
                    <p class="text-gray-400 mt-3 leading-relaxed max-w-sm">
                        A community recipe database for food lovers. Discover, share, and plan your meals.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Navigate</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-orange-400 transition">Browse Recipes</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-orange-400 transition">Submit Recipe</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-orange-400 transition">Meal Planner</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Account</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-orange-400 transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-orange-400 transition">Register</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex items-center justify-between">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} TresKudos. All rights reserved.</p>
                <p class="text-gray-600 text-sm">Built with Laravel 12 🍽️</p>
            </div>
        </div>
    </footer>

</body>
</html>