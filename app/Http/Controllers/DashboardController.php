<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import Model dari Module
use Modules\MasterData\App\Models\Doctor;
use Modules\MasterData\App\Models\Nurse; // Jika ada
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Data Master
        $totalDoctors = Doctor::count();
        // $totalNurses = Nurse::count(); // Aktifkan jika sudah buat model Nurse
        
        // 2. Data Obat
        $totalMedicines = Medicine::count();
        
        // 3. Cek Obat yang Stoknya Menipis (Misal di bawah 10)
        $lowStockMedicines = Medicine::where('current_stock', '<=', 10)
                                     ->orderBy('current_stock', 'asc')
                                     ->limit(5)
                                     ->get();
        
        // 4. Data Transaksi Hari Ini
        $transactionsToday = MedicineTransaction::whereDate('transaction_date', now())->count();

        // 5. Ambil 5 Transaksi Terakhir untuk Tabel History
        $latestTransactions = MedicineTransaction::with('items')
                                ->latest('created_at')
                                ->take(5)
                                ->get();

        // Karena modul Clinical/Rekam Medis belum kita buat lengkap,
        // kita set 0 dulu agar tidak error. Nanti diganti: MedicalRecord::count();
        $totalMedicalRecords = 0; 

        return view('dashboard', compact(
            'totalDoctors', 
            'totalMedicines', 
            'lowStockMedicines', 
            'transactionsToday',
            'latestTransactions',
            'totalMedicalRecords'
        ));
    }
}