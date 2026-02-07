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
    public function index()
    {
        $today = date('Y-m-d');

        // Hitung Data Hari Ini
        $rmToday = MedicalRecord::whereDate('created_at', $today)->count();
        $labToday = LabCheck::whereDate('created_at', $today)->count();
        
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

        // --- DATA GRAFIK (TREN 7 HARI) ---
        $chartVisits = [];
        $chartDates = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartDates[] = $date->format('d M');
            
            $d_rm = MedicalRecord::whereDate('created_at', $date->format('Y-m-d'))->count();
            $d_lab = LabCheck::whereDate('created_at', $date->format('Y-m-d'))->count();
            
            $chartVisits[] = $d_rm + $d_lab;
        }

        // --- DATA GRAFIK (TOP 5 PENYAKIT) ---
        $topDiseases = MedicalRecord::select('diagnosis_id', DB::raw('count(*) as total'))
            ->whereNotNull('diagnosis_id')
            ->with('diagnosis')
            ->groupBy('diagnosis_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        $chartDiseaseLabels = $topDiseases->map(fn($item) => $item->diagnosis->name ?? '-')->toArray();
        $chartDiseaseData   = $topDiseases->pluck('total')->toArray();

        // --- TABEL DATA TERBARU ---
        $latestRecords = MedicalRecord::with(['patient', 'doctor', 'nurse'])->latest()->take(5)->get();
        $criticalMedicines = Medicine::where('current_stock', '<=', 10)->orderBy('current_stock', 'asc')->take(5)->get();

        return view('dashboard', compact(
            'stats', 
            'chartDates', 'chartVisits', 
            'chartDiseaseLabels', 'chartDiseaseData',
            'latestRecords', 'criticalMedicines'
        ));
    }
}