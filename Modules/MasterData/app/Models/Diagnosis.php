<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $connection = 'pgsql'; // Sesuaikan DB Anda
    protected $table = 'sc_master.diagnoses';
    protected $fillable = ['code', 'name'];

    public function mcuTypes()
    {
        return $this->belongsToMany(
            McuType::class,
            'sc_master.mcu_type_diagnosis',
            'diagnosis_id',
            'mcu_type_id'
        )->withTimestamps();
    }
}