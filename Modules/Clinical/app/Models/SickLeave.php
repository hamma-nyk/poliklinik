<?php

namespace Modules\Clinical\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\MasterData\App\Models\Patient;

class SickLeave extends Model
{
    protected $table = 'sc_clinical.sick_leaves';
    protected $guarded = [];

    // Relasi ke Pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Relasi ke Rekam Medis (Opsional, jika internal)
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }
}