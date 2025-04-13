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
        Schema::create('assign', function (Blueprint $table) {
            $table->id();
            $table->string('teachername');
            $table->string('employmentstatus');
            $table->string('email');
            $table->string('section');
            $table->string('subject');
            $table->time('start_time')->nullable(); // Add start_time
            $table->time('end_time')->nullable();
            $table->enum('status',['ongoing', 'completed', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign');
    }
};
