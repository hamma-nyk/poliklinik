<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Data Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200 p-8">
                
                <form action="{{ route('master.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">System ID</label>
                            <input type="text" value="{{ $employee->code }}" disabled class="w-full bg-slate-100 text-slate-500 rounded-lg border-slate-200 font-mono">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK Perusahaan</label>
                            <input type="text" name="nik" value="{{ $employee->nik }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ $employee->nama }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. KTP</label>
                            <input type="text" name="ktp" value="{{ $employee->ktp }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $employee->birth_date }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Departemen</label>
                            <input type="text" name="bag_dept" value="{{ $employee->bag_dept }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ $employee->jabatan }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Gender</label>
                            <select name="gender" class="w-full rounded-lg border-slate-300">
                                <option value="L" {{ $employee->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $employee->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Golongan Darah</label>
                            <select name="blood" class="w-full rounded-lg border-slate-300">
                                @foreach(['','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $employee->blood == $gol ? 'selected' : '' }}>{{ $gol ?: '-' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili</label>
                            <input type="text" name="alamat" value="{{ $employee->alamat }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon / HP</label>
                            <input type="text" name="phone" value="{{ $employee->phone }}" class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                        </div>

                        <div class="md:col-span-2 mt-4 p-5 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                            <div>
                                <span class="block font-bold text-slate-800">Status Kepegawaian</span>
                                <span class="text-xs text-slate-500">Jika dimatikan, status di database menjadi 'KO' (Keluar/Non-Aktif).</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $employee->is_status_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('master.employees.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-blue-900 shadow-lg transition transform hover:-translate-y-0.5">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>