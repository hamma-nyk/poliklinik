<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">
                
                <form action="{{ route('master.doctors.update', $doctor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">ID Dokter</label>
                            <input type="text" value="{{ $doctor->code }}" disabled class="w-full bg-slate-100 text-slate-500 rounded-lg border-slate-200 font-mono">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" value="{{ $doctor->name }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK/KTP</label>
                            <input type="text" name="nik_ktp" value="{{ $doctor->nik_ktp }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor SIP</label>
                            <input type="text" name="sip" value="{{ $doctor->sip }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Spesialisasi</label>
                            <select name="specialization" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                @foreach(['Umum', 'Gigi', 'Penyakit Dalam', 'Anak', 'Kandungan', 'Bedah'] as $spec)
                                    <option value="{{ $spec }}" {{ $doctor->specialization == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ $doctor->phone }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2 mt-4 p-5 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                            <div>
                                <span class="block font-bold text-slate-800">Status Praktik</span>
                                <span class="text-xs text-slate-500">Matikan jika dokter sedang cuti atau tidak aktif.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $doctor->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.doctors.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition transform hover:-translate-y-0.5">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>