<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->foreignId('jalur_pendaftaran_id')
                  ->nullable()
                  ->after('data_sma_id') // Setelah kolom data_sma_id
                  ->constrained('jalur_pendaftarans')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['jalur_pendaftaran_id']);
            $table->dropColumn('jalur_pendaftaran_id');
        });
    }
};