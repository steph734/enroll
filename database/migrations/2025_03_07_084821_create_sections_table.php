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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_id')->constrained('tracks')->onDelete('cascade');
            $table->foreignId('strand_id')->constrained('strands')->onDelete('cascade');
            $table->string('section_name')->unique();
            $table->string('description')->nullable();
            $table->string('school_year')->nullable();
            $table->string('GradeLevel')->nullable(); // e.g., Grade 11, Grade 12
            $table->string('status')->default('active'); // active, inactive
            $table->string('adviser')->nullable(); // Name of the class adviser
            $table->string('room')->nullable(); // Room number or name
            $table->integer('capacity')->default(50); // Maximum number of students allowed in the section
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
