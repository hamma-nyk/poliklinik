<?php

namespace Modules\Clinical\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomCode;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class MedicalRecord extends Model
{
    use HasCustomCode;

    protected $connection = 'pgsql'; // Penting untuk Schema
    protected $table = 'sc_clinical.medical_records';

    // protected $fillable = [
    //     'code', 'patient_id', 'doctor_id', 'nurse_id',
    //     'tensi', 'suhu_tubuh', 'berat_badan', 'tinggi_badan',
    //     'keluhan_utama', 'riwayat_penyakit', 'riwayat_alergi', 'riwayat_psikososial',
    //     'diagnosa', 'tindakan', 'diagnosis_id'
    // ];

    protected $fillable = [
        'code', 'patient_id', 
        'examiner_id',   // Ganti doctor_id jadi ini
        'examiner_type', // Tambah ini
        'diagnosis_id',
        'tensi', 'suhu_tubuh', 'berat_badan', 'tinggi_badan',
        'keluhan_utama', 'riwayat_penyakit', 'riwayat_alergi', 'riwayat_psikososial',
        'diagnosa', 'tindakan', 'diagnosis_id'
    ];

    public function getPrefix(): string
    {
        return 'RM'; // Hasil: RM2026010001
    }

    // Relasi
    public function patient() { return $this->belongsTo(Patient::class); }
    // public function doctor() { return $this->belongsTo(Doctor::class); }
    // public function nurse() { return $this->belongsTo(Nurse::class); }
    public function examiner(): MorphTo
    {
        return $this->morphTo();
    }
    // Relasi ke Obat
    public function medicines() {
        return $this->hasMany(MedicalRecordMedicine::class);
    }

    // Modules/Clinical/App/Models/MedicalRecord.php

public function diagnosis()
{
    return $this->belongsTo(\Modules\MasterData\App\Models\Diagnosis::class, 'diagnosis_id');
}
}