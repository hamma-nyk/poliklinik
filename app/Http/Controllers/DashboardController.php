<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// Import Model-Model Modul
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\Clinical\App\Models\LabCheck;
use Modules\Inventory\App\Models\Medicine;
use Modules\MasterData\App\Models\Patient;
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse;
use Modules\MasterData\App\Models\Diagnosis;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
// 1. FILTER INPUT (Default: Bulan & Tahun Sekarang)
        $month = (int) $request->input('month', date('m'));
        $year  = (int) $request->input('year', date('Y'));
        $today = date('Y-m-d');

        // Hitung Data Hari Ini
        $rmToday = MedicalRecord::whereDate('created_at', $today)->count();
        $labToday = LabCheck::whereDate('created_at', $today)->count();
        // ==========================================
        // A. DATA GRAFIK TREND HARIAN (Line Chart)
        // ==========================================
        
        // Buat array tanggal 1 s/d akhir bulan (agar grafik tidak bolong)
        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $trendLabels = [];
        $trendData   = [];
        
        // Ambil data real dari DB dikelompokkan per hari
        $dailyVisits = MedicalRecord::selectRaw('EXTRACT(DAY FROM created_at) as day, count(*) as count') // <--- Ganti di sini
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('day')
            ->pluck('count', 'day')
            ->toArray();

        // Loop tanggal 1..30/31
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $trendLabels[] = $i; // Label X-Axis (Tanggal)
            $trendData[]   = $dailyVisits[$i] ?? 0; // Data Y-Axis (Jumlah Pasien)
        }

        // ==========================================
        // B. DATA K3: SAKIT vs KECELAKAAN (Donut Chart)
        // ==========================================
        $visitTypes = MedicalRecord::selectRaw('visit_type, count(*) as count')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('visit_type')
            ->pluck('count', 'visit_type')
            ->toArray();

        $sakitCount = $visitTypes['sakit'] ?? 0;
        $kecelakaanCount = $visitTypes['kecelakaan_kerja'] ?? 0;

        // ==========================================
        // C. DATA TOP 5 DIAGNOSA (Bar Chart)
        // ==========================================
        // Asumsi: Anda menyimpan diagnosa di tabel `medical_records` kolom `diagnosa_input` (string)
        // Jika pakai relasi ID, sesuaikan join-nya.
        
        $topDiagnosesRaw = MedicalRecord::select('diagnosa', DB::raw('count(*) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereNotNull('diagnosa') // Pastikan tidak null
            ->groupBy('diagnosa')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $diagLabels = $topDiagnosesRaw->pluck('diagnosa')->toArray(); // Nama Penyakit
        $diagData   = $topDiagnosesRaw->pluck('total')->toArray(); // Jumlah Kasus

        // ==========================================
        // D. DATA OPERASIONAL (Tabel Bawah)
        // ==========================================

        // 1. 5 Pasien Terakhir (Hari ini/Bulan ini terserah, disini saya ambil latest global)
        $latestRecords = MedicalRecord::with('patient')
            ->latest()
            ->take(5)
            ->get();

        // 2. Stok Obat Kritis (<= 10)
        $criticalMedicines = Medicine::where('current_stock', '<=', 10)
            ->orderBy('current_stock', 'asc')
            ->take(5) // Ambil 5 terparah
            ->get();

        $stats = [
            // --- AKTIVITAS HARI INI ---
            'today_activity' => $rmToday + $labToday, // Total Gabungan
            'today_rm'       => $rmToday,
            'today_lab'      => $labToday,

            // --- TOTAL KESELURUHAN (MASTER & ARSIP) ---
            'total_patients'  => Patient::count(),
            'total_doctors'   => Doctor::count(),
            'total_nurses'    => Nurse::count(),
            'total_diseases'  => Diagnosis::count(), // Jenis Penyakit (ICD-10)
            'total_medicines' => Medicine::count(),
            'total_records'   => MedicalRecord::count(), // Arsip Poli
            'total_lab_logs'  => LabCheck::count(),      // Arsip Lab
        ];

        return view('dashboard', compact(
            'month', 'year',
            'trendLabels', 'trendData',
            'sakitCount', 'kecelakaanCount',
            'diagLabels', 'diagData',
            'latestRecords', 'criticalMedicines',
            'stats'
        ));
    }
}