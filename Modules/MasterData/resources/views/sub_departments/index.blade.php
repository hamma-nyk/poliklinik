<x-app-layout>
    <x-slot name="header">
<<<<<<< HEAD
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight leading-tight">{{ __('Master Sub Bagian') }}</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Manajemen Data Sub Bagian</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <span>Master Data</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Sub Bagian</span>
            </div>
        </div>
=======
        <h2 class="font-semibold text-xl text-neutral-800">{{ __('Master Sub Bagian') }}</h2>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
    </x-slot>

    <div class="space-y-6" x-data="{ openImport: false }">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm relative dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200 flex items-center">
                <svg class="w-4 h-4 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-emerald-600 hover:text-emerald-900 dark:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

<<<<<<< HEAD
        <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-4 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
            <button @click="openImport = true" type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import Excel
            </button>

            <a href="{{ route('master.sub-departments.create') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Sub Bagian
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b">
                        <tr class="border-b border-neutral-200 dark:border-neutral-600">
                            <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400 w-28">Kode</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Nama Sub Bagian</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-neutral-500 dark:text-neutral-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        @forelse($subDepartments as $item)
                        <tr class="border-b border-neutral-200 transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50">
                            <td class="p-4 align-middle font-mono font-semibold whitespace-nowrap">{{ $item->code }}</td>
                            <td class="p-4 align-middle">{{ $item->name }}</td>
                            <td class="p-4 align-middle text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('master.sub-departments.edit', $item->id) }}" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-neutral-200 bg-white px-3 py-1.5 hover:bg-neutral-100 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700">Edit</a>
=======
            <div class="bg-white shadow-sm sm:rounded-xl border border-neutral-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-neutral-100 text-neutral-500 uppercase font-bold">
                        <tr>
                            <th class="px-6 py-3 w-24">Kode</th>
                            <th class="px-6 py-3">Nama Sub Bagian</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($subDepartments as $item)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 font-mono font-bold text-neutral-700">{{ $item->code }}</td>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('master.sub-departments.edit', $item->id) }}" class="text-blue-600 hover:underline font-bold mr-3">Edit</a>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                                <form action="{{ route('master.sub-departments.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-xs font-medium border border-red-200 text-red-600 bg-white px-3 py-1.5 hover:bg-red-50 dark:border-red-800 dark:bg-neutral-800 dark:text-red-400 dark:hover:bg-red-950/50">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
<<<<<<< HEAD
                            <td colspan="3" class="p-6 text-center text-neutral-500 dark:text-neutral-400">Belum ada data sub bagian.</td>
=======
                            <td colspan="3" class="px-6 py-6 text-center text-neutral-400 italic">Belum ada data sub bagian.</td>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                        </tr>
                        @endforelse
                    </tbody>
                </table>
<<<<<<< HEAD
=======
                <div class="p-4 border-t border-neutral-200">
                    {{ $subDepartments->links() }}
                </div>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
            </div>
            @if($subDepartments->hasPages())
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-600">
                {{ $subDepartments->links() }}
            </div>
            @endif
        </div>

<<<<<<< HEAD
        <div x-show="openImport" class="fixed inset-0 z-50 flex items-center justify-center bg-neutral-900/60 backdrop-blur-sm p-4" x-cloak>
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-600 rounded-xl shadow-lg w-full max-w-md p-6" @click.away="openImport = false">
                <h3 class="text-lg font-semibold mb-4 text-neutral-900 dark:text-neutral-50">Import Sub Bagian</h3>
=======
        <div x-show="openImport" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" x-cloak>
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6" @click.away="openImport = false">
                <h3 class="text-lg font-bold mb-4 text-neutral-800">Import Sub Bagian</h3>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                
                <form action="{{ route('master.sub-departments.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
<<<<<<< HEAD
                    <div>
                        <label class="block text-sm font-medium mb-2 text-neutral-700 dark:text-neutral-300">Pilih File (.xlsx / .csv)</label>
                        <input type="file" name="file" class="w-full rounded-md border border-neutral-200 dark:border-neutral-600 bg-transparent p-2 text-sm" required>
=======
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-neutral-600">Pilih File (.xlsx / .csv)</label>
                        <input type="file" name="file" class="w-full border rounded-lg p-2 text-sm bg-neutral-50" required>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                    </div>

                    <div class="bg-neutral-50 dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-600 p-3 rounded-md text-xs text-neutral-600 dark:text-neutral-300">
                        <p class="font-semibold mb-1">Panduan Import:</p>
                        <ul class="list-disc ml-4 space-y-0.5">
                            <li>Header kolom A: <b>code</b> (Wajib, Unik)</li>
                            <li>Header kolom B: <b>name</b> (Wajib)</li>
                        </ul>
                        <div class="mt-2">
                            <a href="{{ route('master.sub-departments.template') }}" class="underline font-medium text-neutral-900 dark:text-neutral-100">Download Template CSV</a>
                        </div>
                    </div>

<<<<<<< HEAD
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="openImport = false" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-neutral-200 dark:border-neutral-600 h-9 px-4 hover:bg-neutral-100 dark:hover:bg-neutral-700">Batal</button>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 h-9 px-4 hover:bg-neutral-900/90">Upload Data</button>
=======
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openImport = false" class="px-4 py-2 text-neutral-500 hover:text-neutral-700 font-bold">Batal</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-green-700 shadow-lg">Upload Data</button>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
