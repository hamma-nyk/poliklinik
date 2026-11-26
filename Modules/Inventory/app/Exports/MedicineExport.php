<?php

namespace Modules\Inventory\App\Exports;

use Modules\Inventory\App\Models\Medicine; // Sesuaikan dengan namespace model Obat Anda
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MedicineExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * Mengambil data dari database
    */
    public function collection()
    {
        // Mengambil semua data obat yang tidak dihapus (aktif), urut berdasarkan nama
        return Medicine::orderBy('name', 'asc')->get();
    }

    /**
    * Membuat Header Excel
    */
    public function headings(): array
    {
        return [
            'No',
            'Kode Obat',
            'Nama Obat',
            // 'Kategori / Golongan',
            'Satuan',
            'Stok Saat Ini',
            'Terakhir Diupdate'
        ];
    }

    /**
    * Memetakan data ke setiap baris Excel
    */
    public function map($medicine): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $medicine->code,
            $medicine->name,
            // $medicine->category ?? '-', // Sesuaikan jika ada relasi/kolom kategori
            $medicine->unit,
            $medicine->current_stock, // Sesuaikan dengan nama kolom stok Anda
            $medicine->updated_at ? $medicine->updated_at->format('d/m/Y H:i') : '-',
        ];
    }

    /**
    * Memberikan styling dasar (Bold pada Header)
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris 1 (Header) dicetak tebal
            1 => ['font' => ['bold' => true]],
        ];
    }
}