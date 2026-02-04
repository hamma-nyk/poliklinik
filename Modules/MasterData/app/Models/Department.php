<?php
namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'sc_master.departments';
    protected $fillable = ['code', 'name'];
}