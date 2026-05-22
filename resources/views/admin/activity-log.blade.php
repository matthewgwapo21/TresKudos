@extends('layouts.app')
@section('title', 'Activity Log — Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="brand text-3xl font-black text-gray-900">Activity <span class="text-orange-500">Log</span></h1>
        <p class="text-gray-400 text-sm mt-1">All user actions recorded in the system</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-orange-500 hover:underline">← Back to Dashboard</a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 text-left">
            <tr>
                <th class="px-4 py-3">User</th>
                <th class="px-4 py-3">Action</th>
                <th class="px-4 py-3">Description</th>
                <th class="px-4 py-3">IP Address</th>
                <th class="px-4 py-3">Date & Time</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-900">
                        {{ $log->user ? $log->user->name : 'Deleted User' }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            @if(str_contains($log->action, 'Logged In')) bg-green-100 text-green-600
                            @elseif(str_contains($log->action, 'Logged Out')) bg-gray-100 text-gray-500
                            @elseif(str_contains($log->action, 'Deleted')) bg-red-100 text-red-500
                            @elseif(str_contains($log->action, 'Added')) bg-blue-100 text-blue-600
                            @elseif(str_contains($log->action, 'Edited')) bg-yellow-100 text-yellow-600
                            @else bg-orange-100 text-orange-600
                            @endif">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $log->description ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $log->ip_address ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ $log->created_at->format('M d, Y h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">
                        <p class="text-3xl mb-2">📋</p>
                        <p>No activity recorded yet.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $logs->links() }}</div>
@endsection