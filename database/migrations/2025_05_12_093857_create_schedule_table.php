<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Creating schedules table
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('section');
            $table->string('days');
            $table->string('term');
            $table->string('time');
            $table->string('room');
            $table->foreignId('strand_id')->constrained('strands')->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
