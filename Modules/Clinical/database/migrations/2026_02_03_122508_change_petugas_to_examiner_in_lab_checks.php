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
    Schema::table('sc_clinical.lab_checks', function (Blueprint $table) {
        // Hapus kolom lama
        $table->dropColumn(['doctor_id', 'nurse_id']);
        
        // Buat kolom baru (examiner_id & examiner_type)
        $table->nullableMorphs('examiner'); 
    });
}

public function down(): void
{
    Schema::table('sc_clinical.lab_checks', function (Blueprint $table) {
        $table->dropMorphs('examiner');
        $table->foreignId('doctor_id')->nullable();
        $table->foreignId('nurse_id')->nullable();
    });
}
};
