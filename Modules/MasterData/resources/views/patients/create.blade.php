<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Registrasi Pasien Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl border border-slate-200 p-8" x-data="{ tab: 'employee' }">
                
                <form action="{{ route('master.patients.store') }}" method="POST">
                    @csrf
                    
                    <div class="flex p-1 space-x-1 bg-slate-100 rounded-xl mb-6">
                        <button type="button" @click="tab = 'employee'"
                                :class="tab === 'employee' ? 'bg-white shadow text-blue-700' : 'text-slate-600 hover:bg-white/[0.12]'"
                                class="w-full py-2.5 text-sm font-bold leading-5 rounded-lg transition-all duration-200">
                            Pilih dari Karyawan
                        </button>
                        <button type="button" @click="tab = 'general'"
                                :class="tab === 'general' ? 'bg-white shadow text-blue-700' : 'text-slate-600 hover:bg-white/[0.12]'"
                                class="w-full py-2.5 text-sm font-bold leading-5 rounded-lg transition-all duration-200">
                            Input Manual (Umum)
                        </button>
                    </div>
                    
                    <input type="hidden" name="registration_type" x-model="tab">

                    <div x-show="tab === 'employee'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                            <p class="text-sm text-blue-800 flex items-start">
                                <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Data (Nama, Tgl Lahir, Alamat) akan disalin otomatis dari Database HR. Pasien akan terhubung dengan data karyawan.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Cari Karyawan</label>
                            <select name="employee_id" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Karyawan Aktif --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">
                                        {{ $emp->nama }} - {{ $emp->bag_dept }} ({{ $emp->nik }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div x-show="tab === 'general'" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">NIK KTP</label>
                                <input type="text" name="nik_ktp" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                                <select name="gender" class="w-full rounded-lg border-slate-300">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon</label>
                                <input type="text" name="phone" class="w-full rounded-lg border-slate-300">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                                <input type="text" name="address" class="w-full rounded-lg border-slate-300">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                                <select name="blood_type" class="w-full rounded-lg border-slate-300">
                                    <option value="">-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <label class="block text-sm font-bold text-red-600 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Riwayat Alergi Obat
                        </label>
                        <textarea name="allergies" rows="2" class="w-full rounded-lg border-red-200 bg-red-50 focus:border-red-500 focus:ring-red-500" placeholder="Sebutkan jika ada alergi obat..."></textarea>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.patients.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition">Simpan Pasien</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>