<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller {

    public function upgrade() {
        if (auth()->user()->isPremium()) {
            return redirect()->route('recipes.index')
                ->with('success', 'You are already a Premium member!');
        }
        return view('subscription.upgrade');
    }
     

    public function pay(Request $request) {
        $request->merge([
        'card_number' => preg_replace('/\s+/', '', $request->card_number),
         ]);
        $request->validate([
            'card_number' => 'required|digits:16',
            'expiry'      => 'required|string',
            'cvv'         => 'required|digits_between:3,4',
            'name'        => 'required|string|max:255',
        ]);

        // Cancel any existing subscription
        UserSubscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create new subscription
        $subscription = UserSubscription::create([
            'user_id'        => auth()->id(),
            'plan'           => 'premium',
            'amount'         => 99.00,
            'status'         => 'active',
            'card_last_four' => substr($request->card_number, -4),
            'starts_at'      => now(),
            'expires_at'     => now()->addMonth(),
        ]);

        // Notify user
        NotificationHelper::send(
            auth()->id(),
            'subscription',
            '🌟 Welcome to Premium!',
            'Your Premium subscription is now active until ' . $subscription->expires_at->format('M d, Y') . '. Enjoy Meal Planner and Shopping List!',
            route('meal-plan.index')
        );

        return redirect()->route('recipes.index')
            ->with('success', '🎉 Welcome to TresKudos Premium! You now have access to Meal Planner and Shopping List.');
    }

    public function cancel() {
        $sub = auth()->user()->subscription;
        if ($sub && $sub->isActive()) {
            $sub->update(['status' => 'cancelled']);
            NotificationHelper::send(
                auth()->id(),
                'subscription',
                'Subscription cancelled',
                'Your Premium subscription has been cancelled. You will lose access on ' . $sub->expires_at->format('M d, Y') . '.',
                route('subscription.upgrade')
            );
        }
        return back()->with('success', 'Subscription cancelled.');
    }
}