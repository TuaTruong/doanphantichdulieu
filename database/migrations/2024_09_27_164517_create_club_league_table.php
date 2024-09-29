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
        Schema::create('club_league', function (Blueprint $table) {
            $table->foreignId('club_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng teams
            $table->foreignId('league_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng tournaments
            $table->primary(['club_id', 'league_id']); // Tạo khóa chính tổ hợp từ hai cột
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_league');
    }
};
