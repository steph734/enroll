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
            $table->id('sectionid');
            $table->string('sectionname');  
            $table->integer('gradelevel');
            $table->unsignedBigInteger('strandid');  // Foreign key column
            $table->foreign('strandid')             // Defines the foreign key constraint
                  ->references('strandid')          // References the 'strandid' column
                  ->on('strand')                    // In the 'strand' table
                  ->onDelete('cascade');            // Deletes sections when parent strand is deleted
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
