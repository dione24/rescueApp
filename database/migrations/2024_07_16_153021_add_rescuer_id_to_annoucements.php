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
        Schema::table('announcements', function (Blueprint $table) {
            $table->unsignedBigInteger('rescuer_id')->nullable();
            $table->foreign('rescuer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annoucements', function (Blueprint $table) {
            $table->dropForeign(['rescuer_id']);
            $table->dropColumn('rescuer_id');
        });
    }
};