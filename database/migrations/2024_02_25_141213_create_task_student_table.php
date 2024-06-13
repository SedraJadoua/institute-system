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
        Schema::create('task_student', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('name');
            $table->integer('mark');
            $table->float('studentMark');
            $table->timestamp('date');
            $table->uuid('course_teacher_student_id')->nullable();
            $table->foreign('course_teacher_student_id')->references('id')->on('course_teacher_student')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_student');
    }
};
