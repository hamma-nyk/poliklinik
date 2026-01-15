<?php
namespace Modules\MasterData\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomCode;
class Nurse extends Model
{
    use HasCustomCode;
    protected $table = 'sc_master.nurses';
    protected $fillable = ['code','name', 'nik_ktp', 'str', 'phone', 'is_active'];
    public function getPrefix(): string
    {
        return 'PER'; // Hasil: PAS2026010001
    }
}