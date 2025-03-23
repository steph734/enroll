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
        Schema::create('class', function (Blueprint $table) {
            $table->id('classid');
            $table->date('day'); 
            $table->time('time'); 
            $table->string('room'); 
            $table->unsignedBigInteger('subjectid'); 
            $table->unsignedBigInteger('sectionid'); 
            $table->unsignedBigInteger('teacherid'); 
            
            $table->foreign('subjectid')
                  ->references('subjectid') 
                  ->on('subject') 
                  ->onDelete('cascade');
                  
            $table->foreign('sectionid')
                  ->references('sectionid') 
                  ->on('section')
                  ->onDelete('cascade');

            $table->foreign('teacherid')
                  ->references('teacherid') 
                  ->on('teachers')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class');
    }
};
