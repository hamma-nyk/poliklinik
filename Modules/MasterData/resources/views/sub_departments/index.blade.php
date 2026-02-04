<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Master Sub Bagian') }}</h2>
    </x-slot>

    <div class="py-12" x-data="{ openImport: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-lg border border-green-200">{{ session('success') }}</div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <button @click="openImport = true" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Excel
                </button>

                <a href="{{ route('master.sub-departments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 shadow-sm">
                    + Tambah Sub Bagian
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-xl border border-slate-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-24">Kode</th>
                            <th class="px-6 py-3">Nama Sub Bagian</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($subDepartments as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-mono font-bold text-slate-700">{{ $item->code }}</td>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('master.sub-departments.edit', $item->id) }}" class="text-blue-600 hover:underline font-bold mr-3">Edit</a>
                                <form action="{{ route('master.sub-departments.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-slate-400 italic">Belum ada data sub bagian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-slate-200">
                    {{ $subDepartments->links() }}
                </div>
            </div>
        </div>

        <div x-show="openImport" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" x-cloak>
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6" @click.away="openImport = false">
                <h3 class="text-lg font-bold mb-4 text-slate-800">Import Sub Bagian</h3>
                
                <form action="{{ route('master.sub-departments.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-slate-600">Pilih File (.xlsx / .csv)</label>
                        <input type="file" name="file" class="w-full border rounded-lg p-2 text-sm bg-slate-50" required>
                    </div>

                    <div class="mb-6 bg-blue-50 p-4 rounded-lg text-xs text-blue-700 border border-blue-100">
                        <p class="font-bold mb-1">Panduan Import:</p>
                        <ul class="list-disc ml-4 space-y-1">
                            <li>Header kolom A: <b>code</b> (Wajib, Unik)</li>
                            <li>Header kolom B: <b>name</b> (Wajib)</li>
                        </ul>
                        <div class="mt-3">
                            <a href="{{ route('master.sub-departments.template') }}" class="underline font-bold hover:text-blue-900">Download Template CSV</a>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openImport = false" class="px-4 py-2 text-slate-500 hover:text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-green-700 shadow-lg">Upload Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>