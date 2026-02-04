<?php

namespace Modules\MasterData\App\Imports;

use Modules\MasterData\App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pastikan header di Excel: 'code' dan 'name'
        return Department::updateOrCreate(
            ['code' => $row['code']], // Kunci pencarian (agar tidak duplikat)
            ['name' => $row['name']]  // Data yang diupdate/insert
        );
    }
}