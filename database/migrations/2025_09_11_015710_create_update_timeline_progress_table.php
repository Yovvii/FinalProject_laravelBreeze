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
            $table->foreignId('sma_id')->nullable()->after('user_id')->constrained('sma_datas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timeline_progress', function (Blueprint $table) {
            $table->dropForeign(['sma_id']);
            $table->dropColumn('sma_id');
        });
    }
};