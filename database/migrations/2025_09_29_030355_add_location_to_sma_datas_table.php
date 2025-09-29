<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/XXXX_XX_XX_XXXXXX_add_location_to_sma_datas_table.php

public function up(): void
{
    Schema::table('sma_datas', function (Blueprint $table) {
        $table->string('latitude')->nullable();
        $table->string('longitude')->nullable();
    });
}

public function down(): void
{
    Schema::table('sma_datas', function (Blueprint $table) {
        $table->dropColumn(['latitude', 'longitude']);
    });
}
};
