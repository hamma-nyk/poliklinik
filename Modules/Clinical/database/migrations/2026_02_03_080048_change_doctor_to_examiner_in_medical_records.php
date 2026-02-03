<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('sc_clinical.medical_records', function (Blueprint $table) {
        // 1. Hapus Foreign Key & Kolom lama (doctor_id)
        // Pastikan nama foreign key benar (biasanya medical_records_doctor_id_foreign)
        // Jika error saat dropForeign, bisa dikomentari/skip jika constraint belum ada
        // $table->dropForeign(['doctor_id']); 
        $table->dropColumn('doctor_id');

        // 2. Buat Kolom Baru (Morph)
        // Ini akan membuat 2 kolom: examiner_id (bigint) dan examiner_type (string)
        $table->morphs('examiner'); 
    });
}

public function down(): void
{
    Schema::table('sc_clinical.medical_records', function (Blueprint $table) {
        $table->dropMorphs('examiner');
        $table->foreignId('doctor_id')->nullable(); // Kembalikan
    });
}
};
