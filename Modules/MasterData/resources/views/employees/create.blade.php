<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Tambah Karyawan Manual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">
                
                <form action="{{ route('master.employees.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK Perusahaan (Wajib)</label>
                            <input type="text" name="nik" class="w-full rounded-lg border-slate-300 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full rounded-lg border-slate-300 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. KTP</label>
                            <input type="text" name="ktp" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Departemen</label>
                            <input type="text" name="bag_dept" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jabatan</label>
                            <input type="text" name="jabatan" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Gender</label>
                            <select name="gender" class="w-full rounded-lg border-slate-300">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                            <select name="blood" class="w-full rounded-lg border-slate-300">
                                <option value="">-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.employees.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>