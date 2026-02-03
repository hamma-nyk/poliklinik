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
    Schema::table('sc_master.nurses', function (Blueprint $table) {
        // Kolom Tipe (Karyawan / Eksternal)
        $table->string('type', 20)->default('eksternal')->after('id'); 
        
        // Kolom NIK Perusahaan (Beda dengan NIK KTP)
        $table->string('nik', 50)->nullable()->after('type');
        $table->string('ktp', 50)->nullable()->after('nik');
    });
}

public function down(): void
{
    Schema::table('sc_master.nurses', function (Blueprint $table) {
        $table->dropColumn(['type', 'ktp', 'nik', 'nik_ktp']);
    });
}
};
