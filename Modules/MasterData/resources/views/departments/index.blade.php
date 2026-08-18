<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-800">{{ __('Master Departemen (Bagian)') }}</h2>
    </x-slot>

    <div class="py-12" x-data="{ openImport: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <button @click="openImport = true" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Excel
                </button>

                <a href="{{ route('master.departments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700">
                    + Tambah Baru
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-xl border border-neutral-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-neutral-100 text-neutral-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-20">Kode</th>
                            <th class="px-6 py-3">Nama Bagian</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @foreach($departments as $dept)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 font-mono font-bold">{{ $dept->code }}</td>
                            <td class="px-6 py-4">{{ $dept->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('master.departments.edit', $dept->id) }}" class="text-blue-600 hover:underline font-bold mr-3">Edit</a>
                                <form action="{{ route('master.departments.destroy', $dept->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 border-t border-neutral-200">
                    {{ $departments->links() }}
                </div>
            </div>
        </div>

        <div x-show="openImport" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6" @click.away="openImport = false">
                <h3 class="text-lg font-bold mb-4">Import Data Excel</h3>
                
                <form action="{{ route('master.departments.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Pilih File (.xlsx / .csv)</label>
                        <input type="file" name="file" class="w-full border rounded p-2 text-sm" required>
                    </div>

                    <div class="mb-6 bg-blue-50 p-3 rounded text-xs text-blue-700">
                        <p class="font-bold">Format Excel Wajib:</p>
                        <ul class="list-disc ml-4 mt-1">
                            <li>Header kolom A: <b>code</b></li>
                            <li>Header kolom B: <b>name</b></li>
                        </ul>
                        <div class="mt-2">
                            <a href="{{ route('master.departments.template') }}" class="underline text-blue-800">Download Template CSV</a>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openImport = false" class="px-4 py-2 text-neutral-500">Batal</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>