<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_watchlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('commodity_id')->constrained('commodities')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'commodity_id'], 'user_watchlists_unique_user_commodity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_watchlists');
    }
};
