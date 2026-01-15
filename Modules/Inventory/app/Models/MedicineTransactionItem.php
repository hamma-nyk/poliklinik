<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineTransactionItem extends Model
{
    protected $table = 'sc_inventory.medicine_transaction_items';
    protected $fillable = ['medicine_transaction_id', 'medicine_id', 'quantity', 'price_at_moment'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class)->withTrashed();
    }
    public function transaction()
    {
        // Parameter ke-2 'medicine_transaction_id' wajib jika nama tidak standar
        return $this->belongsTo(MedicineTransaction::class, 'medicine_transaction_id');
    }
}