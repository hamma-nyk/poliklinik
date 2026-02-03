<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Edit Permission') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pembaruan kunci otoritas akses sistem</p>
            </div>
            <a href="{{ route('permissions.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Peringatan Kritis --}}
            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-6 rounded-r-2xl shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-black text-amber-800 dark:text-amber-300 uppercase tracking-tight">Perhatian Risiko Teknis</h3>
                        <p class="text-xs text-amber-700 dark:text-amber-400/80 mt-1 leading-relaxed">
                            Mengubah nama permission dapat menyebabkan fitur aplikasi **terkunci secara otomatis** jika kode program masih merujuk pada nama lama. Lakukan pembaruan pada <i>source code</i> segera setelah mengubah nama di sini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="p-8">
                    <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-8 flex items-center">
                        <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                        Ubah Informasi Permission
                    </h3>

                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2">Nama Permission (Teknis)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $permission->name) }}"
                                    class="w-full pl-11 rounded-xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:border-amber-500 focus:ring-amber-500 transition-all text-sm font-mono"
                                    required autofocus>
                            </div>
                            
                            @error('name')
                                <p class="text-rose-500 text-xs font-bold mt-2 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-end mt-10 gap-4">
                            <a href="{{ route('permissions.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                Batalkan
                            </a>
                            <button type="submit" class="w-full sm:w-auto bg-slate-900 dark:bg-amber-600 text-white px-8 py-3 rounded-2xl font-black hover:bg-slate-800 dark:hover:bg-amber-500 shadow-xl shadow-slate-200 dark:shadow-none transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                                Perbarui Otoritas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>