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
            $table->integer('partylist_id')->nullable();
            $table->text('address')->nullable();
            $table->date('birthday')->nullable();
            $table->text('organizational_affiliation')->nullable();
            $table->text('notable_achievements')->nullable();
            $table->text('platform')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('partylist_id');
            $table->dropColumn('address');
            $table->dropColumn('birthday');
            $table->dropColumn('organizational_affiliation');
            $table->dropColumn('notable_achievements');
            $table->dropColumn('platform');
        });
    }
};
