<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasCustomCode
{
    protected static function bootHasCustomCode()
    {
        static::creating(function ($model) {
            // 1. Ambil prefix yang didefinisikan di Model (misal: DK, PR, OB)
            $prefix = $model->getPrefix();
            
            // 2. Tentukan format waktu (TahunBulan -> 202601)
            $dateCode = now()->format('Ym');
            
            // 3. Gabungkan Prefix + Tanggal (DK202601)
            $baseCode = $prefix . $dateCode;
            
            // 4. Cari kode terakhir di database yang mirip dengan baseCode
            // Kita gunakan locking 'forUpdate' agar aman jika ada input bersamaan
            $lastRecord = DB::table($model->getTable())
                ->where('code', 'like', $baseCode . '%')
                ->orderBy('code', 'desc')
                ->lockForUpdate() 
                ->first();

            if ($lastRecord) {
                // Ambil 3 digit terakhir dari kode terakhir
                $lastSequence = (int) substr($lastRecord->code, -4);
                $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
            } else {
                // Jika belum ada, mulai dari 001
                $newSequence = '0001';
            }

            // 5. Set kode ke kolom 'code'
            $model->code = $baseCode . $newSequence;
        });
    }

    // Setiap model wajib punya fungsi ini
    abstract public function getPrefix(): string;
}