<?php
namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    protected $table = 'sc_master.sub_departments';
    protected $fillable = ['code', 'name'];
}