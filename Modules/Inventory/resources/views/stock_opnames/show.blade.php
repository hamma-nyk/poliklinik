<x-app-layout title="Detail Stok Opname">
    <x-slot name="header">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 transition-all duration-300">
        {{-- Sisi Kiri: Judul & Breadcrumb Style --}}
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
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
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        Export Excel
                    </a>

                    {{-- Tombol Export PDF --}}
                    <a href="{{ route('inventory.stock_opname.export_pdf', $opname->id) }}" 
                    target="_blank"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print PDF
                    </a>

                    {{-- Tombol Kembali --}}
                   
            <a href="{{ route('inventory.stock-opnames.index') }}" 
               class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>
</x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Dokumen Overview Card --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6 grid grid-cols-1 md:grid-cols-4 gap-8 transition-all">
                <div class="space-y-1">
                    <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanggal Pelaksanaan</span>
                    <span class="block text-lg font-semibold text-slate-900 dark:text-slate-50">{{ \Carbon\Carbon::parse($opname->opname_date)->format('d F Y') }}</span>
                </div>
                
                <div class="space-y-1">
                    <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Petugas Audit</span>
                    <div class="flex items-center pt-1">
                        <div class="flex h-9 w-9 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-xs font-medium dark:border-slate-800 dark:bg-slate-900 mr-3 uppercase">
                            {{ substr($opname->creator->name ?? '?', 0, 2) }}
                        </div>
                        <span class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $opname->creator->name ?? 'Unknown' }}</span>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-1">
                    <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Memo / Catatan Dokumen</span>
                    <span class="block text-lg font-semibold text-slate-900 dark:text-slate-50 italic">
                        {{ $opname->notes ? '"' . $opname->notes . '"' : 'Tidak ada catatan tambahan.' }}
                    </span>
                </div>
            </div>
{{-- Overview Info & Visual Chart --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Data Dokumen --}}
                <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6 flex flex-col justify-between">
                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center mb-4"><span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>Informasi Audit</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-8 border-b border-slate-200 dark:border-slate-800">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Waktu Pelaksanaan</p>
                                <p class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ \Carbon\Carbon::parse($opname->opname_date)->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Oleh Petugas</p>
                                <p class="text-lg font-semibold text-slate-900 dark:text-slate-50">{{ $opname->creator->name ?? 'System' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="inline-flex items-center rounded-md border border-transparent bg-slate-900 text-slate-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-slate-50 dark:text-slate-900">
                            {{ $opname->items->count() }} Total Item
                        </span>
                    </div>
                </div>

                {{-- Visual Grafik Selisih --}}
                <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 flex items-center"><span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>Visualisasi Selisih Stok (Variance)</h3>
                        <div class="flex gap-2">
                            <span class="flex items-center text-[10px] font-bold text-emerald-500 uppercase"><span class="w-2 h-2 bg-emerald-500 rounded-full mr-1"></span> Surplus</span>
                            <span class="flex items-center text-[10px] font-bold text-rose-500 uppercase"><span class="w-2 h-2 bg-rose-500 rounded-full mr-1"></span> Defisit</span>
                        </div>
                    </div>
                    <div id="chart-opname-diff" class="min-h-[250px]"></div>
                </div>
            </div>
            {{-- Table Rincian --}}
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 overflow-hidden transition-all">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center">
                        <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                        <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">Hasil Rekonsiliasi Inventaris</h3>
                    </div>
                    <span class="inline-flex items-center rounded-md border border-transparent bg-slate-900 text-slate-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-slate-50 dark:text-slate-900">
                        Audit: {{ $opname->items->count() }} Items
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                                <th class="h-12 px-4 text-left align-middle font-medium text-slate-500 dark:text-slate-400">Item Obat & Kode</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Stok Sistem</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Stok Fisik</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Selisih</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Keterangan</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-slate-500 dark:text-slate-400">Status Audit</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @foreach($opname->items as $item)
                            <tr class="border-b transition-colors hover:bg-slate-100/50 dark:border-slate-800 dark:hover:bg-slate-800/50 group">
                                <td class="p-4 align-middle">
									<div class="flex items-center gap-2 mb-1">
										<div class="font-medium text-base leading-none">
											{{ $item->medicine->name ?? 'Obat Tidak Ditemukan' }}
										</div>
										
										{{-- Indikator Obat Terhapus (Soft Deleted) --}}
										@if($item->medicine && $item->medicine->trashed())
											<span class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-slate-200 text-slate-950 dark:border-slate-800 dark:text-slate-50 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400">
												Dihapus
											</span>
										@endif
									</div>
									
									<div class="text-[10px] text-slate-500 dark:text-slate-400 font-mono font-bold tracking-widest uppercase italic">
										{{ $item->medicine->code ?? '-' }} ? {{ $item->medicine->unit ?? '-' }}
									</div>
								</td>
                                
                                <td class="p-4 align-middle text-center">
                                    <span class="text-sm font-black text-slate-500 dark:text-slate-400 tabular-nums">
                                        {{ number_format($item->system_stock) }}
                                    </span>
                                </td>

                                <td class="p-4 align-middle text-center bg-slate-50/30 dark:bg-slate-900/20">
                                    <span class="text-lg font-black tabular-nums">
                                        {{ number_format($item->physical_stock) }}
                                    </span>
                                </td>

                                <td class="p-4 align-middle text-center">
                                    @if($item->difference > 0)
                                        <div class="inline-flex items-center text-emerald-500 font-bold tabular-nums">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                            {{ $item->difference }}
                                        </div>
                                    @elseif($item->difference < 0)
                                        <div class="inline-flex items-center text-destructive font-bold tabular-nums">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                            {{ abs($item->difference) }}
                                        </div>
                                    @else
                                        <span class="font-bold tabular-nums text-slate-500 dark:text-slate-400">0</span>
                                    @endif
                                </td>

                                <td class="p-4 align-middle text-center bg-slate-50/30 dark:bg-slate-900/20">
                                    <span class="font-medium">
                                        {{ $item->opname_notes }}
                                    </span>
                                </td>

                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    @if($item->difference > 0)
                                        <span class="inline-flex items-center rounded-md border border-transparent bg-slate-900 text-slate-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-slate-50 dark:text-slate-900">
                                            Surplus
                                        </span>
                                    @elseif($item->difference < 0)
                                        <span class="inline-flex items-center rounded-md border border-transparent bg-slate-900 text-slate-50 px-2.5 py-0.5 text-xs font-semibold dark:bg-slate-50 dark:text-slate-900">
                                            Defisit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold transition-colors border-slate-200 text-slate-950 dark:border-slate-800 dark:text-slate-50">
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
            <div class="rounded-md border border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-800 p-6 flex items-start gap-4">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl text-indigo-600 dark:text-indigo-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-1">Informasi Penyesuaian Sistem</h4>
                    <p class="text-[11px] leading-relaxed font-medium italic text-slate-500 dark:text-slate-400">
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
            const labels = @json($opname->items->map(function($item) {
                if (!$item->medicine) return 'Unknown Item';
                
                // PERBAIKAN: Gunakan titik (.) untuk menyambung string di PHP
                return $item->medicine->trashed() ? $item->medicine->name . ' (Dihapus)' : $item->medicine->name;
            }));

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
    // console.log("Labels:", @json($opname->items->map(fn($item) => $item->medicine->name ?? 'Unknown Item')));
    // console.log("Data:", @json($opname->items->map(fn($item) => $item->difference)));
</script>
    @endpush
    </div>

</x-app-layout>