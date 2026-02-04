<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Edit Jabatan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                <form action="{{ route('master.positions.update', $position->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block font-bold mb-2 text-slate-700">Kode Jabatan</label>
                        <input type="text" name="code" value="{{ $position->code }}" class="w-full rounded-lg border-slate-300 uppercase focus:border-blue-500 focus:ring-blue-500 bg-slate-50 font-mono" required maxlength="10">
                    </div>
                    <div class="mb-8">
                        <label class="block font-bold mb-2 text-slate-700">Nama Jabatan</label>
                        <input type="text" name="name" value="{{ $position->name }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('master.positions.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-bold hover:bg-slate-50">Batal</a>
                        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-blue-900 shadow-lg transition transform hover:-translate-y-0.5">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>