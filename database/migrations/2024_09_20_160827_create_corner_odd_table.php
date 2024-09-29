<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('corner_odd', function (Blueprint $table) {
            $table->id();
            $table->string('minute');
            $table->foreignId('league_id');
            $table->foreignId('match_id');
            $table->float('half_1_bet_point')->nullable();
            $table->float('full_time_bet_point')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corner_odd');
    }
};
