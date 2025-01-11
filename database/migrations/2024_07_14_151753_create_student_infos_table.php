<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('lattitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('other_email')->nullable();
            $table->string('professional_email')->nullable();
            $table->string('other_phone')->nullable();
            $table->string('professional_phone')->nullable();
            $table->string('department')->nullable();
            $table->string('speciality_area')->nullable();
            $table->string('speciality')->nullable();
            $table->string('region')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('title')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('office_name')->nullable();

            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_infos');
    }
};
