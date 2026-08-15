<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Tambah Obat Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Penambahan item logistik ke dalam inventaris klinik</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors"><a href="{{ route('inventory.medicines.index') }}">Inventaris</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Registrasi Obat</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 overflow-hidden p-8">
                
                <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                    <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                    Informasi Obat
                </h3>

                <form action="{{ route('inventory.medicines.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        {{-- Nama Obat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Obat <span class="text-destructive">*</span></label>
                            <input type="text" name="name" 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" 
                                required placeholder="Contoh: Paracetamol 500mg">
                        </div>

                        {{-- Satuan --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Satuan Terkecil</label>
                            <select name="unit" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
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
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Stok Awal</label>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-200 dark:border-slate-700">
                                <input type="text" value="0" disabled 
                                    class="flex h-9 w-20 text-center rounded-md border border-slate-200 bg-slate-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400 font-mono cursor-not-allowed">
                                <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                                    Stok awal selalu dimulai dari <span class="font-bold">nol</span>. Silakan gunakan menu <span class="text-slate-900 dark:text-slate-50 font-bold">Stok Masuk</span> untuk menambah persediaan setelah data tersimpan.
                                </p>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Deskripsi / Keterangan</label>
                            <textarea name="description" rows="3" 
                                class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300"
                                placeholder="Tuliskan indikasi, dosis umum, atau lokasi rak penyimpanan..."></textarea>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('inventory.medicines.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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