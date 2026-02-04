<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Tambah Departemen') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <form action="{{ route('master.departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Kode Bagian</label>
                        <input type="text" name="code" class="w-full rounded-lg border-slate-300 uppercase" placeholder="Contoh: TE" required maxlength="10">
                        <p class="text-xs text-slate-500 mt-1">Maksimal 10 karakter. Harus unik.</p>
                    </div>
                    <div class="mb-6">
                        <label class="block font-bold mb-1">Nama Bagian</label>
                        <input type="text" name="name" class="w-full rounded-lg border-slate-300" placeholder="Contoh: Teknik" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('master.departments.index') }}" class="px-4 py-2 text-slate-500">Batal</a>
                        <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>