<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Permission Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg border border-slate-200">
                <div class="p-6">
                    
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700 mb-2">Nama Permission (Teknis)</label>
                            <input type="text" name="name" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="contoh: cetak_laporan_keuangan" required autofocus>
                            <p class="text-xs text-gray-500 mt-2">Gunakan huruf kecil dan underscore (_). Jangan pakai spasi.</p>
                            
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('permissions.index') }}" class="text-gray-600 underline mr-4 text-sm">Batal</a>
                            <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-md hover:bg-slate-800 transition font-bold text-sm">
                                Simpan Permission
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>