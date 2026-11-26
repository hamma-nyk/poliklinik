<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    protected $table = 'sc_inventory.stock_opname_items';
    protected $guarded = [];

    public function medicine()
    {
		return $this->belongsTo(Medicine::class, 'medicine_id')->withTrashed();
	}
}