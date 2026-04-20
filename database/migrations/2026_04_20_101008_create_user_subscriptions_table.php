<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plan')->default('premium');
            $table->decimal('amount', 8, 2)->default(99.00);
            $table->string('status')->default('active');
            $table->string('card_last_four')->nullable();
            $table->timestamp('starts_at');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_subscriptions');
    }
};