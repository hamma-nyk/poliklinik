<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasCustomCode;
use Modules\Clinical\App\Models\MedicalRecord; // Import Model RM
class MedicineTransaction extends Model
{
    use HasFactory, HasCustomCode;
    protected $table = 'sc_inventory.medicine_transactions';
    protected $fillable = ['code', 'type', 'transaction_date', 'notes', 'medical_record_id'];

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
}