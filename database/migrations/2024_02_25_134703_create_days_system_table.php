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
        Schema::create('days_system', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name');
            $table->boolean('flag')->nullable();
            $table->time('clock')->nullable();
            $table->uuid('classroom_id')->nullable();
            $table->uuid('teacher_course_id');
            $table->foreign('teacher_course_id')->references('id')->on('course_teacher')->cascadeOnDelete();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->nullOnDelete();
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days_system');
    }
};
