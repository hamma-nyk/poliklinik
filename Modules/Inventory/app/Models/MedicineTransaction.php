<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasCustomCode;
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\MasterData\App\Models\Supplier; // Import Model RM
use Modules\Clinical\App\Models\LabCheck;
class MedicineTransaction extends Model
{
    use HasFactory, HasCustomCode;
    protected $table = 'sc_inventory.medicine_transactions';
    protected $fillable = ['code', 'type', 'transaction_date', 'notes', 'medical_record_id','invoice_number', // No Faktur
    'lab_check_id',
    'supplier_id',    
    'invoice_date',   // Tgl Faktur
        'arrival_date',
        'created_by', // <--- Wajib didaftarkan di sini
        'updated_by', // <--- Wajib didaftarkan di sini
        ];

    protected $casts = [
        'invoice_date' => 'date',
        'arrival_date' => 'date',
        'transaction_date' => 'date',
    ];

    // Relasi ke Item
    public function items()
    {
        return $this->hasMany(MedicineTransactionItem::class);
    }
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }
    public function getPrefix(): string
    {
        // Prefix dinamis: OBI (In) atau OBO (Out)
        return $this->type === 'in' ? 'OBI' : 'OBO';
    }
    public function supplier()
    {
        // Gunakan Class dari MasterData
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function labCheck()
    {
        return $this->belongsTo(LabCheck::class, 'lab_check_id');
    }
    
}