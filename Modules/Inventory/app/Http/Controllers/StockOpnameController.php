<?php

namespace Modules\Inventory\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventory\App\Models\Medicine;
use Modules\Inventory\App\Models\StockOpname;
use Modules\Inventory\App\Models\StockOpnameItem;
use Modules\Inventory\App\Models\MedicineTransaction;
use Modules\Inventory\App\Models\MedicineTransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $query = StockOpname::with('creator')->latest();

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('opname_number', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }
        
        // UBAH BAGIAN INI: Ambil nilai 'per_page' dari request, default ke 10 jika kosong
        $perPage = $request->input('per_page', 10);
        
        $opnames = $query->paginate($perPage);
        
        return view('inventory::stock_opnames.index', compact('opnames'));
    }

    public function create()
    {
        // Ambil semua obat untuk dilist di form opname
        $medicines = Medicine::orderBy('name')->get();
        
        // Generate No Opname Otomatis (SO-TahunBulan-Urut)
        $count = StockOpname::whereYear('created_at', date('Y'))->count() + 1;
        $opnameNumber = 'SO-' . date('Ym') . '' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('inventory::stock_opnames.create', compact('medicines', 'opnameNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'opname_date' => 'required|date',
            'items'       => 'required|array', // Array Input Fisik
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Header Stok Opname
            $opname = StockOpname::create([
                'opname_number' => $request->opname_number,
                'opname_date'   => $request->opname_date,
                'notes'         => $request->notes,
                'created_by'    => Auth::id(),
            ]);

            // Persiapan Transaksi Penyesuaian Otomatis
            $adjustmentInItems = [];
            $adjustmentOutItems = [];

            foreach ($request->items as $medicineId => $data) {
                $systemStock = $data['system_stock'];
                $physicalStock = $data['physical_stock'];
                $difference = $physicalStock - $systemStock;

                // 2. Simpan Detail Opname (Hanya history)
                StockOpnameItem::create([
                    'stock_opname_id' => $opname->id,
                    'medicine_id'     => $medicineId,
                    'system_stock'    => $systemStock,
                    'physical_stock'  => $physicalStock,
                    'difference'      => $difference,
                ]);

                // 3. Logic Penyesuaian Stok (Hanya jika ada selisih)
                if ($difference != 0) {
                    $itemData = [
                        'medicine_id' => $medicineId,
                        'quantity'    => abs($difference), // Selalu positif untuk transaksi
                        'price_at_moment' => 0, // Opname biasanya tidak mengubah valuasi harga beli, atau ambil harga beli terakhir
                    ];

                    if ($difference > 0) {
                        // Fisik LEBIH BANYAK dari Sistem -> Masuk (Adjustment In)
                        $adjustmentInItems[] = $itemData;
                    } else {
                        // Fisik LEBIH SEDIKIT dari Sistem -> Keluar (Adjustment Out)
                        $adjustmentOutItems[] = $itemData;
                    }
                }
            }

            // 4. Eksekusi Buat Transaksi Inventory (Agar Kartu Stok Update)
            
            // Jika ada barang berlebih (Adjustment Plus)
            if (!empty($adjustmentInItems)) {
                $trxIn = MedicineTransaction::create([
                    'transaction_date' => $request->opname_date,
                    'type'             => 'in',
                    'notes'            => 'Penyesuaian Stok Opname: ' . $opname->opname_number . ' (Surplus)',
                ]);
                foreach ($adjustmentInItems as $item) {
                    $item['medicine_transaction_id'] = $trxIn->id;
                    MedicineTransactionItem::create($item);
                }
            }

            // Jika ada barang hilang (Adjustment Minus)
            if (!empty($adjustmentOutItems)) {
                $trxOut = MedicineTransaction::create([
                    'transaction_date' => $request->opname_date,
                    'type'             => 'out',
                    'notes'            => 'Penyesuaian Stok Opname: ' . $opname->opname_number . ' (Defisit)',
                ]);
                foreach ($adjustmentOutItems as $item) {
                    $item['medicine_transaction_id'] = $trxOut->id;
                    MedicineTransactionItem::create($item);
                }
            }
        });

        return redirect()->route('inventory.stock-opnames.index')->with('success', 'Stok Opname berhasil disimpan & Stok telah disesuaikan.');
    }

    public function show($id)
    {
        $opname = StockOpname::with(['items.medicine', 'creator'])->findOrFail($id);
        return view('inventory::stock_opnames.show', compact('opname'));
    }
}