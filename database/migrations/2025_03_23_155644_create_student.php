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
        Schema::create('student', function (Blueprint $table) {
            $table->id('studentid');
            $table->string('firstname'); 
            $table->string('middlename');
            $table->string('lastname');
            $table->string('gender');
            $table->integer('age');
            $table->string('email');
            $table->integer('phonenumber');
            $table->unsignedBigInteger('subjectid'); 
            $table->unsignedBigInteger('strandid'); 
            $table->unsignedBigInteger('sectionid'); 
            $table->unsignedBigInteger('paymentid'); 
            
            $table->foreign('subjectid')
                  ->references('subjectid') 
                  ->on('subject') 
                  ->onDelete('cascade');
                  
            $table->foreign('strandid')
                  ->references('strandid') 
                  ->on('strand')
                  ->onDelete('cascade');

            $table->foreign('sectionid')
                  ->references('sectionid') 
                  ->on('section')
                  ->onDelete('cascade');

             $table->foreign('paymentid')
                  ->references('paymentid') 
                  ->on('payment')
                  ->onDelete('cascade');
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
