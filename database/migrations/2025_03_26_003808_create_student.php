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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('studentid')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('age');
            $table->string('nationality');
            $table->string('home_address');
            $table->string('zip_code');
            $table->string('contact_number');
            $table->enum('status', ['ongoing', 'graduated', 'dropped'])->default('ongoing')->change();
            $table->string('secondary_contact')->nullable();
            $table->string('email')->unique();
            $table->string('profile_picture')->nullable();
            $table->string('guardian_first_name');
            $table->string('guardian_middle_name')->nullable();
            $table->string('guardian_last_name');
            $table->string('relationship');
            $table->string('guardian_contact');
            $table->string('guardian_email')->nullable();
            $table->string('previous_school');
            $table->string('grade_completed');
            $table->string('school_year_completed');
            $table->string('gpa')->nullable();
            $table->string('transcript');
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->string('grade_level');
            $table->string('class_schedule');
            $table->text('additional_notes')->nullable();
            $table->text('medical_info')->nullable();
            $table->text('special_accommodations')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('downpayment', 10, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('balance', 10, 2)->default(30000.00);
            $table->string('receiptnumber', 6)->unique()->nullable();


            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
