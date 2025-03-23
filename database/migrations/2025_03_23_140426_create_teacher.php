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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); 
            $table->integer('grade_level'); 
            $table->string('contacts'); 
            $table->unsignedBigInteger('subjectid'); 
            $table->unsignedBigInteger('sectionid'); 
            $table->unsignedBigInteger('adminid'); 
            
            $table->foreign('subjectid')
                  ->references('subjectid') 
                  ->on('subject') 
                  ->onDelete('cascade');
                  
            $table->foreign('sectionid')
                  ->references('sectionid') 
                  ->on('section')
                  ->onDelete('cascade');

            $table->foreign('adminid')
                  ->references('adminid') 
                  ->on('users')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher');
    }
};
