<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('sc_clinical.sick_leaves', function (Blueprint $table) {
        $table->id();
        $table->string('reg_number')->unique(); // No. Surat (SKD/2026/02/001)
        
        // Tipe: 'internal' (dari klinik kita) atau 'external' (dari RS luar)
        $table->enum('type', ['internal', 'external'])->default('internal');
        
        // Relasi
        $table->foreignId('patient_id')->constrained('sc_master.patients'); // Karyawan yg sakit
        
        // Jika Internal, ambil ID Rekam Medisnya
        $table->foreignId('medical_record_id')
              ->nullable()
              ->constrained('sc_clinical.medical_records');

        // Jika Eksternal, isi manual
        $table->string('external_clinic_name')->nullable(); // Nama RS/Klinik Luar
        $table->string('external_doctor_name')->nullable(); // Nama Dokter Luar
        
        // Detail Ijin
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('duration_days'); // Lama ijin (hari)
        $table->text('notes')->nullable(); // Diagnosa/Keterangan (Rest bed, dll)
        
        $table->timestamps();
    });
}
};
