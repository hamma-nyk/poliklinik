<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Data Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">
                
                <form action="{{ route('master.patients.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2 flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">ID Pasien</label>
                                <input type="text" value="{{ $patient->code }}" disabled class="w-full bg-slate-100 text-slate-500 rounded-lg font-mono">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Tipe Pasien</label>
                                <input type="text" value="{{ ucfirst($patient->type) }}" disabled class="w-full bg-slate-100 text-slate-500 rounded-lg">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $patient->name }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK KTP</label>
                            <input type="text" name="nik_ktp" value="{{ $patient->nik_ktp }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $patient->birth_date }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                            <select name="gender" class="w-full rounded-lg border-slate-300">
                                <option value="L" {{ $patient->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $patient->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon</label>
                            <input type="text" name="phone" value="{{ $patient->phone }}" class="w-full rounded-lg border-slate-300">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili</label>
                            <input type="text" name="address" value="{{ $patient->address }}" class="w-full rounded-lg border-slate-300">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                            <select name="blood_type" class="w-full rounded-lg border-slate-300">
                                @foreach(['','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $patient->blood_type == $gol ? 'selected' : '' }}>{{ $gol ?: '-' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-red-600 mb-2">Riwayat Alergi Obat</label>
                            <textarea name="allergies" rows="2" class="w-full rounded-lg border-red-200 bg-red-50 focus:border-red-500">{{ $patient->allergies }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.patients.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>