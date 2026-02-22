<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Tambah Obat Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Penambahan item logistik ke dalam inventaris klinik</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors"><a href="{{ route('inventory.medicines.index') }}">Inventaris</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Registrasi Obat</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
                <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-100 uppercase tracking-[0.2em] flex items-center mb-6">
                    <span class="bg-indigo-600 w-1.5 h-5 rounded-full mr-3"></span>
                    Informasi Obat
                </h3>

                <form action="{{ route('inventory.medicines.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        {{-- Nama Obat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Obat <span class="text-red-500">*</span></label>
                            <input type="text" name="name" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all placeholder-slate-400 dark:placeholder-slate-500" 
                                required placeholder="Contoh: Paracetamol 500mg">
                        </div>

                        {{-- Satuan --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Satuan Terkecil</label>
                            <select name="unit" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all">
                                <!-- <option value="Tablet">Tablet</option>
                                <option value="Strip">Strip</option>
                                <option value="Botol">Botol</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Tube">Tube</option> -->
                                <option value="Pcs">Pcs</option>
                                <!-- <option value="Pot">Pot</option>
                                <option value="Roll">Roll</option>
                                <option value="Lembar">Lembar</option>
                                <option value="Bungkus">Bungkus</option>
                                <option value="Ampul">Ampul</option>
                                <option value="Flatbot">Flatbot</option>
                                <option value="Box">Box</option> -->
                            </select>
                        </div>

                        

                        {{-- Stok Awal (Disabled) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-400 dark:text-slate-500">Stok Awal</label>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-200 dark:border-slate-700">
                                <input type="text" value="0" disabled 
                                    class="w-20 text-center rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 font-bold cursor-not-allowed">
                                <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                                    Stok awal selalu dimulai dari <span class="font-bold">nol</span>. Silakan gunakan menu <span class="text-indigo-600 dark:text-indigo-400 font-bold">Stok Masuk</span> untuk menambah persediaan setelah data tersimpan.
                                </p>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Deskripsi / Keterangan</label>
                            <textarea name="description" rows="3" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 transition-all"
                                placeholder="Tuliskan indikasi, dosis umum, atau lokasi rak penyimpanan..."></textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('inventory.medicines.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 dark:shadow-none transition duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan ke Inventaris
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>