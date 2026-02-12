<?php

namespace Modules\Inventory\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\MedicineTransaction;
use Modules\MasterData\App\Models\Supplier;

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
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $medicines = Medicine::orderBy('name')->get();
        return view('inventory::transactions.create', compact('medicines', 'suppliers'));
    }

    /**
     * Proses Simpan Transaksi
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            // 'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            
            // A. Validasi Khusus Barang Masuk (IN) -> Wajib ada Faktur
            // 'invoice_number' => 'required_if:type,in|nullable|string',
            //'invoice_date'   => 'required_if:type,in|nullable|date',
            //'arrival_date'   => 'required_if:type,in|nullable|date',
            //'supplier_id'    => 'required_if:type,in|nullable|exists:suppliers,id', // Jika ada supplier

            //B. Validasi Khusus Barang Keluar (OUT - Rekam Medis) -> Wajib ada ID Rekam Medis
            //'medical_record_id' => 'nullable|exists:medical_records,id',

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
                $isIncoming = $request->type === 'in';
                $transaction = MedicineTransaction::create([
                    'type' => $request->type,
                    'transaction_date' => $request->transaction_date ?? $request->arrival_date,
                    'notes' => $request->notes,
                    
                    // Data Supplier (Hanya jika IN)
                    'invoice_number' => $isIncoming ? $request->invoice_number : null,
                    'invoice_date'   => $isIncoming ? $request->invoice_date : null,
                    'arrival_date'   => $isIncoming ? $request->arrival_date : null,
                    'supplier_id'    => $isIncoming ? $request->supplier_id : null,

                    // Data Pasien (Hanya jika OUT / Rekam Medis)
                    'medical_record_id' => $request->medical_record_id ?? null,
                    'created_by' => auth()->id(),
                ]);
                // dd($transaction);
                // 2. Buat Detail Items
                foreach ($request->items as $item) {
                // Cek Stok dulu jika barang keluar! (PENTING)
                    if (!$isIncoming) {
                        $medicine = \App\Models\Medicine::find($item['medicine_id']);
                        if ($medicine->current_stock < $item['quantity']) {
                            throw new \Exception("Stok obat {$medicine->name} tidak mencukupi. Sisa: {$medicine->current_stock}");
                        }
                    }
                    $transaction->items()->create([
                        'medicine_id' => $item['medicine_id'],
                        'quantity' => $item['quantity'],
                        // Jika IN pakai harga input, Jika OUT biasanya harga jual (ambil dari master obat atau input)
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