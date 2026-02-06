<x-app-layout title="Input Stok Opname">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
                    {{ __('Stok Opname Baru') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1 dark:text-slate-400">Pencatatan fisik inventaris dan penyesuaian sistem</p>
            </div>
            <a href="{{ route('inventory.stock-opnames.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Batal
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventory.stock-opnames.store') }}" method="POST">
                @csrf
                
                {{-- Form Administrasi --}}
                <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 mb-8 transition-all">
                    <h3 class="text-sm font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></span>
                        Informasi Dokumen
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2 ml-1">No. Opname</label>
                            <input type="text" name="opname_number" value="{{ $opnameNumber }}" readonly 
                                class="w-full bg-slate-100 dark:bg-slate-700/50 border-slate-200 dark:border-slate-600 rounded-xl font-mono font-bold text-indigo-600 dark:text-indigo-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2 ml-1">Tanggal Pemeriksaan</label>
                            <input type="date" name="opname_date" value="{{ date('Y-m-d') }}" 
                                class="w-full border-slate-200 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-2 ml-1">Catatan / Referensi</label>
                            <input type="text" name="notes" placeholder="Contoh: SO Rutin Gudang A" 
                                class="w-full border-slate-200 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-indigo-500 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Tabel Opname --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-8 transition-all">
                    <div class="p-5 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-800/30 flex items-center text-amber-800 dark:text-amber-400 text-sm">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium"><strong>Instruksi:</strong> Masukkan jumlah item yang ditemukan secara fisik. Sistem akan otomatis menghitung selisih dan menyesuaikan stok sistem setelah data disimpan.</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50/50 dark:bg-slate-900/30 text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                    <th class="px-8 py-4">Item Obat / Logistik</th>
                                    <th class="px-6 py-4 text-center w-32 bg-slate-100 dark:bg-slate-900/50">Stok Sistem</th>
                                    <th class="px-6 py-4 text-center w-48 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400">Stok Fisik</th>
                                    <th class="px-6 py-4 text-center w-32">Selisih</th>
                                    <th class="px-8 py-4">Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @foreach($medicines as $med)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition duration-150 group">
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-slate-800 dark:text-slate-100">{{ $med->name }}</div>
                                        <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono mt-0.5 tracking-tighter uppercase">{{ $med->code }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-5 text-center bg-slate-50/30 dark:bg-slate-900/20">
                                        <input type="hidden" name="items[{{ $med->id }}][system_stock]" value="{{ $med->current_stock }}" class="system-stock">
                                        <span class="font-mono text-base font-black text-slate-600 dark:text-slate-400 tabular-nums">{{ $med->current_stock }}</span>
                                    </td>

                                    <td class="px-6 py-5 bg-indigo-50/10 dark:bg-indigo-900/10">
                                        <input type="number" name="items[{{ $med->id }}][physical_stock]" 
                                            value="{{ $med->current_stock }}" 
                                            class="physical-input w-full text-center font-black text-indigo-700 dark:text-indigo-400 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 rounded-xl transition-all tabular-nums"
                                            min="0" required>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        <span class="diff-display font-black text-base tracking-tighter transition-colors">0</span>
                                    </td>

                                    <td class="px-8 py-5">
                                        <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-[10px] font-black text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-600 uppercase tracking-widest">
                                            {{ $med->unit }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="flex flex-col md:flex-row justify-end items-center gap-4 mb-12">
                    <p class="text-xs text-slate-400 dark:text-slate-500 italic mr-2 text-center md:text-right">Pastikan semua data input sudah sesuai dengan fisik gudang.</p>
                    <button type="submit" class="w-full md:w-auto px-10 py-4 rounded-2xl bg-indigo-600 text-white font-black hover:bg-indigo-700 shadow-xl shadow-indigo-500/20 transform hover:-translate-y-1 active:scale-95 transition-all uppercase tracking-widest text-sm" 
                        onclick="return confirm('Konfirmasi Penyesuaian Stok? Tindakan ini akan memperbarui saldo stok di sistem secara otomatis.')">
                        Simpan & Finalisasi Stok
                    </button>
                </div>
            </form>
        </div>
    </div>

    [Image of medical inventory management system and stock checking audit]

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.physical-input');

            inputs.forEach(input => {
                input.addEventListener('input', calculateDiff);
                // Trigger once on load
                calculateDiff({ target: input });
            });

            function calculateDiff(e) {
                const row = e.target.closest('tr');
                const systemStock = parseInt(row.querySelector('.system-stock').value) || 0;
                const physicalStock = parseInt(e.target.value) || 0;
                const diff = physicalStock - systemStock;
                const display = row.querySelector('.diff-display');

                display.textContent = (diff > 0 ? '+' : '') + diff;

                // Color Logic
                if (diff > 0) {
                    display.className = 'diff-display font-black text-base text-emerald-600 dark:text-emerald-400';
                } else if (diff < 0) {
                    display.className = 'diff-display font-black text-base text-rose-600 dark:text-rose-400';
                } else {
                    display.className = 'diff-display font-black text-base text-slate-300 dark:text-slate-600';
                }
            }
        });
    </script>
    @endpush
</x-app-layout>