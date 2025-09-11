<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Menambahkan kolom 'data_sma_id' sebagai kunci asing
            // yang merujuk ke tabel 'sma_datas'.
            $table->foreignId('data_sma_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('sma_datas')
                  ->onDelete('set null');
        });
    }

    /**
     * Kembalikan migration.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Hapus kunci asing terlebih dahulu sebelum menghapus kolom.
            $table->dropForeign(['data_sma_id']);
            // Hapus kolom 'data_sma_id'.
            $table->dropColumn('data_sma_id');
        });
    }
};
