<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Tambah Sub Bagian') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                <form action="{{ route('master.sub-departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block font-bold mb-2 text-slate-700">Kode Sub Bagian</label>
                        <input type="text" name="code" class="w-full rounded-lg border-slate-300 uppercase focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: PMP" required maxlength="10">
                        <p class="text-xs text-slate-500 mt-1">Maksimal 10 karakter. Kode harus unik.</p>
                    </div>
                    <div class="mb-8">
                        <label class="block font-bold mb-2 text-slate-700">Nama Sub Bagian</label>
                        <input type="text" name="name" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Pemeliharaan Perbaikan" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('master.sub-departments.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-bold hover:bg-slate-50">Batal</a>
                        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-900 shadow-lg transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>