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
        
        $table->foreignId('studentid')->constrained('students')->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->string('payment_method');
        $table->string('receipnumber')->unique();
          $table->timestamp('payment_date');
         $table->text('remarks')->nullable();
        
        $table->timestamps();
        });
          
    
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
