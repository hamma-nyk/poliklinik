<x-app-layout>
    <x-slot name="header">
<<<<<<< HEAD
        <h2 class="text-2xl font-semibold tracking-tight leading-tight">{{ __('Tambah Departemen') }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="w-full">
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
=======
        <h2 class="font-semibold text-xl text-neutral-800">{{ __('Tambah Departemen') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                <form action="{{ route('master.departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Kode Bagian</label>
<<<<<<< HEAD
                        <input type="text" name="code" class="w-full flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm dark:border-neutral-600 uppercase" placeholder="Contoh: TE" required maxlength="10">
=======
                        <input type="text" name="code" class="w-full rounded-lg border-neutral-300 uppercase" placeholder="Contoh: TE" required maxlength="10">
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                        <p class="text-xs text-neutral-500 mt-1">Maksimal 10 karakter. Harus unik.</p>
                    </div>
                    <div class="mb-6">
                        <label class="block font-bold mb-1">Nama Bagian</label>
<<<<<<< HEAD
                        <input type="text" name="name" class="w-full flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm dark:border-neutral-600" placeholder="Contoh: Teknik" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('master.departments.index') }}" class="px-4 py-2 text-neutral-500">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900">Simpan</button>
=======
                        <input type="text" name="name" class="w-full rounded-lg border-neutral-300" placeholder="Contoh: Teknik" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('master.departments.index') }}" class="px-4 py-2 text-neutral-500">Batal</a>
                        <button type="submit" class="bg-neutral-900 text-white px-6 py-2 rounded-lg font-bold">Simpan</button>
>>>>>>> 23ad60cfbf37ce4acfb2ea1596ac1bb7fee91687
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>