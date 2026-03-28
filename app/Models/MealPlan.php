<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model {
    protected $fillable = ['user_id', 'recipe_id', 'planned_date', 'meal_type'];

    protected $casts = [
        'planned_date' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }
}