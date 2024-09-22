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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id');
            $table->foreignId('match_id');
            $table->foreignId('league_id');
            $table->boolean('is_home');
            $table->integer('total');
            $table->integer('minute');




            $table->integer('shots_off_target');
            $table->integer('goals');
            $table->integer('penalty');
            $table->integer('assists');
            $table->integer('red_cards');
            $table->integer('yellow_cards');
            $table->integer('shots');
            $table->integer('shots_on_target');
            $table->integer('dribble');
            $table->integer('dribble_succ');
            $table->integer('clearances');
            $table->integer('blocked_shots');
            $table->integer('interceptions');
            $table->integer('tackles');
            $table->integer('passes');
            $table->integer('passes_accuracy');
            $table->integer('key_passes');
            $table->integer('crosses');
            $table->integer('crosses_accuracy');
            $table->integer('long_balls');
            $table->integer('long_balls_accuracy');
            $table->integer('duels');
            $table->integer('duels_won');
            $table->integer('fouls');
            $table->integer('was_fouled');
            $table->integer('goal_against');
            $table->integer('offsides');
            $table->integer('yellow2red_cards');
            $table->integer('corner_kicks');
            $table->integer('ball_possession');
            $table->integer('dangerous_attack');
            $table->integer('attacks');
            $table->integer('freekicks');
            $table->integer('freekick_goals');
            $table->integer('hit_woodwork');
            $table->integer('fastbreaks');
            $table->integer('fastbreak_shots');
            $table->integer('fastbreak_goals');
            $table->integer('poss_losts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
