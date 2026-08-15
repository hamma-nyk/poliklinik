<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Edit Data Karyawan') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Pembaruan informasi profil dan status kepegawaian</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 dark:text-slate-400">
                <span class="hover:text-slate-900 dark:hover:text-slate-50 cursor-pointer transition-colors"><a href="{{ route('master.employees.index') }}">Karyawan</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-900 dark:text-slate-50">Edit Data</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="rounded-xl border border-slate-200 bg-white text-slate-950 shadow dark:border-slate-800 dark:bg-slate-950 dark:text-slate-50 p-6 sm:p-8">
                
                <h3 class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-6 flex items-center">
                    <span class="bg-slate-900 dark:bg-slate-50 w-1 h-4 rounded-full mr-3"></span>
                    Perbarui Informasi Karyawan
                </h3>

                <form action="{{ route('master.employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- System ID (Read Only) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-slate-500">ID Sistem (Permanen)</label>
                            <input type="text" value="{{ $employee->code }}" disabled 
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-slate-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400 font-mono cursor-not-allowed">
                        </div>

                        {{-- NIK --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">NIK Perusahaan <span class="text-destructive">*</span></label>
                            <input type="text" name="nik" value="{{ $employee->nik }}"
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" required>
                        </div>

                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nama Lengkap <span class="text-destructive">*</span></label>
                            <input type="text" name="nama" value="{{ $employee->nama }}"
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300" required>
                        </div>

                        {{-- KTP --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. KTP</label>
                            <input type="text" name="ktp" value="{{ $employee->ktp }}"
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ $employee->birth_date }}"
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>

                        

{{-- 1. Departemen --}}
    <div class="space-y-2">
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Departemen (Bagian)</label>
        <select name="bag_dept" class="tom-select">
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
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Sub Bagian</label>
        <select name="subbag_dept" class="tom-select">
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
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Unit (Sub-Sub Bagian)</label>
        <select name="sub_subbag_dept" class="tom-select">
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
        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Jabatan</label>
        <select name="jabatan" class="tom-select">
            <option value="">-- Pilih Jabatan --</option>
            @foreach($positions as $pos)
                <option value="{{ $pos->code }}" {{ strtoupper(trim($employee->jabatan)) == strtoupper(trim($pos->code)) ? 'selected' : '' }}>
                    {{ $pos->code }} - {{ $pos->name }}
                </option>
            @endforeach
        </select>
    </div>

{{-- SCRIPT TOM SELECT --}}
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.tom-select').forEach((el) => {
            new TomSelect(el, {
                create: false,
                sortField: { field: "text", order: "asc" }
            });
        });
    });
</script>
@endpush

{{-- STYLE AGAR MIRIP INPUT BAWAAN --}}
@push('styles')
<style>
    /* TomSelect Dark Mode Styling */
    .ts-wrapper.single .ts-control { 
        border-radius: 0.375rem !important; 
        padding: 0.25rem 0.75rem !important; 
        height: 36px !important;
        border-color: #e2e8f0 !important; 
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        font-size: 0.875rem !important;
        display: flex;
        align-items: center;
        background-color: transparent !important;
    }
    .dark .ts-wrapper.single .ts-control { 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-wrapper.single .ts-control input {
        font-size: 0.875rem !important;
    }
    .dark .ts-wrapper.single .ts-control input {
        color: #f8fafc !important;
    }
    .ts-dropdown { 
        border-radius: 0.375rem !important;
        border-color: #e2e8f0 !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        font-size: 0.875rem !important;
        z-index: 50 !important;
    }
    .dark .ts-dropdown { 
        background-color: #020617 !important; 
        border-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .ts-dropdown .option {
        padding: 8px 12px !important;
    }
    .ts-dropdown .active { 
        background-color: #f1f5f9 !important; 
        color: #0f172a !important; 
    }
    .dark .ts-dropdown .active { 
        background-color: #1e293b !important; 
        color: #f8fafc !important; 
    }
    .dark .ts-dropdown .option { 
        color: #cbd5e1; 
    }
</style>
@endpush

                        {{-- Gender --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Jenis Kelamin</label>
                            <select name="gender" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
                                <option value="L" {{ $employee->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $employee->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- Blood Type --}}
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Golongan Darah</label>
                            <select name="blood" class="flex h-9 w-full items-center justify-between whitespace-nowrap rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:ring-offset-slate-950 dark:placeholder:text-slate-400 dark:focus:ring-slate-300">
                                @foreach(['','A','B','AB','O'] as $gol)
                                <option value="{{ $gol }}" {{ $employee->blood == $gol ? 'selected' : '' }}>{{ $gol ?: '-' }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Alamat Domisili</label>
                            <textarea name="alamat" rows="2"
                                class="flex min-h-[80px] w-full rounded-md border border-slate-200 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">{{ $employee->alamat }}</textarea>
                        </div>

                        {{-- Phone --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">No. Telepon / HP</label>
                            <input type="text" name="phone" value="{{ $employee->phone }}"
                                class="flex h-9 w-full rounded-md border border-slate-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-800 dark:placeholder:text-slate-400 dark:focus-visible:ring-slate-300">
                        </div>

                        {{-- Status Switch --}}
                        <div class="md:col-span-2 mt-4 p-5 bg-slate-50 dark:bg-slate-900 rounded-md border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div class="pr-4">
                                <span class="block text-sm font-medium leading-none">Status Kepegawaian</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400">Matikan switch ini jika karyawan sudah keluar (Resign/PHK) untuk menonaktifkan akun sistem.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $employee->is_status_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-slate-950 dark:peer-focus:ring-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 dark:after:border-slate-500 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900 dark:peer-checked:bg-slate-50"></div>
                            </label>
                        </div>

                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.employees.index') }}" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 border border-slate-200 bg-white shadow-sm hover:bg-slate-100 hover:text-slate-900 h-9 px-4 py-2 dark:border-slate-800 dark:bg-slate-950 dark:hover:bg-slate-800 dark:hover:text-slate-50">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-slate-950 disabled:pointer-events-none disabled:opacity-50 bg-slate-900 text-slate-50 shadow hover:bg-slate-900/90 h-9 px-4 py-2 dark:bg-slate-50 dark:text-slate-900 dark:hover:bg-slate-50/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>