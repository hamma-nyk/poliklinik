<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan Huruf Besar
use App\Traits\HasCustomCode;

class Patient extends Model
{
    use HasFactory, HasCustomCode; // Perbaiki typo 'hasFactory'
    protected $table = 'sc_master.patients';

    protected $fillable = [
        'code',
        'nik',
        'ktp',
        'subbag_dept', 
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
}