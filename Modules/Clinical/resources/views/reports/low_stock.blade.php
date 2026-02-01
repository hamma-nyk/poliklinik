<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Laporan Stok Menipis') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <div class="bg-amber-100 border-l-4 border-amber-500 text-amber-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Perhatian</p>
                    <p class="text-sm">Menampilkan obat dengan stok fisik <strong>kurang dari atau sama dengan {{ $limit }}</strong>.</p>
                </div>
                
                <a href="{{ route('clinical.reports.low_stock', ['action' => 'pdf']) }}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 flex items-center shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-10 text-center">No</th>
                            <th class="px-6 py-3">Kode Obat</th>
                            <th class="px-6 py-3">Nama Obat</th>
                            <th class="px-6 py-3 text-center">Satuan</th>
                            <th class="px-6 py-3 text-center">Sisa Stok</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($data as $index => $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-mono text-slate-600">{{ $row->code }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $row->name }}</td>
                            <td class="px-6 py-4 text-center">{{ $row->unit }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-red-600 font-bold text-lg">{{ $row->current_stock }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($row->current_stock == 0)
                                    <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-bold">HABIS</span>
                                @else
                                    <span class="bg-amber-500 text-white px-2 py-1 rounded text-xs font-bold">KRITIS</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">
                                Aman! Tidak ada obat dengan stok di bawah {{ $limit }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>