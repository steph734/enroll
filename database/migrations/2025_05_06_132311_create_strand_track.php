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
        Schema::create('strand_track', function (Blueprint $table) {
            $table->id();
            $table->foreignId('strand_id')->constrained('strand', 'id')->onDelete('cascade');
            $table->foreignId('track_id')->constrained('tracks', 'id')->onDelete('cascade');
            $table->unique(['strand_id', 'track_id']); // Ensure unique relationships
            $table->timestamps();
        
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strand_track');
    }
};
