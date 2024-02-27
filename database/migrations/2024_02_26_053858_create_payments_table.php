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
            $table->float('cost');
            $table->date('date');
            $table->uuid('teacher_course_student_id');
            $table->foreign('teacher_course_student_id')->references('id')->on('course_teacher_student')->noActionOnDelete();
            $table->string('payment_method');
            $table->json('transaction_data');
            $table->unsignedBigInteger('payment_id');
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
