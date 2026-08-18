<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-800">{{ __('Master Jabatan') }}</h2>
    </x-slot>

    <div class="py-12" x-data="{ openImport: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-lg border border-green-200 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <button @click="openImport = true" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 flex items-center shadow-md transition transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Excel
                </button>

                <a href="{{ route('master.positions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 shadow-md transition transform hover:-translate-y-0.5">
                    + Tambah Jabatan
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-xl border border-neutral-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-neutral-100 text-neutral-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-24">Kode</th>
                            <th class="px-6 py-3">Nama Jabatan</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($positions as $pos)
                        <tr class="hover:bg-neutral-50 transition">
                            <td class="px-6 py-4">
                                <span class="bg-neutral-100 text-neutral-700 font-mono font-bold px-2 py-1 rounded border border-neutral-300 text-xs">
                                    {{ $pos->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-neutral-700">{{ $pos->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('master.positions.edit', $pos->id) }}" class="text-blue-600 hover:underline font-bold mr-3">Edit</a>
                                <form action="{{ route('master.positions.destroy', $pos->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jabatan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-neutral-400 italic">
                                Belum ada data jabatan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-neutral-200 bg-neutral-50">
                    {{ $positions->links() }}
                </div>
            </div>
        </div>

        <div x-show="openImport" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" x-cloak>
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 @click.away="openImport = false">
                
                <h3 class="text-lg font-bold mb-4 text-neutral-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Import Data Jabatan
                </h3>
                
                <form action="{{ route('master.positions.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-neutral-600">Pilih File (.xlsx / .csv)</label>
                        <input type="file" name="file" class="w-full border rounded-lg p-2 text-sm bg-neutral-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                    </div>

                    <div class="mb-6 bg-blue-50 p-4 rounded-lg text-xs text-blue-700 border border-blue-100">
                        <p class="font-bold mb-1">Panduan Import:</p>
                        <ul class="list-disc ml-4 space-y-1">
                            <li>Header kolom A: <b>code</b> (Kode Jabatan)</li>
                            <li>Header kolom B: <b>name</b> (Nama Jabatan)</li>
                        </ul>
                        <div class="mt-3">
                            <a href="{{ route('master.positions.template') }}" class="inline-flex items-center underline font-bold hover:text-blue-900">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Download Template CSV
                            </a>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openImport = false" class="px-4 py-2 text-neutral-500 hover:text-neutral-700 font-bold">Batal</button>
                        <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-lg font-bold hover:bg-green-700 shadow-lg transition">Upload Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>