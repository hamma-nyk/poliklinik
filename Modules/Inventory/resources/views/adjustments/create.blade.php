<x-app-layout title="Buat Penyesuaian Stok">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Input Adjustment Stok') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Koreksi manual inventaris (Rusak, Hilang, atau Temuan)</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 mt-2 md:mt-0 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors"><a href="{{ route('inventory.adjustments.index') }}">Inventaris</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Buat Adjustment</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
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
                
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 p-6 space-y-8">
                    
                    {{-- Baris 1: Tanggal & Tipe --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-neutral-100 dark:border-neutral-800 pb-8">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tipe Penyesuaian</label>
                            <select name="type" x-model="type" 
                                class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:ring-offset-neutral-950 dark:placeholder:text-neutral-400 dark:focus:ring-neutral-300">
                                <option value="out">Pengurangan (Rusak/Hilang)</option>
                                <option value="in">Penambahan (Temuan/Bonus)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Baris 2: Searchable Select Murni Alpine --}}
                    <div class="space-y-3 relative">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Cari Obat / Alkes</label>
                        
                        {{-- Trigger Search --}}
                        <div class="relative">
                            <input type="text" x-model="search" @click="isOpen = true" @click.away="isOpen = false"
                                :placeholder="selectedName ? selectedName : 'Ketik nama atau kode obat...'"
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300 pl-9 cursor-pointer">
                            
                            <div class="absolute left-3 top-2.5 text-neutral-500">
                                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>

                            {{-- Hidden Input untuk Form Submit --}}
                            <input type="hidden" name="medicine_id" x-model="selectedId" required>
                        </div>

                        {{-- Dropdown Results --}}
                        <div x-show="isOpen" 
                            class="absolute w-full mt-1 bg-white dark:bg-neutral-950 border border-neutral-200 dark:border-neutral-800 rounded-md shadow-md max-h-60 overflow-y-auto z-50"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100">
                            
                            <template x-for="item in filteredItems" :key="item.id">
                                <div @click="selectItem(item)" 
                                    class="cursor-pointer relative flex w-full select-none items-center rounded-sm py-1.5 pl-2 pr-8 text-sm outline-none hover:bg-neutral-100 hover:text-neutral-900 dark:hover:bg-neutral-800 dark:hover:text-neutral-50 flex-col items-start">
                                    <div class="font-medium" x-text="item.name"></div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400" x-text="item.code"></div>
                                </div>
                            </template>

                            <div x-show="filteredItems.length === 0" class="px-5 py-8 text-center text-neutral-400 text-xs italic">
                                Barang tidak ditemukan...
                            </div>
                        </div>
                        
                        {{-- Info Stok Saat Ini --}}
                        <template x-if="selectedId">
                            <div class="mt-4 p-4 rounded-xl border flex items-center justify-between animate-in fade-in slide-in-from-top-2 duration-300"
                                :class="type === 'out' ? 'bg-rose-50/50 border-rose-100 text-rose-700 dark:bg-neutral-900 dark:border-rose-900/30 dark:text-rose-400' : 'bg-emerald-50/50 border-emerald-100 text-emerald-700 dark:bg-neutral-900 dark:border-emerald-900/30 dark:text-emerald-400'">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg" :class="type === 'out' ? 'bg-rose-100 dark:bg-rose-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <span class="text-xs font-semibold">Saldo Stok Aktif</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-lg font-bold tabular-nums" x-text="selectedStock">0</span>
                                    <span class="text-xs font-semibold ml-1 opacity-60" x-text="selectedUnit"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Baris 3: Qty & Alasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Kuantitas Koreksi <span class="text-destructive">*</span></label>
                            <div class="relative flex items-center">
                                <input type="number" name="quantity" min="1" placeholder="0" required
                                    class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300 pr-16 font-bold tabular-nums">
                                <div class="absolute right-4 flex items-center pointer-events-none border-l border-neutral-200 dark:border-neutral-800 pl-3 h-6 text-neutral-500 dark:text-neutral-400">
                                    <span class="text-xs font-semibold uppercase" x-text="selectedUnit || 'Unit'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alasan Penyesuaian <span class="text-destructive">*</span></label>
                            <input type="text" name="notes" placeholder="Contoh: Barang kadaluwarsa" required
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row justify-end gap-3">
    {{-- Warning Info --}}
    <div class="flex items-center gap-3 text-xs text-neutral-500 dark:text-neutral-400 font-medium mr-auto">
        <div class="p-1.5 bg-amber-50 dark:bg-amber-950/50 rounded-md border border-amber-200 dark:border-amber-900/50">
            <svg class="w-4 h-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <span>Efek permanen pada saldo stok</span>
    </div>

    {{-- Action Buttons --}}
        {{-- Tombol Batal --}}
        <a href="{{ route('inventory.adjustments.index') }}" 
            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-neutral-800 dark:hover:text-neutral-50 w-full sm:w-auto">
            Batal
        </a>

        {{-- Tombol Simpan --}}
        <button type="submit" 
            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full sm:w-auto">
            Simpan Adjustment
        </button>
</div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>