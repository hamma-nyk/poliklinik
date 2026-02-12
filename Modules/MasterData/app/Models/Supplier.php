<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // <--- Import Ini
use App\Traits\HasCustomCode;
class Supplier extends Model
{
    use HasFactory,HasCustomCode, SoftDeletes; // <--- Pakai Trait Ini

    protected $table = 'suppliers';
    
    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'contact_person',
        'address',
        'city'
    ];

    // Relasi ke Transaksi Inventory (Optional, buat cek history)
    public function transactions()
    {
        return $this->hasMany(\Modules\Inventory\App\Models\MedicineTransaction::class, 'supplier_id');
    }

    public function getPrefix(): string
    {
        return 'SUP'; 
    }
}