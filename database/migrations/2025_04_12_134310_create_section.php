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
        Schema::create('section', function (Blueprint $table) {
            $table->id();
            $table->string('sectioname');
            $table->string('gradelevel');
            $table->string('code', 50)->unique()->nullable(); // Added column for 'STEM-A1'
            $table->unsignedBigInteger('strandid')->nullable()->index();
            $table->foreign('strandid')->references('id')->on('strand'); // Fixed foreign key
            $table->unsignedInteger('max_slots')->default(50); // Maximum slots (e.g., 50)
            $table->unsignedInteger('current_slots')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section');
    }
};
