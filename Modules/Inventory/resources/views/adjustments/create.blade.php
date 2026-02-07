<x-app-layout title="Buat Penyesuaian Stok">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-50 dark:bg-slate-700 rounded-xl text-indigo-600 dark:text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 tracking-tight">Input Penyesuaian Manual</h2>
            </div>
            <a href="{{ route('inventory.adjustments.index') }}" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-95">
                Batal
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Inisialisasi Data Alpine --}}
            <form action="{{ route('inventory.adjustments.store') }}" method="POST" 
                x-data="{ 
                    type: 'out',
                    search: '',
                    isOpen: false,
                    selectedId: '',
                    selectedName: '',
                    selectedStock: null,
                    selectedUnit: '',
                    items: @js($medicines),
                    
                    get filteredItems() {
                        return this.items.filter(i => 
                            i.name.toLowerCase().includes(this.search.toLowerCase()) || 
                            i.code.toLowerCase().includes(this.search.toLowerCase())
                        )
                    },

                    selectItem(item) {
                        this.selectedId = item.id;
                        this.selectedName = item.name;
                        this.selectedStock = item.current_stock;
                        this.selectedUnit = item.unit;
                        this.search = '';
                        this.isOpen = false;
                    }
                }">
                @csrf
                
                <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 space-y-8">
                    
                    {{-- Baris 1: Tanggal & Tipe --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-slate-100 dark:border-slate-700 pb-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" 
                                class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Tipe Penyesuaian</label>
                            <select name="type" x-model="type" 
                                class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                                <option value="out">Pengurangan (Rusak/Hilang)</option>
                                <option value="in">Penambahan (Temuan/Bonus)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 2: Searchable Select Murni Alpine --}}
                    <div class="space-y-3 relative">
                        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Cari Obat / Alkes</label>
                        
                        {{-- Trigger Search --}}
                        <div class="relative">
                            <input type="text" x-model="search" @click="isOpen = true" @click.away="isOpen = false"
                                :placeholder="selectedName ? selectedName : 'Ketik nama atau kode obat...'"
                                class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all pl-11">
                            
                            <div class="absolute left-4 top-3.5 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>

                            {{-- Hidden Input untuk Form Submit --}}
                            <input type="hidden" name="medicine_id" x-model="selectedId" required>
                        </div>

                        {{-- Dropdown Results --}}
                        <div x-show="isOpen" 
                            class="absolute z-50 w-full mt-2 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-2xl shadow-xl max-h-60 overflow-y-auto overflow-x-hidden"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100">
                            
                            <template x-for="item in filteredItems" :key="item.id">
                                <div @click="selectItem(item)" 
                                    class="px-5 py-3 hover:bg-indigo-50 dark:hover:bg-slate-600 cursor-pointer border-b border-slate-50 dark:border-slate-600 last:border-0 transition-colors group">
                                    <div class="font-bold text-sm text-slate-700 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" x-text="item.name"></div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-400 font-mono tracking-tighter" x-text="item.code"></div>
                                </div>
                            </template>

                            <div x-show="filteredItems.length === 0" class="px-5 py-8 text-center text-slate-400 text-xs italic">
                                Barang tidak ditemukan...
                            </div>
                        </div>
                        
                        {{-- Info Stok Saat Ini --}}
                        <template x-if="selectedId">
                            <div class="mt-4 p-4 rounded-2xl border flex items-center justify-between animate-in fade-in slide-in-from-top-2 duration-300"
                                :class="type === 'out' ? 'bg-rose-50/50 border-rose-100 text-rose-700 dark:bg-slate-900 dark:border-rose-900/30 dark:text-rose-400' : 'bg-emerald-50/50 border-emerald-100 text-emerald-700 dark:bg-slate-900 dark:border-emerald-900/30 dark:text-emerald-400'">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg" :class="type === 'out' ? 'bg-rose-100 dark:bg-rose-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Saldo Stok Aktif</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xl font-bold font-mono" x-text="selectedStock">0</span>
                                    <span class="text-[10px] font-bold uppercase ml-1 opacity-60" x-text="selectedUnit"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Baris 3: Qty & Alasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Kuantitas Koreksi</label>
                            <div class="relative flex items-center">
                                <input type="number" name="quantity" min="1" placeholder="0" required
                                    class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 font-bold text-lg pr-16">
                                <div class="absolute right-4 flex items-center pointer-events-none border-l border-slate-200 dark:border-slate-700 pl-3 h-6 text-slate-400">
                                    <span class="text-[10px] font-bold uppercase tracking-tight" x-text="selectedUnit || 'Unit'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] ml-1">Alasan Penyesuaian</label>
                            <input type="text" name="notes" placeholder="Contoh: Barang kadaluwarsa" required
                                class="w-full h-12 rounded-2xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-2 text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>Efek permanen pada saldo stok</span>
                        </div>
                        <button type="submit" 
                            class="w-full md:w-auto px-10 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all hover:scale-[1.02] active:scale-95 uppercase tracking-widest text-xs">
                            Simpan Adjustment
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>