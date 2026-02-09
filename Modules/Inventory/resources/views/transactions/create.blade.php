<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Input Transaksi Stok') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan mutasi stok barang masuk dan keluar secara kolektif</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Inventaris</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Transaksi Baru</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventory.transactions.store') }}" method="POST">
                @csrf
                
                {{-- 1. Informasi Umum --}}
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center">
                        <span class="w-1.5 h-6 bg-indigo-600 rounded-full mr-3"></span>
                        1. Informasi Header
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Tipe Transaksi</label>
                            <select name="type" disabled class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all font-bold">
                                <option value="in">Penambahan (Pembelian/Hibah)</option>
                                <!-- <option value="out">KELUAR (Rusak / Expired / Lainnya)</option> -->
                            </select>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 italic font-medium leading-tight">*Catatan: Pengeluaran resep pasien dilakukan melalui menu Rekam Medis.</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all" required>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Catatan / Ref Faktur</label>
                            <input type="text" name="notes" placeholder="Contoh: INV/2024/001" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                        </div>
                    </div>
                </div>

                {{-- 2. Daftar Obat --}}
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8" x-data="transactionForm()">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center">
                            <span class="w-1.5 h-6 bg-emerald-500 rounded-full mr-3"></span>
                            2. Item Logistik
                        </h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-sm font-bold rounded-xl border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-600 hover:text-white transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            Tambah Baris Baru
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead>
                                <tr>
                                    <th class="px-2 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest w-6/12">Pilih Obat</th>
                                    <th class="px-2 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest w-2/12">Jumlah (Qty)</th>
                                    <th class="px-2 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest w-3/12">Harga Satuan (Rp)</th>
                                    <th class="w-1/12"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                        <td class="py-4 pr-4">
                                            <select :name="'items['+index+'][medicine_id]'" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 transition-all" required>
                                                <option value="">-- Cari Nama Obat --</option>
                                                @foreach($medicines as $med)
                                                    <option value="{{ $med->id }}">{{ $med->code }} — {{ $med->name }} (Stok: {{ $med->current_stock }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="py-4 pr-4">
                                            <input type="number" :name="'items['+index+'][quantity]'" min="1" 
                                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5" 
                                                placeholder="0" required>
                                        </td>
                                        <td class="py-4 pr-4">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-slate-400 dark:text-slate-500 text-xs">Rp</span>
                                                </div>
                                                <input required type="number" :name="'items['+index+'][price]'" min="0" 
                                                    class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 dark:text-slate-100 pl-8 focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5" 
                                                    placeholder="5000">
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <button type="button" @click="removeItem(index)" 
                                                class="p-2 text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all" 
                                                x-show="items.length > 1">
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
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ route('inventory.transactions.index') }}" 
                        class="px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        Batal & Kembali
                    </a>
                    <button type="submit" 
                        class="w-full sm:w-auto inline-flex justify-center items-center px-10 py-3 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 shadow-xl shadow-indigo-500/30 dark:shadow-none transition transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        SIMPAN DATA TRANSAKSI
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function transactionForm() {
            return {
                items: [
                    { medicine_id: '', quantity: '', price: '' }
                ],
                addItem() {
                    this.items.push({ medicine_id: '', quantity: '', price: '' });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                }
            }
        }
    </script>
</x-app-layout>