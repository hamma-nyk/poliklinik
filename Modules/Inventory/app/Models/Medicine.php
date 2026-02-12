<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCustomCode;

class Medicine extends Model
{
    use HasFactory, SoftDeletes, HasCustomCode;
    protected $table = 'sc_inventory.medicines';
    protected $fillable = ['code', 'name', 'unit', 'price', 'current_stock', 'description','created_by','updated_by'];

    public function getPrefix(): string
    {
        return 'OB'; // Prefix Obat: OB2026...
    }

    public function transactionItems()
    {
        return $this->hasMany(MedicineTransactionItem::class, 'medicine_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}