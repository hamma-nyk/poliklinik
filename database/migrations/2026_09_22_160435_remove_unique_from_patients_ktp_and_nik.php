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
        Schema::table('sc_master.patients', function (Blueprint $table) {
            $table->dropUnique('sc_master_patients_nik_unique');
            $table->dropUnique('sc_master_patients_ktp_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sc_master.patients', function (Blueprint $table) {
            $table->unique('nik', 'sc_master_patients_nik_unique');
            $table->unique('ktp', 'sc_master_patients_ktp_unique');
        });
    }
};
