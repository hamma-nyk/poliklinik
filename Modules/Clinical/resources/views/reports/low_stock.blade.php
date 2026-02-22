<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Laporan Stok Menipis') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Daftar inventaris yang memerlukan pengadaan ulang segera</p>
            </div>
            <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-amber-600 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Kritis</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert & Action Bar --}}
            <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                <div class="flex bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="font-bold text-amber-800 dark:text-amber-300 text-sm">Ambang Batas Peringatan</p>
                            <p class="text-xs text-amber-700 dark:text-amber-400/80">Menampilkan item dengan sisa stok &le; <span class="font-black underline">{{ $limit }}</span> unit.</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                <a href="{{ route('clinical.reports.index') }}" 
                        class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-50 dark:hover:bg-slate-600 transition-all shadow-sm active:scale-95 uppercase tracking-widest group">
                            <svg class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                </a>
                <a href="{{ route('clinical.reports.low_stock', ['action' => 'pdf']) }}" target="_blank" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/30 dark:shadow-none text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Export Laporan (PDF)
                </a>
                </div>
            </div>

            {{-- Table Results --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-900/20">
                                <th class="px-8 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest w-20">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Informasi Item</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Satuan</th>
                                <th class="px-6 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Sisa Stok</th>
                                <th class="px-8 py-4 text-center text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Tingkat Urgensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @forelse($data as $index => $row)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                <td class="px-8 py-5 text-center text-sm font-medium text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-100 group-hover:text-amber-600 transition-colors">{{ $row->name }}</div>
                                    <div class="text-[11px] font-mono text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-tighter">{{ $row->code }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                        {{ $row->unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="text-lg font-black {{ $row->current_stock <= 0 ? 'text-rose-600' : 'text-amber-500' }}">
                                        {{ number_format($row->current_stock, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    @if($row->current_stock <= 0)
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 animate-pulse uppercase tracking-widest">
                                            Out of Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800 uppercase tracking-widest">
                                            Re-order Soon
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-6 bg-emerald-50 dark:bg-emerald-900/20 rounded-full mb-4 text-emerald-500 dark:text-emerald-400">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h3 class="text-slate-800 dark:text-slate-100 font-black text-xl uppercase tracking-tight">Stok Logistik Aman</h3>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1 max-w-sm mx-auto">Tidak ditemukan obat dengan jumlah stok kritis di bawah ambang batas {{ $limit }}.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>