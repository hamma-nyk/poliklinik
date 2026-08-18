<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-neutral-800 dark:text-neutral-100">
                    {{ __('Input Transaksi Stok') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Pencatatan barang masuk (pembelian/hibah) dengan data supplier & faktur.</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('inventory.transactions.index') }}">Transaksi</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Pengadaan Obat</span>
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
    <div class="py-6 flex-1 space-y-4"
         x-data="transactionForm(
             {{ Js::from($suppliers) }}, 
             {{ Js::from($medicines) }}
         )">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventory.transactions.store') }}" method="POST" @submit.prevent="$el.submit()">
                @csrf
                <input type="hidden" name="type" value="in">

                {{-- 1. Informasi Header (Supplier & Faktur) --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-8 mb-6">
                     <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                    <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                   Informasi Supplier & Faktur
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        {{-- SEARCH SUPPLIER (Client Side) --}}
                        {{-- INPUT SUPPLIER (COMBO BOX) --}}
        <div class="relative z-1"> {{-- Z-index tinggi --}}
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-1">Supplier <span class="text-destructive">*</span></label>
            
            <div class="relative">
                <input type="text" 
                       x-model="supplierQuery"
                       @input="filterSuppliers()"
                       @focus="showSupplierDropdown = true; filterSuppliers()" 
                       @click.outside="showSupplierDropdown = false"
                       class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300 pr-10 cursor-pointer"
                       placeholder="Pilih atau cari supplier..." 
                       autocomplete="off">
                
                {{-- Icon Panah Bawah (Visual Cue) --}}
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-neutral-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <input type="hidden" name="supplier_id" x-model="supplierId" required>

            {{-- DROPDOWN LIST --}}
            <div x-show="showSupplierDropdown" 
                 x-transition.opacity.duration.200ms
                 class="absolute w-full mt-1 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-600 rounded-md shadow-md max-h-60 overflow-y-auto z-50">
                
                <ul class="py-1">
                    {{-- Opsi Default jika kosong --}}
                    <li x-show="filteredSuppliers.length === 0" class="px-4 py-3 text-sm text-neutral-500 italic text-center">
                        Tidak ada supplier ditemukan.
                    </li>

                    <template x-for="sup in filteredSuppliers" :key="sup.id">
                        <li @click="selectSupplier(sup)" 
                            class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-neutral-100 hover:text-neutral-900 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <div class="flex justify-between items-center w-full">
                                <span class="font-medium" x-text="sup.name"></span>
                                <span class="text-xs text-neutral-500 dark:text-neutral-400 ml-2" x-text="sup.phone"></span>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

                        {{-- No Faktur --}}
                        <div>
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-1">No. Faktur <span class="text-destructive">*</span></label>
                            <input type="text" name="invoice_number" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required placeholder="INV-001">
                        </div>

                        {{-- Tgl Faktur --}}
                        <div>
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-1">Tgl Faktur</label>
                            <input type="date" name="invoice_date" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                        </div>

                        {{-- Tgl Datang --}}
                        <div>
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-1">Tgl Barang Datang</label>
                            <input type="date" name="arrival_date" value="{{ date('Y-m-d') }}" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" required>
                            <span class="text-[10px] text-emerald-600 font-bold">Stok bertambah tgl ini</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block mb-1">Catatan Tambahan</label>
                        <input type="text" name="notes" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300" placeholder="Opsional">
                    </div>
                </div>

                {{-- 2. Daftar Obat (Searchable Items) --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                         <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center mb-0">
                    <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                   Daftar Obat
                        </h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah Baris
                        </button>
                    </div>

                    <div class="overflow-visible"> {{-- Visible agar dropdown tidak terpotong --}}
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&_tr]:border-b">
                                <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-4/12">Nama Obat</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-2/12">Satuan</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-1/12">Jumlah</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-2/12">Total Harga (Rp)</th> {{-- Kolom Baru --}}
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-2/12">Harga Satuan (@)</th>
                                    <th class="w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0">
    <template x-for="(item, index) in items" :key="index">
        <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 align-top">
            
            {{-- KOLOM OBAT (SEARCHABLE + CLEAR BUTTON) --}}
            <td class="p-4 align-middle relative w-5/12">
                <div class="relative">
                    <input type="text" 
                           x-model="item.query"
                           @input="item.showDropdown = true"
                           @focus="item.showDropdown = true" 
                           @click.outside="item.showDropdown = false"
                           class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300 pr-8"
                           placeholder="Cari nama / kode obat..." 
                           autocomplete="off">
                    
                    {{-- 1. TOMBOL CLEAR (X) --}}
                    {{-- Muncul hanya jika ada teks --}}
                    <div x-show="item.query.length > 0" 
                         @click="clearMedicine(index)"
                         class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-neutral-400 hover:text-red-500 transition-colors z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>

                    {{-- 2. ICON PANAH (Chevron) --}}
                    {{-- Muncul hanya jika input KOSONG --}}
                    <div x-show="item.query.length === 0" 
                         class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-neutral-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <input type="hidden" :name="'items['+index+'][medicine_id]'" x-model="item.medicine_id" required>

                {{-- DROPDOWN HASIL --}}
                <div x-show="item.showDropdown" 
                     class="absolute z-50 w-full mt-1 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-600 rounded-md shadow-md max-h-56 overflow-y-auto">
                    <ul class="py-1">
                        <template x-for="med in getFilteredMedicines(item.query)" :key="med.id">
                            <li @click="selectMedicine(index, med)" 
                                class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-neutral-100 hover:text-neutral-900 dark:hover:bg-neutral-700 dark:hover:text-neutral-50 flex-col items-start">
                                <div class="font-medium" x-text="med.name"></div>
                                <div class="flex justify-between w-full mt-0.5">
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400" x-text="med.code"></span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-400">Stok: <span x-text="med.current_stock"></span></span>
                                </div>
                            </li>
                        </template>

                        {{-- Pesan Kosong --}}
                        <li x-show="getFilteredMedicines(item.query).length === 0" class="px-4 py-3 text-xs text-neutral-400 text-center italic">
                            Obat tidak ditemukan.
                        </li>
                    </ul>
                </div>
            </td>

            {{-- KOLOM SATUAN --}}
            <td class="p-4 align-middle">
                <input type="text" x-model="item.unit" readonly class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-400 font-mono cursor-not-allowed text-center">
            </td>

            {{-- KOLOM JUMLAH --}}
            <td class="p-4 align-middle">
                <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" min="1" class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300" required>
            </td>

            {{-- TOTAL HARGA (INPUT MANUAL) --}}
            <td class="p-4 align-middle">
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-neutral-400 text-xs">Rp</span>
                    <input type="number" 
                           x-model="item.total_price" 
                           @input="updatePricePerItem(index)" {{-- Hitung saat total berubah --}}
                           class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300 pl-8" 
                           placeholder="8000">
                </div>
            </td>

            {{-- HARGA BELI (@) - OTOMATIS --}}
            <td class="p-4 align-middle">
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-neutral-400 text-xs">Rp</span>
                    <input type="number" 
                        :name="'items['+index+'][price]'" 
                        x-model="item.price" 
                        step="0.01"
                        readonly 
                        class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-400 font-mono cursor-not-allowed pl-8">
                </div>
            </td>

            {{-- TOMBOL HAPUS ROW --}}
            <td class="p-4 align-middle text-center pt-3">
                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 hover:bg-red-100 hover:text-red-600 h-8 w-8 dark:hover:bg-red-900/50 dark:hover:text-red-500 bg-transparent">
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
                <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-600 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('inventory.transactions.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">Batal</a>
                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">SIMPAN DATA</button>
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