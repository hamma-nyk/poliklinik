<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Input Transaksi Stok') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan barang masuk (pembelian/hibah) dengan data supplier & faktur.</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors"><a href="{{ route('inventory.transactions.index') }}">Transaksi</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Pengadaan Obat</span>
            </div>
        </div>
    </x-slot>

    @php
        // 1. Format Data Supplier
        $supplierList = $suppliers->map(function($sup) {
            return [
                'id' => $sup->id,
                'name' => $sup->name, // Tetap simpan nama asli untuk display input
                'phone' => $sup->phone ?? '-',
                
                // Label untuk tampilan di dropdown (Misal: "PT. Kimia Farma (Jakarta)")
                'label' => $sup->name . ' (' . ($sup->city ?? 'Umum') . ')',
                
                // Text khusus untuk pencarian (gabungan nama, telepon, dan kota di-lowercase)
                'search_text' => strtolower($sup->name . ' ' . ($sup->phone ?? '') . ' ' . ($sup->city ?? ''))
            ];
        });

        // 2. Format Data Obat
        $medicineList = $medicines->map(function($med) {
            return [
                'id' => $med->id,
                'name' => $med->name,
                'unit' => $med->unit,
                'stock' => $med->current_stock,
                'code' => $med->code ?? '-',
                
                // Label lengkap: "KD001 - Paracetamol (Stok: 100 Tablet)"
                'label' => ($med->code ? $med->code . ' - ' : '') . $med->name . ' (Stok: ' . $med->current_stock . ' ' . $med->unit . ')',
                
                // Text pencarian (kode + nama)
                'search_text' => strtolower(($med->code ?? '') . ' ' . $med->name)
            ];
        });
    @endphp
    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300"
         x-data="transactionForm(
             {{ Js::from($suppliers) }}, 
             {{ Js::from($medicines) }}
         )">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventory.transactions.store') }}" method="POST" @submit.prevent="$el.submit()">
                @csrf
                <input type="hidden" name="type" value="in">

                {{-- 1. Informasi Header (Supplier & Faktur) --}}
                <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8 mb-6">
                     <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-100 uppercase tracking-[0.2em] flex items-center mb-6">
                    <span class="bg-indigo-600 w-1.5 h-5 rounded-full mr-3"></span>
                   Informasi Supplier & Faktur
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        {{-- SEARCH SUPPLIER (Client Side) --}}
                        {{-- INPUT SUPPLIER (COMBO BOX) --}}
        <div class="relative z-1"> {{-- Z-index tinggi --}}
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Supplier <span class="text-red-500">*</span></label>
            
            <div class="relative">
                <input type="text" 
                       x-model="supplierQuery"
                       @input="filterSuppliers()"
                       @focus="showSupplierDropdown = true; filterSuppliers()" 
                       @click.outside="showSupplierDropdown = false"
                       class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 pr-10 focus:border-indigo-500 transition-all placeholder-slate-400 cursor-pointer"
                       placeholder="Pilih atau cari supplier..." 
                       autocomplete="off">
                
                {{-- Icon Panah Bawah (Visual Cue) --}}
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <input type="hidden" name="supplier_id" x-model="supplierId" required>

            {{-- DROPDOWN LIST --}}
            <div x-show="showSupplierDropdown" 
                 x-transition.opacity.duration.200ms
                 class="absolute w-full mt-1 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl shadow-2xl max-h-60 overflow-y-auto z-50">
                
                <ul class="py-1">
                    {{-- Opsi Default jika kosong --}}
                    <li x-show="filteredSuppliers.length === 0" class="px-4 py-3 text-sm text-slate-500 italic text-center">
                        Tidak ada supplier ditemukan.
                    </li>

                    <template x-for="sup in filteredSuppliers" :key="sup.id">
                        <li @click="selectSupplier(sup)" 
                            class="px-4 py-2.5 hover:bg-indigo-50 dark:hover:bg-slate-600 cursor-pointer border-b border-slate-50 dark:border-slate-600 last:border-0 transition-colors group">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-sm text-slate-700 dark:text-slate-200 group-hover:text-indigo-700" x-text="sup.name"></span>
                                <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full" x-text="sup.phone"></span>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

                        {{-- No Faktur --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">No. Faktur <span class="text-red-500">*</span></label>
                            <input type="text" name="invoice_number" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 transition-all" required placeholder="INV-001">
                        </div>

                        {{-- Tgl Faktur --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Tgl Faktur</label>
                            <input type="date" name="invoice_date" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 transition-all" required>
                        </div>

                        {{-- Tgl Datang --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Tgl Barang Datang</label>
                            <input type="date" name="arrival_date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 dark:border-emerald-700 dark:text-slate-100 focus:border-emerald-500 transition-all" required>
                            <span class="text-[10px] text-emerald-600 font-bold">Stok bertambah tgl ini</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Catatan Tambahan</label>
                        <input type="text" name="notes" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100" placeholder="Opsional">
                    </div>
                </div>

                {{-- 2. Daftar Obat (Searchable Items) --}}
                <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                         <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-100 uppercase tracking-[0.2em] flex items-center">
                    <span class="bg-emerald-500 w-1.5 h-5 rounded-full mr-3"></span>
                   Daftar Obat
                        </h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-sm font-bold rounded-xl border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah Baris
                        </button>
                    </div>

                    <div class="overflow-visible"> {{-- Visible agar dropdown tidak terpotong --}}
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-500 uppercase w-4/12">Nama Obat</th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-500 uppercase w-2/12">Satuan</th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-500 uppercase w-1/12">Jumlah</th>
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-500 uppercase w-2/12">Total Harga (Rp)</th> {{-- Kolom Baru --}}
                                    <th class="px-2 py-2 text-left text-xs font-bold text-slate-500 uppercase w-2/12">Harga Satuan (@)</th>
                                    <th class="w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="space-y-4">
    <template x-for="(item, index) in items" :key="index">
        <tr class="align-top">
            
            {{-- KOLOM OBAT (SEARCHABLE + CLEAR BUTTON) --}}
            <td class="p-2 relative w-5/12">
                <div class="relative">
                    <input type="text" 
                           x-model="item.query"
                           @input="item.showDropdown = true"
                           @focus="item.showDropdown = true" 
                           @click.outside="item.showDropdown = false"
                           class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 pr-10 text-sm focus:ring-2 focus:ring-indigo-500/20"
                           placeholder="Cari nama / kode obat..." 
                           autocomplete="off">
                    
                    {{-- 1. TOMBOL CLEAR (X) --}}
                    {{-- Muncul hanya jika ada teks --}}
                    <div x-show="item.query.length > 0" 
                         @click="clearMedicine(index)"
                         class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-slate-400 hover:text-red-500 transition-colors z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>

                    {{-- 2. ICON PANAH (Chevron) --}}
                    {{-- Muncul hanya jika input KOSONG --}}
                    <div x-show="item.query.length === 0" 
                         class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <input type="hidden" :name="'items['+index+'][medicine_id]'" x-model="item.medicine_id" required>

                {{-- DROPDOWN HASIL --}}
                <div x-show="item.showDropdown" 
                     class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl shadow-xl max-h-56 overflow-y-auto">
                    <ul class="py-1">
                        <template x-for="med in getFilteredMedicines(item.query)" :key="med.id">
                            <li @click="selectMedicine(index, med)" 
                                class="px-4 py-2.5 hover:bg-emerald-50 dark:hover:bg-slate-600 cursor-pointer border-b border-slate-50 dark:border-slate-600 last:border-0 group">
                                <div class="font-bold text-sm text-slate-700 dark:text-slate-200 group-hover:text-emerald-700" x-text="med.name"></div>
                                <div class="flex justify-between mt-0.5">
                                    <span class="text-xs text-slate-400 group-hover:text-emerald-600/70" x-text="med.code"></span>
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-100 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">Stok: <span x-text="med.current_stock"></span></span>
                                </div>
                            </li>
                        </template>

                        {{-- Pesan Kosong --}}
                        <li x-show="getFilteredMedicines(item.query).length === 0" class="px-4 py-3 text-xs text-slate-400 text-center italic">
                            Obat tidak ditemukan.
                        </li>
                    </ul>
                </div>
            </td>

            {{-- KOLOM SATUAN --}}
            <td class="p-2">
                <input type="text" x-model="item.unit" readonly class="w-full rounded-xl border-slate-200 bg-slate-100 text-slate-500 text-sm cursor-not-allowed text-center">
            </td>

            {{-- KOLOM JUMLAH --}}
            <td class="p-2">
                <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" min="1" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-100 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </td>

            {{-- TOTAL HARGA (INPUT MANUAL) --}}
            <td class="p-2">
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-slate-400 text-xs">Rp</span>
                    <input type="number" 
                           x-model="item.total_price" 
                           @input="updatePricePerItem(index)" {{-- Hitung saat total berubah --}}
                           class="w-full rounded-xl border-slate-200 pl-8 text-sm bg-blue-50/50" 
                           placeholder="8000">
                </div>
            </td>

            {{-- HARGA BELI (@) - OTOMATIS --}}
            <td class="p-2">
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-slate-400 text-xs">Rp</span>
                    <input type="number" 
                        :name="'items['+index+'][price]'" 
                        x-model="item.price" 
                        step="0.01"
                        readonly 
                        class="w-full rounded-xl border-slate-200 bg-slate-100 pl-8 text-sm font-bold text-indigo-600">
                </div>
            </td>

            <!-- {{-- KOLOM HARGA --}}
            <td class="p-2">
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-slate-400 text-xs">Rp</span>
                    <input type="number" :name="'items['+index+'][price]'" x-model="item.price" min="0" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-100 pl-8 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </td> -->

            {{-- TOMBOL HAPUS ROW --}}
            <td class="p-2 text-center pt-3">
                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-slate-400 hover:text-red-500 transition bg-transparent hover:bg-red-50 rounded-lg p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </td>
        </tr>
    </template>
</tbody>
                        </table>
                    </div>
                </div>

                {{-- Submission --}}
                <div class="mt-8 flex justify-end gap-4">
                    <a href="{{ route('inventory.transactions.index') }}" class="px-6 py-3 rounded-xl border border-slate-300 font-bold text-slate-600 hover:bg-slate-100 transition">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg transition">SIMPAN DATA</button>
                </div>
            </form>
        </div>
    </div>

<script>
    function transactionForm(suppliersData, medicinesData) {
        return {
            allSuppliers: suppliersData,
            allMedicines: medicinesData, // Data Mentah dari Controller
            
            supplierQuery: '',
            supplierId: '',
            filteredSuppliers: [],
            showSupplierDropdown: false,

            items: [
                { medicine_id: '', query: '', quantity: 1, price: 0, unit: '', showDropdown: false }
            ],

            init() {
                // Init data supplier
                this.filteredSuppliers = this.allSuppliers.slice(0, 10);
            },

            // --- SUPPLIER LOGIC ---
            filterSuppliers() {
                let q = this.supplierQuery.toLowerCase();
                if (q === '') {
                    this.filteredSuppliers = this.allSuppliers.slice(0, 10);
                } else {
                    this.filteredSuppliers = this.allSuppliers.filter(s => 
                        s.name.toLowerCase().includes(q)
                    ).slice(0, 10);
                }
            },
            selectSupplier(supplier) {
                this.supplierQuery = supplier.name;
                this.supplierId = supplier.id;
                this.showSupplierDropdown = false;
            },

            // --- MEDICINE / ITEM LOGIC ---
            
            // 1. Filter Obat
            getFilteredMedicines(query) {
                // Jika kosong, tampilkan 10 data awal (agar dropdown tidak blank)
                if (!query || query === '') {
                    return this.allMedicines.slice(0, 10);
                }

                let q = query.toLowerCase();
                
                // Cari berdasarkan Nama ATAU Kode
                return this.allMedicines.filter(m => 
                    m.name.toLowerCase().includes(q) || 
                    (m.code && m.code.toLowerCase().includes(q))
                ).slice(0, 10); // Limit 10 hasil agar ringan
            },

            // 2. Pilih Obat
            selectMedicine(index, medicine) {
                this.items[index].query = medicine.name;
                this.items[index].medicine_id = medicine.id;
                this.items[index].unit = medicine.unit || '-';
                this.items[index].showDropdown = false;
            },

            // 3. Clear Obat (Tombol X)
            clearMedicine(index) {
                this.items[index].query = '';
                this.items[index].medicine_id = '';
                this.items[index].unit = '';
                this.items[index].price = 0;
                // Tetap buka dropdown agar user bisa langsung cari lagi
                this.items[index].showDropdown = true; 
            },

            // FUNGSI HITUNG OTOMATIS
            updatePricePerItem(index) {
                let item = this.items[index];
                let qty = parseFloat(item.quantity) || 0;
                let total = parseFloat(item.total_price) || 0;

                if (qty > 0 && total > 0) {
                    // 1. Hitung pembagian
                    let result = total / qty;
                    
                    // 2. Ambil 2 angka di belakang koma
                    // Gunakan parseFloat lagi agar hasilnya bukan String
                    item.price = parseFloat(result.toFixed(2));
                } else {
                    item.price = 0;
                }
            },

            // 4. Tambah Baris
            addItem() {
                this.items.push({ medicine_id: '', query: '', quantity: 1, price: 0, unit: '', showDropdown: false });
            },

            // 5. Hapus Baris
            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            }
        }
    }
</script>
</x-app-layout>