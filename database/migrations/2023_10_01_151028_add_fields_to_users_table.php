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
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->string('gender')->nullable();
            $table->text('photo')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->dropColumn('course_id');
            $table->dropColumn('section_id');
            $table->dropColumn('gender');
            $table->dropColumn('photo');
            $table->dropColumn('is_active');
            $table->dropColumn('is_admin');
        });
    }
};
