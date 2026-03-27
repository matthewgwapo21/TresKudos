<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image',
        'prep_time',
        'cook_time',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function ingredients() {
        return $this->hasMany(Ingredient::class)->orderBy('order_index');
    }

    public function steps() {
        return $this->hasMany(Step::class)->orderBy('step_number');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function isFavoritedBy(User $user) {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function scopeSearch($query, $term) {
        return $query->where('title', 'like', "%{$term}%")
                     ->orWhere('description', 'like', "%{$term}%");
    }
    public function reviews() {
        return $this->hasMany(Review::class)->latest();
    }

    public function averageRating() {
        return round($this->reviews()->avg('rating'), 1);
    }

    public function userReview() {
        return $this->reviews()->where('user_id', auth()->id())->first();
        }
    public function comments() {
        return $this->hasMany(Comment::class)->latest();
    }
}