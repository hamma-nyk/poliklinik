<?php

namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $connection = 'pgsql'; // Sesuaikan DB Anda
    protected $table = 'sc_master.diagnoses';
    protected $fillable = ['code', 'name'];
}