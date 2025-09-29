<?php
// database/migrations/XXXX_XX_XX_XXXXXX_add_document_afirmasi_to_siswas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Tambahkan kolom untuk path dokumen afirmasi
            $table->string('document_afirmasi')->nullable()->after('sertifikat_file');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('document_afirmasi');
        });
    }
};