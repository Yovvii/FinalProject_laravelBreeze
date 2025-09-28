<?php

// database/migrations/XXXX_XX_XX_XXXXXX_add_kuota_siswa_to_sma_datas_table.php

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
            // Tambahkan kolom kuota siswa, defaultnya 0
            $table->unsignedInteger('kuota_siswa')->default(0)->after('logo_sma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sma_datas', function (Blueprint $table) {
            $table->dropColumn('kuota_siswa');
        });
    }
};