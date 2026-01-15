<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Tambah Dokter Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">
                
                <form action="{{ route('master.doctors.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 p-4 bg-blue-50 border border-blue-100 rounded-lg flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm text-blue-700">ID Dokter akan digenerate otomatis (Format: <strong>DOK-YYYYMM-XXXX</strong>) setelah disimpan.</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap & Gelar</label>
                            <input type="text" name="name" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: dr. Budi Santoso, Sp.A" required>
                        </div>

                         <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK/KTP</label>
                            <input type="text" name="nik_ktp" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: 3314..." required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor SIP</label>
                            <input type="text" name="sip" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="503/SIP-DOK/...">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Spesialisasi</label>
                            <select name="specialization" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Umum">Dokter Umum</option>
                                <option value="Gigi">Dokter Gigi</option>
                                <option value="Penyakit Dalam">Spesialis Penyakit Dalam</option>
                                <option value="Anak">Spesialis Anak</option>
                                <option value="Kandungan">Spesialis Kandungan</option>
                                <option value="Bedah">Spesialis Bedah</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="0812...">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.doctors.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition transform hover:-translate-y-0.5">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>