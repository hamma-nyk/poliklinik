<?php

namespace Modules\Clinical\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse;
use App\Traits\HasCustomCode; // <--- 1. Import Trait
use Illuminate\Database\Eloquent\Relations\MorphTo;
class LabCheck extends Model
{
    use HasCustomCode; // <--- 2. Pasang Trait
    protected $connection = 'pgsql';
    protected $table = 'sc_clinical.lab_checks';
    protected $fillable = [
        'patient_id', 'examiner_id', 
        'examiner_type', 
        'gula_darah', 'kolesterol', 'asam_urat', 'tensi', 'notes'
    ];

    public function patient() { return $this->belongsTo(Patient::class); }
    // public function doctor() { return $this->belongsTo(Doctor::class); }
    // public function nurse() { return $this->belongsTo(Nurse::class); }
    public function examiner(): MorphTo
    {
        return $this->morphTo();
    }

    // public function getPetugasNameAttribute()
    // {
    //     if ($this->doctor_id) {
    //         return $this->doctor->name . ' (Dokter)';
    //     } elseif ($this->nurse_id) {
    //         return $this->nurse->name . ' (Perawat)';
    //     }
    //     return '-';
    // }
    public function getPetugasNameAttribute()
    {
        if (!$this->examiner) return '-';

        // Cek Tipe Modelnya
        if (str_contains($this->examiner_type, 'Doctor')) {
            return $this->examiner->name;
        } elseif (str_contains($this->examiner_type, 'Nurse')) {
            return $this->examiner->nama;
        }
        
        return $this->examiner->name;
    }

    public function getPetugasTypeAttribute()
    {
        if (!$this->examiner) return '-';

        // Cek Tipe Modelnya
        if (str_contains($this->examiner_type, 'Doctor')) {
            return 'Dokter';
        } elseif (str_contains($this->examiner_type, 'Nurse')) {
            return 'Perawat';
        }
        
        return 'Tidak Diketahui';
    }
    
    // Cek Status Gula (> 200 Tinggi)
    public function getStatusGulaAttribute()
    {
        if (!$this->gula_darah) return 'neutral';
        return $this->gula_darah > 200 ? 'danger' : 'normal';
    }

    // Cek Status Kolesterol (> 200 Tinggi)
    public function getStatusKolesterolAttribute()
    {
        if (!$this->kolesterol) return 'neutral';
        return $this->kolesterol > 200 ? 'danger' : 'normal';
    }

    // Cek Asam Urat (L>7, P>6 Tinggi)
    public function getStatusAsamUratAttribute()
    {
        if (!$this->asam_urat) return 'neutral';
        
        $limit = ($this->patient->gender == 'L') ? 7.0 : 6.0;
        return $this->asam_urat > $limit ? 'danger' : 'normal';
    }

    public function getPrefix(): string
    {
        return 'LAB'; // Hasil: LAB2026010001
    }
}