<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Only add if it doesn't exist
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('alumni')->after('id');
        }

        if (!Schema::hasColumn('users', 'is_approved')) {
            $table->boolean('is_approved')->default(false)->after('role');
        }

        if (!Schema::hasColumn('users', 'student_id')) {
            $table->string('student_id')->nullable()->after('is_approved');
        }

        if (!Schema::hasColumn('users', 'master_alumni_id')) {
            $table->foreignId('master_alumni_id')->nullable()
                  ->constrained('master_alumni')
                  ->onDelete('set null')
                  ->after('student_id');
        }

        if (!Schema::hasColumn('users', 'batch_year')) {
            $table->integer('batch_year')->nullable()->after('master_alumni_id');
        }

        if (!Schema::hasColumn('users', 'course')) {
            $table->string('course')->nullable()->after('batch_year');
        }
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'is_approved', 'student_id', 'master_alumni_id',
                'batch_year', 'course'
            ]);
        });
    }
};