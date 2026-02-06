<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StockOpname extends Model
{
    protected $table = 'sc_inventory.stock_opnames';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(StockOpnameItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}