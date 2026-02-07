<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sc_clinical.medical_records', function (Blueprint $table) {
            // Tipe: 'sakit' (default) atau 'kecelakaan_kerja'
            $table->string('visit_type')->default('sakit')->after('patient_id'); 
            
            // Checklist (Boolean)
            $table->boolean('is_sick_leave')->default(false)->after('visit_type'); // Ijin Sakit
            $table->boolean('is_referred')->default(false)->after('is_sick_leave'); // Rujuk RS
        });
    }

    public function down()
    {
        Schema::table('sc_clinical.medical_records', function (Blueprint $table) {
            $table->dropColumn(['visit_type', 'is_sick_leave', 'is_referred']);
        });
    }
};
