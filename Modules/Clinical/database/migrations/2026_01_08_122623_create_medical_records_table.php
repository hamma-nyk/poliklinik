<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan Schema ada (Postgres)
        // DB::statement('CREATE SCHEMA IF NOT EXISTS sc_clinical');

        // 1. Tabel Header (Rekam Medis)
        Schema::create('sc_clinical.medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // RM2026...
            
            // Relasi Personil
            $table->foreignId('patient_id')->constrained('sc_master.patients');
            $table->foreignId('doctor_id')->nullable()->constrained('sc_master.doctors');
            $table->foreignId('nurse_id')->nullable()->constrained('sc_master.nurses');

            // Tanda Vital (Fisik)
            $table->string('tensi')->nullable(); // String karena format "120/80"
            $table->decimal('suhu_tubuh', 4, 1)->nullable(); // 36.5
            $table->decimal('berat_badan', 5, 2)->nullable(); // 65.50
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // 170.00

            // Anamnesa (Wawancara)
            $table->text('keluhan_utama'); // Main Complaint
            $table->text('riwayat_penyakit')->nullable(); // History of illness
            $table->text('riwayat_alergi')->nullable(); // Tambahan khusus kunjungan ini
            $table->text('riwayat_psikososial')->nullable(); // Gaya hidup, stress, dll

            // Diagnosa & Tindakan
            $table->text('diagnosa');
            $table->text('tindakan')->nullable(); // Terapi non-obat (jahit luka, edukasi, dll)
            
            $table->timestamps();
        });

        // 2. Tabel Detail (Resep Obat)
        Schema::create('sc_clinical.medical_record_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained('sc_clinical.medical_records')->onDelete('cascade');
            
            // Relasi ke Inventory
            $table->foreignId('medicine_id')->constrained('sc_inventory.medicines');
            
            $table->integer('quantity');
            $table->string('instructions')->nullable(); // Contoh: "3x1 Sesudah Makan"
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_clinical.medical_record_medicines');
        Schema::dropIfExists('sc_clinical.medical_records');
    }
};