<?php

namespace Modules\Inventory\App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StockAdjustmentPeriodExport implements FromView, WithColumnWidths, WithEvents
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('inventory::adjustments.print_period', [
            'items'      => $this->data,
            'start_date' => $this->startDate,
            'end_date'   => $this->endDate,
            'is_excel'   => true
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No
            'B' => 12,  // Tanggal
            'C' => 15,  // Kode Obat
            'D' => 40,  // Nama Obat
            'E' => 10,  // Satuan
            'F' => 12,  // Qty
            'G' => 30,  // Catatan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Styling Header
                $headerStyle = [
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ];
                $sheet->getStyle('A3:G3')->applyFromArray($headerStyle); // Asumsi header di baris 6
                $sheet->getStyle('A3:G'.$lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER, // <--- INI KUNCINYA
                    ],
                ]);
                // Border & Center Alignment
                $sheet->getStyle('A3:G'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A4:A'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B4:C'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F4:F'.$lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                // Warna Qty (Plus Hijau / Minus Merah)
                $row = 4; 
                
                foreach ($this->data as $item) {
                    // Ambil Type dari Parent Transaction
                    $type = $item->transaction->type; 
                    
                    // Ambil Cell Qty (Misal di Kolom F)
                    $cellCoordinate = 'F' . $row;

                    if ($type == 'out') {
                        // JIKA OUT: Merah
                        $sheet->getStyle($cellCoordinate)->getFont()->getColor()->setARGB('FFFF0000');
                        // Opsional: Ubah nilai jadi minus di excel biar bisa disum
                        $sheet->setCellValue($cellCoordinate, -abs($item->quantity));
                    } else {
                        // JIKA IN: Hijau
                        $sheet->getStyle($cellCoordinate)->getFont()->getColor()->setARGB('FF008000');
                        // Opsional: Pastikan plus
                        $sheet->setCellValue($cellCoordinate, abs($item->quantity));
                    }
                    
                    $row++;
                }
            }
        ];
    }
}