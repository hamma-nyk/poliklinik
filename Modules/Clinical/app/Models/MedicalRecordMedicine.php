<?php

namespace Modules\Clinical\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\App\Models\Medicine;

class MedicalRecordMedicine extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'sc_clinical.medical_record_medicines';
    protected $fillable = ['medical_record_id', 'medicine_id', 'quantity', 'instructions'];

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }
}