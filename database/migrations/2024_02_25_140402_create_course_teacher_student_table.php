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
        Schema::create('course_teacher_student', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('paid')->default(false);
            $table->uuid('course_teacher_id');
            $table->foreign('course_teacher_id')->references('id')->on('course_teacher')->noActionOnDelete()->cascadeOnUpdate();
            $table->uuid('student_id');
            $table->foreign('student_id')->references('id')->on('students')->noActionOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_teacher_student');
    }
};
