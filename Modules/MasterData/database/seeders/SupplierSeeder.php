<?php

namespace Modules\MasterData\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\MasterData\App\Models\Supplier;
class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $realSuppliers = [
            [
                'name' => 'PT. Kimia Farma Trading',
                'phone' => '021-3847382',
                'email' => 'sales@kimiafarma.co.id',
                'contact_person' => 'Budi Santoso',
                'address' => 'Jl. Budi Utomo No. 1, Jakarta Pusat',
                'city' => 'Jakarta Pusat',
            ],
            [
                'name' => 'PT. Anugerah Pharmindo Lestari (APL)',
                'phone' => '021-7892311',
                'email' => 'cs@apl.com',
                'contact_person' => 'Siti Aminah',
                'address' => 'Jl. Pulo Lentut, Kawasan Industri Pulogadung',
                'city' => 'Jakarta Timur',
            ],
            [
                'name' => 'CV. Sumber Sehat Makmur',
                'phone' => '0812-3344-5566',
                'email' => 'sumbersehat@gmail.com',
                'contact_person' => 'Pak Haji Dulah',
                'address' => 'Jl. Raya Bogor KM 30',
                'city' => 'Depok',
            ],
        ];

        foreach ($realSuppliers as $sup) {
            // firstOrCreate: Cek dulu biar gak duplikat kalau seeder dijalankan 2x
            Supplier::firstOrCreate( // Cek berdasarkan kode
                $sup // Data yang diinsert
            );
        }
    }
}
