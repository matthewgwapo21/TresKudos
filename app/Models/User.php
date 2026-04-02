<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function recipes() {
        return $this->hasMany(Recipe::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
    public function mealPlans() {
        return $this->hasMany(MealPlan::class);
    }
    public function notifications() {
    return $this->hasMany(Notification::class)->latest();
}

public function unreadNotifications() {
    return $this->notifications()->where('is_read', false);
}
}
