<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Edit Data Obat') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pembaruan informasi produk dan penyesuaian harga jual</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors"><a href="{{ route('inventory.medicines.index') }}">Inventaris</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Edit Obat</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
                <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-100 uppercase tracking-[0.2em] flex items-center mb-6">
                    <span class="bg-amber-500 w-1.5 h-5 rounded-full mr-3"></span>
                    Perbarui informasi obat
                </h3>

                <form action="{{ route('inventory.medicines.update', $medicine->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        {{-- Kode Obat (Read Only) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kode Referensi (Sistem)</label>
                            <input type="text" value="{{ $medicine->code }}" disabled 
                                class="w-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 rounded-xl border-slate-200 dark:border-slate-600 font-mono cursor-not-allowed uppercase">
                        </div>

                        {{-- Nama Obat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Obat <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ $medicine->name }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all" required>
                        </div>

                        {{-- Satuan --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Satuan Terkecil</label>
                            <select name="unit" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                                @foreach(['Pcs'] as $unit)
                                    <option value="{{ $unit }}" {{ $medicine->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- {{-- Harga --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-slate-400 dark:text-slate-500 text-sm font-bold">Rp</span>
                                </div>
                                <input type="number" name="price" value="{{ $medicine->price }}"
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 pl-10 focus:border-indigo-500 focus:ring-indigo-500 transition-all" required min="0">
                            </div>
                        </div> -->

                        {{-- Stok Saat Ini (Disabled) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-400 dark:text-slate-500">Persediaan Saat Ini</label>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-200 dark:border-slate-700">
                                <div class="px-5 py-2 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-600">
                                    <span class="text-xl font-black text-indigo-600 dark:text-indigo-400">{{ $medicine->current_stock }}</span>
                                    <span class="ml-1 text-xs font-bold text-slate-400 uppercase">{{ $medicine->unit }}</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed italic">
                                    Stok dikelola otomatis melalui transaksi <span class="font-bold">Stok Masuk</span> dan <span class="font-bold">Resep Pasien</span>.
                                </p>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Deskripsi / Catatan Farmasi</label>
                            <textarea name="description" rows="3" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all">{{ $medicine->description }}</textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('inventory.medicines.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-slate-900 dark:bg-indigo-600 text-white font-bold hover:bg-indigo-800 dark:hover:bg-indigo-500 shadow-lg dark:shadow-none transition duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Data Obat
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>