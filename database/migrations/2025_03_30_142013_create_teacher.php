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
            $table->string('profile_picture')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->integer('age');
            $table->string('nationality');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('degree');
            $table->string('major');
            $table->string('university');
            $table->string('year_graduated');
            $table->string('prc_license');
            $table->date('license_validity');
            $table->date('let_date');
            $table->string('specialization');
            $table->string('prc_copy');
            $table->string('previous_school')->nullable();
            $table->string('position')->nullable();
            $table->integer('years_experience')->default(0);
            $table->string('employment_status');
            $table->string('teaching_schedule');
            $table->string('subjects');
            $table->text('certifications')->nullable();
            $table->text('medical_info')->nullable();
            $table->text('accommodations')->nullable();
            $table->string('resume');
            $table->string('transcript');
            $table->date('date_hired');
            $table->string('employee_id')->unique();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
