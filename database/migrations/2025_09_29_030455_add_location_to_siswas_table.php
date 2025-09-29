<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/XXXX_XX_XX_XXXXXX_add_location_to_siswas_table.php

public function up(): void
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->string('latitude_siswa')->nullable();
        $table->string('longitude_siswa')->nullable();
        // Anda juga bisa menambahkan kolom untuk menyimpan hasil perhitungan jarak (opsional)
        $table->decimal('jarak_ke_sma_km', 8, 2)->nullable(); 
    });
}

public function down(): void
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->dropColumn(['latitude_siswa', 'longitude_siswa', 'jarak_ke_sma_km']);
    });
}
};
