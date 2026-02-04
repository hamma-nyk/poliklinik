<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\MasterData\App\Models\Department;
use Modules\MasterData\App\Models\SubDepartment;
use Modules\MasterData\App\Models\Unit;
use Modules\MasterData\App\Models\Position;
use App\Traits\HasCustomCode;
class Employee extends Model
{
    use HasCustomCode;
    protected $connection = 'pgsql';
    protected $table = 'sc_master.employees';
    
    protected $fillable = ['code',
        'nik', 'nama', 'ktp', 'alamat', 'phone', 'blood_type', 
        'bag_dept', 'subbag_dept', 'sub_subbag_dept', 
        'birth_date', 'jabatan', 'gender', 'is_active'
    ];

    /**
     * Scope: Ambil hanya karyawan AKTIF
     * Cara pakai: Employee::active()->get();
     */
    public function scopeActive(Builder $query)
    {
        return $query->where(function($q) {
            $q->whereNull('is_active')
              ->orWhere('is_active', '')
              ->orWhere('is_active', '!=', 'KO');
        });
    }

    /**
     * Accessor: Status Boolean untuk di View
     * Cara pakai: if($emp->is_status_active) ...
     */
    public function getIsStatusActiveAttribute()
    {
        return $this->is_active !== 'KO';
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'bag_dept', 'code');
    }

    // Relasi ke Sub Bagian
    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'subbag_dept', 'code');
    }

    // Relasi ke Sub Sub Bagian
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'sub_subbag_dept', 'code');
    }

    // Relasi ke Jabatan
    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan', 'code');
    }
    public function getPrefix(): string
    {
        return 'KAR'; // Hasil: PAS2026010001
    }
}