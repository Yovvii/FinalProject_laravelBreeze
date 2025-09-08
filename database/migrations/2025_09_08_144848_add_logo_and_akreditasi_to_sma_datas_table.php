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
        Schema::table('sma_datas', function (Blueprint $table) {
            $table->string('logo_sma')->nullable()->after('nama_sma');
            $table->foreignId('akreditasi_id')->nullable()->constrained('akreditasis')->after('logo_sma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sma_datas', function (Blueprint $table) {
            $table->dropForeign(['akreditasi_id']);
            $table->dropColumn('akreditasi_id');
            $table->dropColumn('logo_sma');
        });
    }
};
