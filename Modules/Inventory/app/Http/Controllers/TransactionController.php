<?php

namespace Modules\Inventory\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransaction;

class TransactionController extends Controller
{
    /**
     * Halaman History Transaksi (Masuk & Keluar)
     */
    public function index(Request $request)
    {
        // 1. Ambil input per_page (default 10 jika tidak ada)
        $perPage = $request->input('per_page', 10);

        // 2. Mulai Query (Eager Load 'items' agar query ringan)
        $query = MedicineTransaction::with('items.medicine')->latest();

        // 3. Logic SEARCH (Cari berdasarkan Kode Transaksi atau Catatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'ilike', '%' . $search . '%')
                  ->orWhere('notes', 'ilike', '%' . $search . '%');
            });
        }

        // 4. Logic FILTER TIPE (In / Out)
        if ($request->filled('type')) {
            // Hanya jalankan jika value-nya valid 'in' atau 'out'
            if (in_array($request->type, ['in', 'out'])) {
                $query->where('type', $request->type);
            }
        }

        // 5. Eksekusi Pagination
        // withQueryString() PENTING agar filter tidak hilang saat pindah halaman
        $transactions = $query->paginate($perPage)->withQueryString();

        return view('inventory::transactions.index', compact('transactions'));
    }

    /**
     * Halaman Form Input Transaksi Baru
     */
    public function create()
    {
        // Ambil data obat untuk dropdown
        $medicines = Medicine::orderBy('name')->get();
        return view('inventory::transactions.create', compact('medicines'));
    }

    /**
     * Proses Simpan Transaksi
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            // Validasi Array Items
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => [
                'required', 
                Rule::exists(Medicine::class, 'id') 
            ],
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'nullable|numeric|min:0', // Harga beli (jika in)
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Buat Header Transaksi
                // Code otomatis digenerate oleh Trait (OBI... / OBO...)
                $transaction = MedicineTransaction::create([
                    'type' => $request->type,
                    'transaction_date' => $request->transaction_date,
                    'notes' => $request->notes,
                ]);

                // 2. Buat Detail Items
                foreach ($request->items as $item) {
                    // Logic update stok otomatis berjalan via Observer 
                    // saat baris ini dieksekusi:
                    $transaction->items()->create([
                        'medicine_id' => $item['medicine_id'],
                        'quantity' => $item['quantity'],
                        'price_at_moment' => $item['price'] ?? 0,
                    ]);
                }
            });

            return redirect()->route('inventory.transactions.index')
                ->with('success', 'Transaksi berhasil disimpan & Stok diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Lihat Detail Transaksi
     */
    public function show($id)
    {
        $transaction = MedicineTransaction::with('items.medicine')->findOrFail($id);
        return view('inventory::transactions.show', compact('transaction'));
    }
}