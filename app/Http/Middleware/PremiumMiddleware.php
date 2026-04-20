<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PremiumMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (!auth()->user()->isPremium()) {
            return redirect()->route('subscription.upgrade')
                ->with('warning', 'This feature requires a Premium subscription.');
        }
        return $next($request);
    }
}