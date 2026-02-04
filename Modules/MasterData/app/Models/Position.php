<?php
namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'sc_master.positions';
    protected $fillable = ['code', 'name'];
}