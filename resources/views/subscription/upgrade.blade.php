@extends('layouts.app')
@section('title', 'Upgrade to Premium — TresKudos')

@section('content')
<div class="max-w-4xl mx-auto">

    @if(session('warning'))
        <div class="bg-orange-50 border border-orange-200 text-orange-700 px-4 py-3 rounded-xl mb-6 text-sm">
            🔒 {{ session('warning') }}
        </div>
    @endif

    <!-- Hero -->
    <div class="text-center mb-12">
        <span class="bg-orange-100 text-orange-600 text-sm font-semibold px-4 py-1.5 rounded-full">
            ⭐ Premium
        </span>
        <h1 class="brand text-5xl font-black text-gray-900 mt-4 mb-3">
            Unlock the Full<br><span class="text-orange-500">TresKudos</span> Experience
        </h1>
        <p class="text-gray-400 text-lg max-w-xl mx-auto">
            Get access to Meal Planner and Shopping List for just ₱99/month
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

        <!-- Free plan -->
        <div class="bg-white rounded-2xl border border-gray-200 p-8">
            <h2 class="font-black text-2xl text-gray-900 mb-1">Free</h2>
            <p class="text-gray-400 text-sm mb-6">Everything to get started</p>
            <p class="text-4xl font-black text-gray-900 mb-6">₱0 <span class="text-lg font-normal text-gray-400">/month</span></p>
            <ul class="space-y-3 text-sm text-gray-600">
                @foreach(['Browse all recipes', 'Submit your own recipes', 'Search & filter', 'Favorites', 'Reviews & comments', 'Community forum'] as $feature)
                    <li class="flex items-center gap-2">
                        <span class="text-green-500 font-bold">✓</span> {{ $feature }}
                    </li>
                @endforeach
                @foreach(['Meal Planner', 'Shopping List'] as $locked)
                    <li class="flex items-center gap-2 text-gray-300">
                        <span class="text-gray-300">✕</span> {{ $locked }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Premium plan -->
        <div class="bg-orange-500 rounded-2xl p-8 text-white relative overflow-hidden">
            <div class="absolute top-4 right-4 bg-white text-orange-500 text-xs font-bold px-3 py-1 rounded-full">
                RECOMMENDED
            </div>
            <h2 class="font-black text-2xl mb-1">Premium</h2>
            <p class="text-orange-100 text-sm mb-6">Everything you need</p>
            <p class="text-4xl font-black mb-6">₱99 <span class="text-lg font-normal text-orange-200">/month</span></p>
            <ul class="space-y-3 text-sm">
                @foreach(['Browse all recipes', 'Submit your own recipes', 'Search & filter', 'Favorites', 'Reviews & comments', 'Community forum', 'Meal Planner', 'Shopping List'] as $feature)
                    <li class="flex items-center gap-2">
                        <span class="font-bold">✓</span> {{ $feature }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Payment form -->
    <div class="bg-white rounded-2xl border border-gray-100 p-8 max-w-md mx-auto">
        <h2 class="brand text-2xl font-black text-gray-900 mb-2">Payment Details</h2>
        <p class="text-gray-400 text-sm mb-6">
            🔒 Demo payment — use any fake card details
            <br>
            <span class="text-orange-500 font-medium">Try: 4242 4242 4242 4242</span>
        </p>

        <form method="POST" action="{{ route('subscription.pay') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cardholder Name</label>
                <input type="text" name="name" required placeholder="Juan dela Cruz"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Card Number</label>
                <input type="text" name="card_number" required placeholder="4242 4242 4242 4242"
                       maxlength="19"
                       oninput="formatCard(this)"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition font-mono">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Expiry Date</label>
                    <input type="text" name="expiry" required placeholder="MM/YY"
                           maxlength="5"
                           oninput="formatExpiry(this)"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition font-mono">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">CVV</label>
                    <input type="text" name="cvv" required placeholder="123"
                           maxlength="4"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition font-mono">
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit"
                    class="btn-primary w-full text-white font-semibold py-4 rounded-xl text-sm">
                Pay ₱99/month →
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-4">
            Cancel anytime from your profile settings
        </p>
    </div>
</div>

<script>
function formatCard(input) {
    let value = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = value.replace(/(.{4})/g, '$1 ').trim();
}

function formatExpiry(input) {
    let value = input.value.replace(/\D/g, '').substring(0, 4);
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2);
    }
    input.value = value;
}
</script>
@endsection