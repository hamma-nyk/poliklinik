<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sc_clinical.lab_checks', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable()->unique();
            // Relasi ke Pasien
            $table->foreignId('patient_id')->constrained('sc_master.patients')->onDelete('cascade');
            
            $table->foreignId('doctor_id')->nullable()->constrained('sc_master.doctors');
            $table->foreignId('nurse_id')->nullable()->constrained('sc_master.nurses');

            // Hasil Lab
            $table->integer('gula_darah')->nullable()->comment('mg/dL'); // GDS
            $table->integer('kolesterol')->nullable()->comment('mg/dL');
            $table->decimal('asam_urat', 4, 1)->nullable()->comment('mg/dL');
            
            // Tanda Vital (Seringkali dicek barengan)
            $table->string('tensi')->nullable(); 
            
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sc_clinical.lab_checks');
    }
};
