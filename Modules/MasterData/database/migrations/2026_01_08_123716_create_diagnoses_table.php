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
       Schema::create('sc_master.diagnoses', function (Blueprint $table) {
        $table->id();
        $table->string('code')->nullable()->unique(); // Contoh: A00, B01 (ICD-10)
        $table->string('name'); // Nama Penyakit
        $table->timestamps();
    });

    // Update Tabel Rekam Medis (tambah kolom diagnosis_id)
    Schema::table('sc_clinical.medical_records', function (Blueprint $table) {
        // Kita ubah kolom 'diagnosa' (text) yang lama menjadi relasi
        // Atau biarkan text sebagai catatan tambahan, dan buat kolom baru untuk ID utama
        $table->unsignedBigInteger('diagnosis_id')->nullable()->after('doctor_id');
        
        $table->foreign('diagnosis_id')
              ->references('id')->on('sc_master.diagnoses')
              ->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
