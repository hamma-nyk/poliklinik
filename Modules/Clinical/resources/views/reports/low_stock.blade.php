<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Laporan Stok Menipis') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Daftar inventaris yang memerlukan pengadaan ulang segera</p>
            </div>
            <div class="flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span class="hover:text-neutral-900 dark:hover:text-neutral-50 cursor-pointer transition-colors">Laporan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Kritis</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Alert & Action Bar --}}
            <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                <div class="flex border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 p-4 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-neutral-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="font-medium text-sm">Ambang Batas Peringatan</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Menampilkan item dengan sisa stok &le; <span class="font-semibold">{{ $limit }}</span> unit.</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                <a href="{{ route('clinical.reports.index') }}" 
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-800 dark:bg-neutral-950 dark:hover:bg-neutral-800 dark:hover:text-neutral-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                </a>
                <a href="{{ route('clinical.reports.low_stock', ['action' => 'pdf']) }}" target="_blank" 
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Export Laporan (PDF)
                </a>
                </div>
            </div>

            {{-- Table Results --}}
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400 w-20">No</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Informasi Item</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Satuan</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Sisa Stok</th>
                                <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Tingkat Urgensi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($data as $index => $row)
                            <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-800 dark:hover:bg-neutral-800/50">
                                <td class="p-4 align-middle text-center text-neutral-500 dark:text-neutral-400">{{ $index + 1 }}</td>
                                <td class="p-4 align-middle">
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">{{ $row->name }}</div>
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5 uppercase">{{ $row->code }}</div>
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <span class="px-2.5 py-1 bg-neutral-100 dark:bg-neutral-800 rounded-md text-xs font-medium text-neutral-600 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
                                        {{ $row->unit }}
                                    </span>
                                </td>
                                <td class="p-4 align-middle text-center">
                                    <div class="text-lg font-medium {{ $row->current_stock <= 0 ? 'text-rose-600' : 'text-amber-600' }}">
                                        {{ number_format($row->current_stock, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-center whitespace-nowrap">
                                    @if($row->current_stock <= 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-200 dark:border-rose-800 uppercase">
                                            Out of Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800 uppercase">
                                            Re-order Soon
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 align-middle text-center py-24">
                                    <div class="flex flex-col items-center justify-center">
                                        <h3 class="text-neutral-900 dark:text-neutral-100 font-medium text-lg tracking-tight">Stok Logistik Aman</h3>
                                        <p class="text-neutral-500 dark:text-neutral-400 text-sm mt-1 max-w-sm mx-auto">Tidak ditemukan obat dengan jumlah stok kritis di bawah ambang batas {{ $limit }}.</p>
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