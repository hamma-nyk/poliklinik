<?php

namespace Modules\Clinical\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Clinical\App\Models\MedicalRecord;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransactionItem;
use Modules\Clinical\App\Models\LabCheck;

class ReportController extends Controller
{
    // Halaman Menu Utama Laporan
    public function index()
    {
        return view('clinical::reports.index');
    }

    // --- 1. LAPORAN KUNJUNGAN ---
    public function visits(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate   = $request->end_date ?? date('Y-m-d');

        $poliData = MedicalRecord::with(['patient', 'doctor', 'diagnosis'])
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->latest()
                ->get()
                ->map(function($item) {
                $item->jenis_kunjungan = 'Poli Umum';
                return $item;
            });

        $labData = LabCheck::with(['patient', 'doctor', 'nurse'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get()
            ->map(function($item) {
                $item->jenis_kunjungan = 'Cek Lab';
                $item->diagnosis = null; // Lab tidak ada diagnosa
                return $item;
            });

        $data = $poliData->concat($labData)->sortByDesc('created_at');

        if ($request->action == 'pdf') {
            $pdf = Pdf::loadView('clinical::reports.pdf_visits', compact('data', 'startDate', 'endDate'));
            return $pdf->setPaper('a4', 'landscape')->stream('Laporan-Kunjungan.pdf');
        }

        return view('clinical::reports.visits', compact('data', 'startDate', 'endDate'));
    }

    // --- 2. LAPORAN 10 BESAR PENYAKIT ---
    public function diseases(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate   = $request->end_date ?? date('Y-m-d');

        // 1. Ambil Top 10 Penyakit
        $data = MedicalRecord::select('diagnosis_id', DB::raw('count(*) as total'))
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->whereNotNull('diagnosis_id') // Hanya yang ada diagnosanya
                ->with('diagnosis')
                ->groupBy('diagnosis_id')
                ->orderByDesc('total')
                ->take(10)
                ->get();

        // 2. Hitung Total Seluruh Kasus (Untuk penyebut persentase)
        $grandTotal = MedicalRecord::whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->whereNotNull('diagnosis_id')
                ->count();

        // 3. Export PDF
        if ($request->action == 'pdf') {
            $pdf = Pdf::loadView('clinical::reports.pdf_diseases', compact('data', 'startDate', 'endDate', 'grandTotal'));
            return $pdf->stream('Top-10-Penyakit.pdf');
        }

        return view('clinical::reports.diseases', compact('data', 'startDate', 'endDate', 'grandTotal'));
    }

    // --- 3. LAPORAN PEMAKAIAN OBAT ---
    public function medicines(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate   = $request->end_date ?? date('Y-m-d');

        // Ambil item transaksi tipe 'out' (dari resep)
        // Kita perlu join tabel untuk filter tanggal transaksi
        $data = MedicineTransactionItem::whereHas('transaction', function($q) use ($startDate, $endDate) {
                    $q->where('type', 'out')
                      ->whereDate('transaction_date', '>=', $startDate)
                      ->whereDate('transaction_date', '<=', $endDate);
                })
                ->select('medicine_id', DB::raw('sum(quantity) as total_qty'))
                ->with('medicine')
                ->groupBy('medicine_id')
                ->orderByDesc('total_qty')
                ->get();

        if ($request->action == 'pdf') {
            $pdf = Pdf::loadView('clinical::reports.pdf_medicines', compact('data', 'startDate', 'endDate'));
            return $pdf->stream('Laporan-Obat.pdf');
        }

        return view('clinical::reports.medicines', compact('data', 'startDate', 'endDate'));
    }
    public function lowStock(Request $request)
    {
        // Ambil obat yang stoknya <= 10 (atau batas minimum lainnya)
        $limit = 10;
        
        $data = \Modules\Inventory\App\Models\Medicine::where('current_stock', '<=', $limit)
                ->orderBy('current_stock', 'asc')
                ->get();

        if ($request->action == 'pdf') {
            $pdf = Pdf::loadView('clinical::reports.pdf_low_stock', compact('data', 'limit'));
            return $pdf->stream('Laporan-Stok-Menipis.pdf');
        }

        // Kita bisa reuse view medicines atau buat baru, tapi lebih baik buat view sederhana baru
        return view('clinical::reports.low_stock', compact('data', 'limit'));
    }
    // --- 5. LAPORAN OBAT MASUK (Restock) ---
    public function incoming(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate   = $request->end_date ?? date('Y-m-d');

        $data = \Modules\Inventory\App\Models\MedicineTransactionItem::whereHas('transaction', function($q) use ($startDate, $endDate) {
                    $q->where('type', 'in')
                      ->whereDate('transaction_date', '>=', $startDate)
                      ->whereDate('transaction_date', '<=', $endDate);
                })
                ->select(
                    'medicine_id', 
                    DB::raw('sum(quantity) as total_qty'),
                    // TAMBAHAN: Hitung Total Rupiah (Qty * Harga saat itu)
                    DB::raw('sum(quantity * price_at_moment) as total_amount') 
                )
                ->with('medicine')
                ->groupBy('medicine_id')
                ->orderByDesc('total_qty')
                ->get();

        if ($request->action == 'pdf') {
            $pdf = Pdf::loadView('clinical::reports.pdf_incoming', compact('data', 'startDate', 'endDate'));
            return $pdf->stream('Laporan-Obat-Masuk.pdf');
        }

        return view('clinical::reports.incoming', compact('data', 'startDate', 'endDate'));
    }
    // --- 6. LAPORAN MUTASI (KELUAR - MASUK) ---
    public function mutation(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate   = $request->end_date ?? date('Y-m-d');

        // Ambil Semua Obat
        // Hitung total 'in' dan 'out' berdasarkan relasi transactionItems -> transaction
        $data = \Modules\Inventory\App\Models\Medicine::orderBy('name')
            ->withSum(['transactionItems as total_in' => function($query) use ($startDate, $endDate) {
                $query->whereHas('transaction', function($q) use ($startDate, $endDate) {
                    $q->where('type', 'in')
                      ->whereDate('transaction_date', '>=', $startDate)
                      ->whereDate('transaction_date', '<=', $endDate);
                });
            }], 'quantity')
            ->withSum(['transactionItems as total_out' => function($query) use ($startDate, $endDate) {
                $query->whereHas('transaction', function($q) use ($startDate, $endDate) {
                    $q->where('type', 'out')
                      ->whereDate('transaction_date', '>=', $startDate)
                      ->whereDate('transaction_date', '<=', $endDate);
                });
            }], 'quantity')
            ->get();

        // Filter: Hanya tampilkan obat yang ada pergerakan (biar tabel gak penuh nol)
        // Jika ingin tampilkan semua, hapus bagian filter ini
        $data = $data->filter(function($item) {
            return $item->total_in > 0 || $item->total_out > 0;
        });

        if ($request->action == 'pdf') {
            $pdf = Pdf::loadView('clinical::reports.pdf_mutation', compact('data', 'startDate', 'endDate'));
            return $pdf->setPaper('a4', 'portrait')->stream('Laporan-Mutasi-Stok.pdf');
        }

        return view('clinical::reports.mutation', compact('data', 'startDate', 'endDate'));
    }
}