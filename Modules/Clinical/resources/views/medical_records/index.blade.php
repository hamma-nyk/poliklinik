<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Riwayat Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <form method="GET" class="w-full md:w-1/3 relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari RM / Pasien / Diagnosa..." 
                           class="w-full rounded-lg border-slate-300 pl-10 focus:border-blue-500 focus:ring-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>

                <a href="{{ route('clinical.records.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md text-sm transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Input Pemeriksaan Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu & No. RM</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Diagnosa (ICD)</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Dokter</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($records as $rm)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">
                                    {{ $rm->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-slate-500 mb-1">
                                    {{ $rm->created_at->format('H:i') }} WIB
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $rm->code }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-blue-700">{{ $rm->patient->name }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $rm->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} 
                                    ({{ \Carbon\Carbon::parse($rm->patient->birth_date)->age }} Thn)
                                </div>
                                <div class="mt-1">
                                    @if($rm->patient->type == 'karyawan')
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800">KARYAWAN</span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">UMUM/KELUARGA</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if($rm->diagnosis)
                                    <div class="text-sm font-bold text-slate-800">{{ $rm->diagnosis->name }}</div>
                                    <div class="text-xs font-mono text-slate-500">{{ $rm->diagnosis->code ?? '-' }}</div>
                                @else
                                    <span class="text-sm text-slate-400 italic">Belum ada diagnosa</span>
                                @endif
                                
                                <div class="text-xs text-slate-500 mt-1 truncate max-w-xs" title="{{ $rm->keluhan_utama }}">
                                    "{{ Str::limit($rm->keluhan_utama, 30) }}"
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600 mr-2">
                                        {{ substr($rm->doctor->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $rm->doctor->name }}</div>
                                        <div class="text-xs text-slate-500">Pemeriksa</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('clinical.records.show', $rm->id) }}" class="text-slate-600 hover:text-blue-600 font-bold mr-3" title="Lihat Detail">
                                    Detail
                                </a>
                                <a href="{{ route('clinical.records.print', $rm->id) }}" target="_blank" class="text-slate-400 hover:text-slate-600" title="Cetak PDF">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-sm font-medium">Belum ada data rekam medis.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-slate-200">
                    {{ $records->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>