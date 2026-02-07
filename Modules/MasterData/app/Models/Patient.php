<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan Huruf Besar
use App\Traits\HasCustomCode;
use Modules\MasterData\App\Models\Employee;
use Modules\MasterData\App\Models\Department;
use Modules\MasterData\App\Models\SubDepartment;
use Modules\MasterData\App\Models\Unit;
use Modules\MasterData\App\Models\Position;

class Patient extends Model
{
    use HasFactory, HasCustomCode; // Perbaiki typo 'hasFactory'
    protected $table = 'sc_master.patients';

    protected $fillable = [
        'code',
        'nik',
        'ktp',
        'bag_dept',
        'subbag_dept',
        'sub_subbag_dept',
        'jabatan', 
        'name', 
        'gender', 
        'birth_date', 
        'alamat', // Sesuai migration (sebelumnya 'alamat' itu punya karyawan)
        'phone',
        'blood_type', 
        'allergies', 
        'type', 
        'employee_id', 
        'family_of_employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getPrefix(): string
    {
        return 'PAS'; 
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

}