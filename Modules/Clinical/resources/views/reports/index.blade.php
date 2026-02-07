<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Pusat Laporan') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Statistik Operasional & Rekapitulasi Data Klinik</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Dashboard</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Laporan</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            {{-- Laporan Operasional --}}
            <div>
                <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                    <span class="bg-blue-600 w-1.5 h-5 rounded-full mr-3"></span>
                    Statistik Operasional Klinis
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <a href="{{ route('clinical.reports.visits') }}" class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 group relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-6 opacity-10 dark:opacity-5 group-hover:opacity-20 transition-opacity">
                            <svg class="w-20 h-20 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Kunjungan Pasien</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Analisis volume kunjungan harian, mingguan, hingga rekapitulasi tahunan.</p>
                        </div>
                    </a>

                    <a href="{{ route('clinical.reports.diseases') }}" class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:border-rose-400 dark:hover:border-rose-500 transition-all duration-300 group relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center mb-6 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Pola Penyakit</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Statistik diagnosa terbanyak (Morbiditas) berdasarkan kode ICD-10.</p>
                        </div>
                    </a>

                </div>
            </div>

            {{-- Laporan Farmasi --}}
            <div>
                <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                    <span class="bg-indigo-600 w-1.5 h-5 rounded-full mr-3"></span>
                    Manajemen Farmasi & Logistik
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <a href="{{ route('clinical.reports.medicines') }}" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-emerald-400 dark:hover:border-emerald-500 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 tracking-tight">Pemakaian Obat</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Data pengeluaran resep.</p>
                    </a>

                    <a href="{{ route('clinical.reports.incoming') }}" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 tracking-tight">Pengadaan Obat</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Data pengadaan stok baru.</p>
                    </a>

                    <a href="{{ route('clinical.reports.mutation') }}" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-500 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 tracking-tight">Mutasi Stok </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Aliran barang per item.</p>
                    </a>

                    <a href="{{ route('clinical.reports.low_stock') }}" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-amber-400 dark:hover:border-amber-500 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-lg flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 tracking-tight">Stok Menipis</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Daftar re-order logistik.</p>
                    </a>

                    <a href="{{ route('inventory.reports.stock_card') }}" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-violet-400 dark:hover:border-violet-500 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-lg flex items-center justify-center mb-4 group-hover:bg-violet-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 tracking-tight">Kartu Stok</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Cek transaksi setiap item.</p>
                    </a>

                    <a href="{{ route('clinical.reports.skd') }}" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:border-violet-400 dark:hover:border-violet-500 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-lg flex items-center justify-center mb-4 group-hover:bg-violet-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-slate-100 tracking-tight">Surat Keterangan Dokter</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Cek transaksi SKD</p>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>