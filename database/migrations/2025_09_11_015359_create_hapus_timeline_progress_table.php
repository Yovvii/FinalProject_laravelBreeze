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
        Schema::table('timeline_progress', function (Blueprint $table) {
            $table->dropColumn('sma_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timeline_progress', function (Blueprint $table) {
            $table->unsignedBigInteger('sma_id')->nullable();
        });
    }
};