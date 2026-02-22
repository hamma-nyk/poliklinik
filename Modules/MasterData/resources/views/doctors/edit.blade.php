<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Edit Data Dokter') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pembaruan data profesional dan status operasional tenaga medis</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-slate-500 mt-2 md:mt-0 dark:text-slate-400">
                <span class="hover:text-blue-600 cursor-pointer transition-colors"><a href="{{ route('master.doctors.index') }}">Dokter</a></span>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Edit Profil</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700 p-8">
                
               <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-100 uppercase tracking-[0.2em] flex items-center mb-6">
                    <span class="bg-amber-500 w-1.5 h-5 rounded-full mr-3"></span>
                    Perbarui Informasi Dokter
                </h3>

                <form action="{{ route('master.doctors.update', $doctor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- ID Dokter (Read Only) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wide">ID Dokter (Sistem)</label>
                            <input type="text" value="{{ $doctor->code }}" disabled 
                                class="w-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 rounded-xl border-slate-200 dark:border-slate-600 font-mono cursor-not-allowed">
                        </div>

                        {{-- Nama --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ $doctor->name }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>

                        {{-- NIK --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">NIK / Nomor KTP <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_ktp" value="{{ $doctor->nik_ktp }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all" required>
                        </div>

                        {{-- SIP --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nomor SIP</label>
                            <input type="text" name="sip" value="{{ $doctor->sip }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Spesialisasi --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Spesialisasi</label>
                            <select name="specialization" 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                                @foreach(['Umum', 'Gigi', 'Penyakit Dalam', 'Anak', 'Kandungan', 'Bedah'] as $spec)
                                    <option value="{{ $spec }}" {{ $doctor->specialization == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" value="{{ $doctor->phone }}"
                                class="w-full rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 focus:ring-blue-500 transition-all">
                        </div>

                        {{-- Status Switch --}}
                        <div class="md:col-span-2 mt-4 p-5 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                            <div class="pr-4">
                                <span class="block font-bold text-slate-800 dark:text-slate-100">Status Praktik Aktif</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Matikan switch ini jika dokter sedang tidak melayani praktik (cuti/tidak aktif) untuk menyembunyikannya dari antrean.</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                <input type="checkbox" name="is_active" class="sr-only peer" {{ $doctor->is_active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 dark:bg-slate-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 dark:after:border-slate-500 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('master.doctors.index') }}" 
                            class="inline-flex justify-center items-center px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-2.5 rounded-xl bg-slate-900 dark:bg-blue-600 text-white font-bold hover:bg-blue-800 dark:hover:bg-blue-500 shadow-lg dark:shadow-none transition duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Perbarui Data Dokter
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>