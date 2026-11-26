<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold tracking-tight leading-tight">{{ __('Tambah Unit') }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="w-full">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-neutral-200">
                <form action="{{ route('master.units.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block font-bold mb-2 text-neutral-700">Kode Unit</label>
                        <input type="text" name="code" class="w-full flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm dark:border-neutral-600 uppercase focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: U01" required maxlength="10">
                        <p class="text-xs text-neutral-500 mt-1">Maksimal 10 karakter. Kode harus unik.</p>
                    </div>
                    <div class="mb-8">
                        <label class="block font-bold mb-2 text-neutral-700">Nama Unit</label>
                        <input type="text" name="name" class="w-full flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm dark:border-neutral-600 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Unit Layanan A" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('master.units.index') }}" class="px-5 py-2.5 rounded-lg border border-neutral-300 text-neutral-600 font-bold hover:bg-neutral-50">Batal</a>
                        <button type="submit" class="bg-neutral-900 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-900 shadow-lg transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>