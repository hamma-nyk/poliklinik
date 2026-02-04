<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Edit Data Karyawan') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pembaruan informasi profil dan status kepegawaian</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors">Karyawan</span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Edit Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-amber-500 rounded-full mr-3"></span>
                    Perbarui Informasi Karyawan
                </h3>

                <form action="{{ route('master.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- System ID (Read Only) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide">ID Sistem (Permanen)</label>
                            <input type="text" value="{{ $employee->code }}" disabled 
                                class="w-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 rounded-xl border-slate-200 dark:border-slate-600 font-mono cursor-not-allowed">
                        </div>

                        {{-- NIK --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">NIK Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" value="{{ $employee->nik }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>

                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ $employee->nama }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>

                        {{-- KTP --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">No. KTP</label>
                            <input type="text" name="ktp" value="{{ $employee->ktp }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $employee->birth_date }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        @push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Custom Style biar Select2 cocok sama Tailwind */
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-color: #e2e8f0 !important; /* slate-200 */
        border-radius: 0.75rem !important; /* rounded-xl */
        padding-top: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
    }
</style>
@endpush

{{-- 1. Departemen --}}
    <div class="space-y-2">
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Departemen (Bagian)</label>
        <select name="bag_dept" class="select2 w-full">
            <option value="">-- Pilih Departemen --</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->code }}" {{ strtoupper(trim($employee->bag_dept)) == strtoupper(trim($dept->code)) ? 'selected' : '' }}>
                    {{ $dept->code }} - {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- 2. Bagian (Sub Dept) --}}
    <div class="space-y-2">
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Sub Bagian</label>
        <select name="subbag_dept" class="select2 w-full">
            <option value="">-- Pilih Sub Bagian --</option>
            @foreach($subDepartments as $sub)
                <option value="{{ $sub->code }}" {{ strtoupper(trim($employee->subbag_dept)) == strtoupper(trim($sub->code)) ? 'selected' : '' }}>
                    {{ $sub->code }} - {{ $sub->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- 3. Sub Sub Bagian (Unit) --}}
    <div class="space-y-2">
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Unit (Sub-Sub Bagian)</label>
        <select name="sub_subbag_dept" class="select2 w-full">
            <option value="">-- Pilih Unit --</option>
            @foreach($units as $unit)
                <option value="{{ $unit->code }}" {{ strtoupper(trim($employee->sub_subbag_dept)) == strtoupper(trim($unit->code)) ? 'selected' : '' }}>
                    {{ $unit->code }} - {{ $unit->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- 4. Jabatan --}}
    <div class="space-y-2">
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Jabatan</label>
        <select name="jabatan" class="select2 w-full">
            <option value="">-- Pilih Jabatan --</option>
            @foreach($positions as $pos)
                <option value="{{ $pos->code }}" {{ strtoupper(trim($employee->jabatan)) == strtoupper(trim($pos->code)) ? 'selected' : '' }}>
                    {{ $pos->code }} - {{ $pos->name }}
                </option>
            @endforeach
        </select>
    </div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%', // Agar lebar mengikuti parent div
            placeholder: "Ketik untuk mencari...",
            allowClear: true
        });
    });
</script>
@endpush

                        {{-- Gender --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
                            <select name="gender" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                <option value="L" {{ $employee->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $employee->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- Blood Type --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Golongan Darah</label>
                            <select name="blood" class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                @foreach(['','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $employee->blood == $gol ? 'selected' : '' }}>{{ $gol ?: '-' }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Alamat Domisili</label>
                            <textarea name="alamat" rows="2"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">{{ $employee->alamat }}</textarea>
                        </div>

                        {{-- Phone --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">No. Telepon / HP</label>
                            <input type="text" name="phone" value="{{ $employee->phone }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Status Switch --}}
                        <div class="md:col-span-2 mt-4 p-5 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                            <div class="pr-4">
                                <span class="block font-bold text-slate-800 dark:text-slate-100">Status Kepegawaian</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Matikan switch ini jika karyawan sudah keluar (Resign/PHK) untuk menonaktifkan akun sistem.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $employee->is_status_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 dark:bg-slate-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 dark:after:border-slate-500 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.employees.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-slate-900 dark:bg-blue-600 text-white font-bold hover:bg-blue-800 dark:hover:bg-blue-500 shadow-lg dark:shadow-none transition duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Data Karyawan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>