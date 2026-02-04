<?php
namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'sc_master.units';
    protected $fillable = ['code', 'name'];
}