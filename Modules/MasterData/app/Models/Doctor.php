<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasCustomCode; // Import Trait

class Doctor extends Model
{
    use HasFactory, HasCustomCode; // Pasang Trait
protected $connection = 'pgsql';
    protected $table = 'sc_master.doctors';

    protected $fillable = [
        'code', 'name', 'nik_ktp', 'sip', 'specialization', 'phone', 'is_active'
    ];

    /**
     * Definisi Prefix untuk Auto Number
     * Hasil: DOK2026010001
     */
    public function getPrefix(): string
    {
        return 'DOK'; 
    }

    /**
     * Scope untuk mengambil dokter yang aktif saja
     * Cara pakai: Doctor::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}