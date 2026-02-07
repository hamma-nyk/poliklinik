<x-app-layout title="Laporan SKD">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
            <div class="flex items-center gap-3">
                <!-- <div class="p-2 bg-indigo-50 dark:bg-slate-700 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div> -->
                <div>
                    <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 tracking-tight">Laporan SKD</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Ekspor data surat keterangan sakit berkala</p>
                </div>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-indigo-600 cursor-pointer transition-colors">Klinis</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Export Report</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 transition-all" x-data="{ format: 'view' }">
                <form action="{{ route('clinical.reports.skd_export') }}" method="POST" target="_blank">
                    @csrf
                    
                    {{-- Input Periode --}}
                    <div class="mb-8">
                        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">Rentang Periode Laporan</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-100 dark:border-slate-700">
                            <div class="space-y-1.5">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 ml-1">Dari Tanggal</span>
                                <input type="date" name="start_date" value="{{ date('Y-m-01') }}" 
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" required>
                            </div>
                            <div class="space-y-1.5">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 ml-1">Sampai Tanggal</span>
                                <input type="date" name="end_date" value="{{ date('Y-m-t') }}" 
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" required>
                            </div>
                        </div>
                    </div>

                    {{-- Pilihan Format --}}
                    <div class="mb-10">
                        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4 ml-1">Pilih Format Output</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="relative flex flex-col items-center justify-center p-5 border-2 rounded-2xl cursor-pointer transition-all duration-300 group"
                                :class="format === 'view' ? 'border-indigo-500 bg-indigo-50/50 dark:bg-indigo-900/20' : 'border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50'">
                                <input type="radio" name="format" value="view" x-model="format" class="hidden">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-3 transition-colors"
                                    :class="format === 'view' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 group-hover:text-indigo-500'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Pratinjau Web</span>
                            </label>

                            <label class="relative flex flex-col items-center justify-center p-5 border-2 rounded-2xl cursor-pointer transition-all duration-300 group"
                                :class="format === 'excel' ? 'border-emerald-500 bg-emerald-50/50 dark:bg-emerald-900/20' : 'border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50'">
                                <input type="radio" name="format" value="excel" x-model="format" class="hidden">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-3 transition-colors"
                                    :class="format === 'excel' ? 'bg-emerald-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 group-hover:text-emerald-500'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Excel (.xlsx)</span>
                            </label>

                            <label class="relative flex flex-col items-center justify-center p-5 border-2 rounded-2xl cursor-pointer transition-all duration-300 group"
                                :class="format === 'pdf' ? 'border-rose-500 bg-rose-50/50 dark:bg-rose-900/20' : 'border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50'">
                                <input type="radio" name="format" value="pdf" x-model="format" class="hidden">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-3 transition-colors"
                                    :class="format === 'pdf' ? 'bg-rose-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 group-hover:text-rose-500'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Dokumen PDF</span>
                            </label>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex flex-col items-center gap-4">
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transition-all hover:scale-[1.02] active:scale-95 uppercase tracking-widest text-xs">
                            Generate & Unduh Laporan
                        </button>
                        <p class="text-[10px] text-slate-400 dark:text-slate-600 italic text-center leading-relaxed">
                            Laporan akan diproses secara otomatis sesuai filter tanggal yang dipilih.<br>Pastikan data SKD telah difinalisasi sebelum diekspor.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>