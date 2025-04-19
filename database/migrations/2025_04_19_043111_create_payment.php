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
        Schema::create('payment', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedInteger('studentid');
            $table->foreign('studentid')
            ->references('studentid')
            ->on('students')
            ->onDelete('cascade');
            $table->string('full_name'); 
            $table->string('gradesection'); 
            $table->decimal('amount_due', 10, 2)->default(30000.00);
            $table->decimal('balance', 10, 2)->default(0); 
            $table->enum('status', ['Paid', 'Unpaid', 'Partial']);
            $table->timestamps(); 

          
           
        });
 
    }

  
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
