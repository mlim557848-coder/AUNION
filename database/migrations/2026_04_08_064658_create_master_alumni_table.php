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
    Schema::create('master_alumni', function (Blueprint $table) {
        $table->id();
        $table->string('student_id')->unique();
        $table->string('full_name');
        $table->string('batch_year');
        $table->string('course');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_alumni');
    }
};
