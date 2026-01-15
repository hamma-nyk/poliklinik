<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Input Hasil Lab') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                
                <form action="{{ route('clinical.lab.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block font-bold mb-2">Pilih Pasien</label>
                        <select name="patient_id" class="w-full rounded-lg border-slate-300" required>
                            <option value="">-- Cari Nama --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-500 mb-1">Gula Darah (mg/dL)</label>
                            <input type="number" name="gula_darah" class="w-full rounded-lg border-slate-300 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-500 mb-1">Kolesterol (mg/dL)</label>
                            <input type="number" name="kolesterol" class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-500 mb-1">Asam Urat (mg/dL)</label>
                            <input type="number" step="0.1" name="asam_urat" class="w-full rounded-lg border-slate-300 focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-500 mb-1">Tensi (mmHg)</label>
                            <input type="text" name="tensi" placeholder="120/80" class="w-full rounded-lg border-slate-300">
                        </div>
                    </div>
<div class="mb-6">
    <label class="block font-bold mb-2">Petugas Pemeriksa</label>
    <select name="petugas_selection" class="w-full rounded-lg border-slate-300" required>
        <option value="">-- Pilih Petugas --</option>
        
        <optgroup label="Dokter">
            @foreach($doctors as $d)
                <option value="doc_{{ $d->id }}">{{ $d->name }}</option>
            @endforeach
        </optgroup>

        <optgroup label="Perawat">
            @foreach($nurses as $n)
                <option value="nur_{{ $n->id }}">{{ $n->name }}</option>
            @endforeach
        </optgroup>
    </select>
</div>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-500 mb-1">Catatan (Opsional)</label>
                        <textarea name="notes" class="w-full rounded-lg border-slate-300" rows="2"></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('clinical.lab.index') }}" class="px-4 py-2 text-slate-500">Batal</a>
                        <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg font-bold">Simpan Hasil</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>