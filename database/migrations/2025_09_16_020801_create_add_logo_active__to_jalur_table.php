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
            Schema::table('jalur_pendaftarans', function (Blueprint $table) {
                // Menambahkan kolom baru 'logo_active' sebagai LONGTEXT
                // Tipe LONGTEXT cocok jika Anda ingin menyimpan kode SVG
                // nullable() memungkinkan kolom ini kosong pada data yang sudah ada
                $table->longText('logo_active')->after('logo')->nullable();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('jalur_pendaftarans', function (Blueprint $table) {
                // Menghapus kolom 'logo_active' saat migrasi di-rollback
                $table->dropColumn('logo_active');
            });
        }
    };
