<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class McuType extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'sc_master.mcu_types';

    protected $fillable = [
        'name',
        'recommended_exams',
        'description',
    ];

    public function diagnoses()
    {
        return $this->belongsToMany(
            Diagnosis::class,
            'sc_master.mcu_type_diagnosis',
            'mcu_type_id',
            'diagnosis_id'
        )->withTimestamps();
    }
}
