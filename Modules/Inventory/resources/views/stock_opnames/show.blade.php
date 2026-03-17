<x-app-layout title="Detail Stok Opname">
    <x-slot name="header">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
        {{-- Sisi Kiri: Judul & Breadcrumb Style --}}
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Detail Stok Opname') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Nomor Stok Opname: {{ $opname->opname_number }}</p>
            </div>
            <!-- <span class="hidden sm:block mx-2 text-slate-300 dark:text-slate-600 font-light">/</span>
            <span class="font-mono text-xs md:text-sm text-indigo-600 dark:text-indigo-400 font-black bg-indigo-100/50 dark:bg-indigo-900/40 px-3 py-1.5 rounded-xl border border-indigo-200 dark:border-indigo-800 shadow-sm tracking-tighter uppercase">
                Nomor Stok Opname: {{ $opname->opname_number }}
            </span> -->
        </div>

        {{-- Sisi Kanan: Action Button --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Cetak (Opsional, Menyelaraskan dengan kebutuhan Audit) --}}
            
                    {{-- Tombol Export Excel --}}
                    <a href="{{ route('inventory.stock_opname.export_excel', $opname->id) }}" 
                    target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        Export Excel
                    </a>

                    {{-- Tombol Export PDF --}}
                    <a href="{{ route('inventory.stock_opname.export_pdf', $opname->id) }}" 
                    target="_blank"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print PDF
                    </a>

                    {{-- Tombol Kembali --}}
                   
            <a href="{{ route('inventory.stock-opnames.index') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 font-black text-[11px] uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all shadow-sm active:scale-95 border-b-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>
</x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Dokumen Overview Card --}}
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 grid grid-cols-1 md:grid-cols-4 gap-8 transition-all">
                <div class="space-y-1">
                    <span class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Tanggal Pelaksanaan</span>
                    <span class="block text-lg font-bold text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($opname->opname_date)->format('d F Y') }}</span>
                </div>
                
                <div class="space-y-1">
                    <span class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Petugas Audit</span>
                    <div class="flex items-center pt-1">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs font-black mr-3 shadow-sm uppercase border border-indigo-200 dark:border-indigo-800">
                            {{ substr($opname->creator->name ?? '?', 0, 2) }}
                        </div>
                        <span class="text-slate-700 dark:text-slate-200 font-bold">{{ $opname->creator->name ?? 'Unknown' }}</span>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-1">
                    <span class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Memo / Catatan Dokumen</span>
                    <span class="block text-slate-600 dark:text-slate-400 italic leading-relaxed">
                        {{ $opname->notes ? '"' . $opname->notes . '"' : 'Tidak ada catatan tambahan.' }}
                    </span>
                </div>
            </div>
{{-- Overview Info & Visual Chart --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Data Dokumen --}}
                <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col justify-between">
                    <div>
                        <span class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Informasi Audit</span>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold">Waktu Pelaksanaan</p>
                                <p class="text-lg font-black text-slate-800 dark:text-white">{{ \Carbon\Carbon::parse($opname->opname_date)->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-bold">Oleh Petugas</p>
                                <p class="text-base font-bold text-slate-700 dark:text-slate-200">{{ $opname->creator->name ?? 'System' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700">
                        <span class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border border-indigo-100 dark:border-indigo-800">
                            {{ $opname->items->count() }} Total Item
                        </span>
                    </div>
                </div>

                {{-- Visual Grafik Selisih --}}
                <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-tighter">Visualisasi Selisih Stok (Variance)</h3>
                        <div class="flex gap-2">
                            <span class="flex items-center text-[10px] font-bold text-emerald-500 uppercase"><span class="w-2 h-2 bg-emerald-500 rounded-full mr-1"></span> Surplus</span>
                            <span class="flex items-center text-[10px] font-bold text-rose-500 uppercase"><span class="w-2 h-2 bg-rose-500 rounded-full mr-1"></span> Defisit</span>
                        </div>
                    </div>
                    <div id="chart-opname-diff" class="min-h-[250px]"></div>
                </div>
            </div>
            {{-- Table Rincian --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-all">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3 animate-pulse"></div>
                        <h3 class="font-black text-sm text-slate-700 dark:text-slate-200 uppercase tracking-tighter">Hasil Rekonsiliasi Inventaris</h3>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl border border-slate-200 dark:border-slate-700">
                        Audit: {{ $opname->items->count() }} Items
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50/30 dark:bg-slate-900/20 text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-700">
                                <th class="px-8 py-4">Item Obat & Kode</th>
                                <th class="px-6 py-4 text-center w-32">Stok Sistem</th>
                                <th class="px-6 py-4 text-center w-32 bg-slate-50/50 dark:bg-slate-900/40">Stok Fisik</th>
                                <th class="px-6 py-4 text-center w-32">Selisih</th>
                                <th class="px-8 py-4 text-center">Keterangan</th>
                                <th class="px-8 py-4 text-center">Status Audit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                            @foreach($opname->items as $item)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-800 dark:text-slate-100 text-base leading-none mb-1 group-hover:text-indigo-600 transition-colors">
                                        {{ $item->medicine->name }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono font-bold tracking-widest uppercase italic">
                                        {{ $item->medicine->code }} • {{ $item->medicine->unit }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-6 text-center">
                                    <span class="text-sm font-black text-slate-500 dark:text-slate-400 tabular-nums">
                                        {{ number_format($item->system_stock) }}
                                    </span>
                                </td>

                                <td class="px-6 py-6 text-center bg-slate-50/30 dark:bg-slate-900/20">
                                    <span class="text-lg font-black text-slate-800 dark:text-slate-100 tabular-nums">
                                        {{ number_format($item->physical_stock) }}
                                    </span>
                                </td>

                                <td class="px-6 py-6 text-center">
                                    @if($item->difference > 0)
                                        <div class="inline-flex items-center text-emerald-600 dark:text-emerald-400 font-black text-base tabular-nums">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                            {{ $item->difference }}
                                        </div>
                                    @elseif($item->difference < 0)
                                        <div class="inline-flex items-center text-rose-600 dark:text-rose-400 font-black text-base tabular-nums">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                            {{ abs($item->difference) }}
                                        </div>
                                    @else
                                        <span class="text-slate-300 dark:text-slate-600 font-black tabular-nums">0</span>
                                    @endif
                                </td>

                                <td class="px-6 py-6 text-center bg-slate-50/30 dark:bg-slate-900/20">
                                    <span class="text-md text-slate-800 dark:text-slate-100">
                                        {{ $item->opname_notes }}
                                    </span>
                                </td>

                                <td class="px-8 py-6 text-center whitespace-nowrap">
                                    @if($item->difference > 0)
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            Surplus
                                        </span>
                                    @elseif($item->difference < 0)
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                            Defisit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-600">
                                            Sesuai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Info Banner --}}
            <div class="p-6 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800/50 flex items-start gap-4">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl text-indigo-600 dark:text-indigo-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-indigo-800 dark:text-indigo-300 uppercase tracking-tighter mb-1">Informasi Penyesuaian Sistem</h4>
                    <p class="text-[11px] text-indigo-700 dark:text-indigo-400/80 leading-relaxed font-medium italic">
                        Data di atas adalah ringkasan audit fisik yang telah difinalisasi. Stok sistem telah diperbarui secara otomatis sesuai dengan kolom "Stok Fisik" pada saat dokumen ini disimpan.
                    </p>
                    
                </div>
            </div>

        </div>
            {{-- Script Grafik --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            
            // Persiapkan data dari Backend
            const labels = @json($opname->items->map(fn($item) => $item->medicine->name));
            const dataDiff = @json($opname->items->map(fn($item) => $item->difference));

            const options = {
                series: [{
                    name: 'Selisih',
                    data: dataDiff
                }],
                chart: {
                    type: 'bar',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                plotOptions: {
                    bar: {
                        colors: {
                            ranges: [{
                                from: -1000,
                                to: -1,
                                color: '#f43f5e' // Rose 500
                            }, {
                                from: 1,
                                to: 1000,
                                color: '#10b981' // Emerald 500
                            }]
                        },
                        columnWidth: '50%',
                        borderRadius: 6
                    }
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: isDark ? '#334155' : '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                },
                xaxis: {
                    categories: labels,
                    labels: {
                        show: false // Sembunyikan label bawah jika terlalu banyak
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: isDark ? '#94a3b8' : '#64748b',
                            fontSize: '11px',
                            fontWeight: 600
                        }
                    }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: {
                        title: { formatter: () => 'Selisih Unit: ' }
                    }
                }
            };

            new ApexCharts(document.querySelector("#chart-opname-diff"), options).render();
        });
    </script>
    <script>
    // console.log("Labels:", @json($opname->items->map(fn($item) => $item->medicine->name)));
    // console.log("Data:", @json($opname->items->map(fn($item) => $item->difference)));
</script>
    @endpush
    </div>

</x-app-layout>