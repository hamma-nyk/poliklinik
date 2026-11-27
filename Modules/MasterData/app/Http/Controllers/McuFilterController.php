<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\MasterData\App\Exports\McuFilterExport;
use PhpOffice\PhpSpreadsheet\IOFactory;

class McuFilterController extends Controller
{
    public function index()
    {
        return view('masterdata::mcu_filter.index', [
            'result' => session('mcu_filter_result'),
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'master_file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
            'mcu_file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ], [
            'master_file.required' => 'File Excel 1 (Master Data) wajib diupload.',
            'mcu_file.required' => 'File Excel 2 (List Sudah MCU) wajib diupload.',
        ]);

        $masterSheet = $this->parseSpreadsheet($request->file('master_file')->getRealPath());
        $mcuSheet = $this->parseSpreadsheet($request->file('mcu_file')->getRealPath());

        if (empty($masterSheet['rows'])) {
            return back()->withErrors(['master_file' => 'File Excel 1 (Master Data) tidak memiliki data baris.']);
        }
        if (empty($mcuSheet['rows'])) {
            return back()->withErrors(['mcu_file' => 'File Excel 2 (List Sudah MCU) tidak memiliki data baris.']);
        }

        $masterNikIdx = $this->detectColumnIndex($masterSheet['headers'], ['nik', 'no_induk', 'no induk', 'nip', 'ktp', 'no_ktp', 'no ktp', 'id_karyawan', 'id karyawan']);
        $masterNameIdx = $this->detectColumnIndex($masterSheet['headers'], ['nama', 'name', 'nama_karyawan', 'nama karyawan', 'karyawan', 'peserta', 'employee']);

        $mcuNikIdx = $this->detectColumnIndex($mcuSheet['headers'], ['nik', 'no_induk', 'no induk', 'nip', 'ktp', 'no_ktp', 'no ktp', 'id_karyawan', 'id karyawan']);
        $mcuNameIdx = $this->detectColumnIndex($mcuSheet['headers'], ['nama', 'name', 'nama_karyawan', 'nama karyawan', 'karyawan', 'peserta', 'employee']);

        if ($masterNikIdx === null && $masterNameIdx === null) {
            return back()->withErrors(['master_file' => 'Kolom NIK atau Nama tidak ditemukan di header Excel 1 (Master Data).']);
        }
        if ($mcuNikIdx === null && $mcuNameIdx === null) {
            return back()->withErrors(['mcu_file' => 'Kolom NIK atau Nama tidak ditemukan di header Excel 2 (List Sudah MCU).']);
        }

        $alreadyNiks = [];
        $alreadyNames = [];

        foreach ($mcuSheet['rows'] as $row) {
            if ($mcuNikIdx !== null) {
                $nik = $this->normalizeNik($row[$mcuNikIdx] ?? '');
                if ($nik !== '') {
                    $alreadyNiks[$nik] = true;
                }
            }
            if ($mcuNameIdx !== null) {
                $name = $this->normalizeName($row[$mcuNameIdx] ?? '');
                if ($name !== '') {
                    $alreadyNames[$name] = true;
                }
            }
        }

        $eligibleRows = [];
        $excludedRows = [];

        foreach ($masterSheet['rows'] as $row) {
            $nikVal = $masterNikIdx !== null ? ($row[$masterNikIdx] ?? '') : '';
            $nameVal = $masterNameIdx !== null ? ($row[$masterNameIdx] ?? '') : '';

            $normNik = $this->normalizeNik($nikVal);
            $normName = $this->normalizeName($nameVal);

            $matchedNik = $normNik !== '' && isset($alreadyNiks[$normNik]);
            $matchedName = $normName !== '' && isset($alreadyNames[$normName]);

            if ($matchedNik || $matchedName) {
                $reason = match (true) {
                    $matchedNik && $matchedName => 'NIK & Nama cocok',
                    $matchedNik => 'NIK cocok',
                    default => 'Nama cocok',
                };
                $excludedRows[] = [
                    'data' => $row,
                    'reason' => $reason,
                ];
            } else {
                $eligibleRows[] = $row;
            }
        }

        $result = [
            'headers' => $masterSheet['headers'],
            'master_count' => count($masterSheet['rows']),
            'mcu_count' => count($mcuSheet['rows']),
            'eligible_count' => count($eligibleRows),
            'excluded_count' => count($excludedRows),
            'eligible_rows' => $eligibleRows,
            'excluded_rows' => $excludedRows,
            'master_filename' => $request->file('master_file')->getClientOriginalName(),
            'mcu_filename' => $request->file('mcu_file')->getClientOriginalName(),
        ];

        session(['mcu_filter_result' => $result]);

        return redirect()->route('master.mcu-filter.index')
            ->with('success', "Filter selesai: {$result['eligible_count']} peserta boleh ikut MCU, {$result['excluded_count']} peserta dikeluarkan karena sudah MCU.");
    }

    public function export()
    {
        $result = session('mcu_filter_result');
        if (!$result || empty($result['headers'])) {
            return redirect()->route('master.mcu-filter.index')
                ->with('error', 'Belum ada hasil filter untuk di-export. Silakan upload kedua file Excel terlebih dahulu.');
        }

        $filename = 'Hasil_Filter_MCU_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new McuFilterExport($result['headers'], $result['eligible_rows']),
            $filename
        );
    }

    protected function parseSpreadsheet(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $highestRow = $sheet->getHighestDataRow();
        $highestColumn = $sheet->getHighestDataColumn();
        $highestColIdx = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        $allRows = [];
        for ($r = 1; $r <= $highestRow; $r++) {
            $rowData = [];
            $hasValue = false;
            for ($c = 1; $c <= $highestColIdx; $c++) {
                $val = trim((string) $sheet->getCell([$c, $r])->getFormattedValue());
                if ($val !== '') {
                    $hasValue = true;
                }
                $rowData[] = $val;
            }
            if ($hasValue) {
                $allRows[] = $rowData;
            }
        }

        if (empty($allRows)) {
            return ['headers' => [], 'rows' => []];
        }

        // Find the first row that looks like a header containing NIK or Nama, fallback to row 0
        $headerIdx = 0;
        foreach ($allRows as $idx => $row) {
            if ($idx > 10) {
                break;
            }
            if (
                $this->detectColumnIndex($row, ['nik', 'no_induk', 'no induk', 'nip', 'ktp', 'no_ktp', 'no ktp']) !== null ||
                $this->detectColumnIndex($row, ['nama', 'name', 'nama_karyawan', 'nama karyawan']) !== null
            ) {
                $headerIdx = $idx;
                break;
            }
        }

        $headers = $allRows[$headerIdx];
        $rows = array_slice($allRows, $headerIdx + 1);

        return [
            'headers' => $headers,
            'rows' => $rows,
        ];
    }

    protected function detectColumnIndex(array $headers, array $candidates): ?int
    {
        foreach ($headers as $idx => $header) {
            $norm = preg_replace('/\s+/', ' ', mb_strtolower(trim((string) $header)));
            if ($norm === '') {
                continue;
            }
            foreach ($candidates as $cand) {
                if ($norm === $cand || str_contains($norm, $cand)) {
                    return $idx;
                }
            }
        }

        return null;
    }

    protected function normalizeNik(string $value): string
    {
        return mb_strtoupper(preg_replace('/\s+/', '', trim($value)));
    }

    protected function normalizeName(string $value): string
    {
        return mb_strtolower(preg_replace('/\s+/', ' ', trim($value)));
    }
}
