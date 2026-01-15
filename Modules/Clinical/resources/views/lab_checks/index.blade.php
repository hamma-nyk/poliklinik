<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Cek Lab Sederhana (POCT)') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between mb-4">
                <form class="flex gap-2">
                    <input type="text" name="search" placeholder="Cari Pasien..." class="rounded-lg border-slate-300">
                    <button type="submit" class="bg-slate-800 text-white px-4 rounded-lg">Cari</button>
                </form>
                <a href="{{ route('clinical.lab.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    + Cek Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-slate-200">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Pasien</th>
                            <th class="px-6 py-3 text-center">Gula Darah</th>
                            <th class="px-6 py-3 text-center">Kolesterol</th>
                            <th class="px-6 py-3 text-center">Asam Urat</th>
                            <th class="px-6 py-3">Petugas</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($checks as $chk)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                {{ $chk->created_at->format('d/m/Y') }}<br>
                                <span class="text-xs text-slate-400">{{ $chk->created_at->format('H:i') }}</span>
                                <div class="font-bold text-blue-700">{{ $chk->code ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ $chk->patient->name }} 
                                <div class="text-xs text-slate-500">
                                    {{ $chk->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} 
                                    ({{ \Carbon\Carbon::parse($chk->patient->birth_date)->age }} Thn)
                                </div>
                                <div class="mt-1">
                                    @if($chk->patient->type == 'karyawan')
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800">KARYAWAN</span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">UMUM/KELUARGA</span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($chk->gula_darah)
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $chk->status_gula == 'danger' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $chk->gula_darah }}
                                    </span>
                                @else - @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($chk->kolesterol)
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $chk->status_kolesterol == 'danger' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $chk->kolesterol }}
                                    </span>
                                @else - @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($chk->asam_urat)
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $chk->status_asam_urat == 'danger' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $chk->asam_urat }}
                                    </span>
                                @else - @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
    {{ $chk->petugas_name }}
</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('clinical.lab.destroy', $chk->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $checks->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>