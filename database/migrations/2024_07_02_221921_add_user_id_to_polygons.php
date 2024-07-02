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
        Schema::table('polygons', function (Blueprint $table) {
            // Ensure the column is of the correct type and has the correct constraints
            if (Schema::hasColumn('polygons', 'user_id')) {
                $table->unsignedBigInteger('user_id')->change();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            } else {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('polygons', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};