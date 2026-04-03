@extends('layouts.app')
@section('title', 'Statistics — Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="brand text-3xl font-black text-gray-900">Monthly <span class="text-orange-500">Statistics</span></h1>
        <p class="text-gray-400 text-sm mt-1">Last 6 months overview</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

<!-- Summary cards -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
    @php
        $totals = [
            'New Users'    => array_sum(array_column($months, 'users')),
            'New Recipes'  => array_sum(array_column($months, 'recipes')),
            'Comments'     => array_sum(array_column($months, 'comments')),
            'Reviews'      => array_sum(array_column($months, 'reviews')),
            'Favorites'    => array_sum(array_column($months, 'favorites')),
        ];
        $emojis = ['New Users' => '👤', 'New Recipes' => '🍽️', 'Comments' => '💬', 'Reviews' => '⭐', 'Favorites' => '❤️'];
    @endphp
    @foreach($totals as $label => $value)
        <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
            <p class="text-3xl mb-1">{{ $emojis[$label] }}</p>
            <p class="text-2xl font-black text-orange-500">{{ $value }}</p>
            <p class="text-gray-400 text-xs mt-1">{{ $label }}</p>
        </div>
    @endforeach
</div>

<!-- Chart -->
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-8">
    <h2 class="font-semibold text-gray-900 mb-6">Growth Chart</h2>
    <canvas id="statsChart" height="100"></canvas>
</div>

<!-- Monthly breakdown table -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 text-left">
            <tr>
                <th class="px-4 py-3">Month</th>
                <th class="px-4 py-3">New Users</th>
                <th class="px-4 py-3">New Recipes</th>
                <th class="px-4 py-3">Comments</th>
                <th class="px-4 py-3">Reviews</th>
                <th class="px-4 py-3">Favorites</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($months as $month)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $month['label'] }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs font-medium">
                            {{ $month['users'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-orange-50 text-orange-500 px-2 py-0.5 rounded-full text-xs font-medium">
                            {{ $month['recipes'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-purple-50 text-purple-600 px-2 py-0.5 rounded-full text-xs font-medium">
                            {{ $month['comments'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-yellow-50 text-yellow-600 px-2 py-0.5 rounded-full text-xs font-medium">
                            {{ $month['reviews'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-red-50 text-red-500 px-2 py-0.5 rounded-full text-xs font-medium">
                            {{ $month['favorites'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json(array_column($months, 'label'));
const users    = @json(array_column($months, 'users'));
const recipes  = @json(array_column($months, 'recipes'));
const comments = @json(array_column($months, 'comments'));
const reviews  = @json(array_column($months, 'reviews'));
const favorites = @json(array_column($months, 'favorites'));

new Chart(document.getElementById('statsChart'), {
    type: 'line',
    data: {
        labels,
        datasets: [
            {
                label: 'New Users',
                data: users,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                tension: 0.4,
                fill: true,
            },
            {
                label: 'New Recipes',
                data: recipes,
                borderColor: '#f97316',
                backgroundColor: 'rgba(249,115,22,0.1)',
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Comments',
                data: comments,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Reviews',
                data: reviews,
                borderColor: '#eab308',
                backgroundColor: 'rgba(234,179,8,0.1)',
                tension: 0.4,
                fill: true,
            },
            {
                label: 'Favorites',
                data: favorites,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,0.1)',
                tension: 0.4,
                fill: true,
            },
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});
</script>
@endsection