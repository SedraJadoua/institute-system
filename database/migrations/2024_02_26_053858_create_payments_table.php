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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('amount', 10 , 2);
            $table->date('date');
            $table->uuid('teacher_course_student_id')->nullable();
            $table->foreign('teacher_course_student_id')->references('id')->on('course_teacher_student')->nullOnDelete();
            $table->string('payment_method');
            $table->string('payment_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
