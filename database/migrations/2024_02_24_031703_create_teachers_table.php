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
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->json('first_name');
            $table->json('last_name');
            $table->string('phoneNumber');
            $table->string('photo')->nullable();
            $table->string('password');
            $table->string('user_name');
            $table->json('description')->nullable();
            $table->uuid('speciality_id')->nullable();
            $table->foreign('speciality_id')->references('id')->on('specialties')->nullOnDelete();
            $table->boolean('is_admin')->default(false);
            $table->softDeletes();
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
