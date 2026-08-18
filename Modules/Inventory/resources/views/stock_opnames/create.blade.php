<x-app-layout title="Input Stok Opname">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">
                    {{ __('Stok Opname Baru') }}
                </h2>
                <p class="text-sm text-neutral-500 mt-1 dark:text-neutral-400">Pencatatan fisik inventaris dan penyesuaian sistem</p>
            </div>
            <a href="{{ route('inventory.stock-opnames.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 hover:text-neutral-900 h-9 px-4 py-2 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:hover:text-neutral-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Batal
            </a>
        </div>
    </x-slot>

    <div class="py-6 flex-1 space-y-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventory.stock-opnames.store') }}" method="POST">
                @csrf
                
                {{-- Form Administrasi --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6 mb-8 transition-all">
                    <h3 class="text-xs font-semibold uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-6 flex items-center">
                        <span class="bg-neutral-900 dark:bg-neutral-50 w-1 h-4 rounded-full mr-3"></span>
                        Informasi Dokumen
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 ml-1 block">No. Opname</label>
                            <input type="text" name="opname_number" value="{{ $opnameNumber }}" readonly 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-neutral-100 px-3 py-1 text-sm shadow-sm transition-colors dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-400 font-mono cursor-not-allowed">
                        </div>
                        <div>
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 ml-1 block">Tanggal Pemeriksaan</label>
                            <input type="date" name="opname_date" value="{{ date('Y-m-d') }}" 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>
                        <div>
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 mb-2 ml-1 block">Catatan / Referensi</label>
                            <input type="text" name="notes" placeholder="Contoh: SO Rutin Gudang A" 
                                class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                        </div>
                    </div>
                </div>

                {{-- Tabel Opname --}}
                <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 overflow-hidden mb-8 transition-all">
                    <div class="p-5 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-800/30 flex items-center text-amber-800 dark:text-amber-400 text-sm">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium"><strong>Instruksi:</strong> Masukkan jumlah item yang ditemukan secara fisik. Sistem akan otomatis menghitung selisih dan menyesuaikan stok sistem setelah data disimpan.</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&_tr]:border-b">
                                <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 text-[11px] font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Item Obat / Logistik</th>
                                    <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Stok Sistem</th>
                                    <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Stok Fisik</th>
                                    <th class="h-12 px-4 text-center align-middle font-medium text-neutral-500 dark:text-neutral-400">Selisih</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Satuan</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-neutral-500 dark:text-neutral-400">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="[&_tr:last-child]:border-0">
                                @foreach($medicines as $med)
                                <tr class="border-b transition-colors hover:bg-neutral-100/50 dark:border-neutral-600 dark:hover:bg-neutral-700/50 group">
                                    <td class="p-4 align-middle">
                                        <div class="font-bold">{{ $med->name }}</div>
                                        <div class="text-[10px] text-neutral-500 dark:text-neutral-400 font-mono mt-0.5 tracking-tighter uppercase">{{ $med->code }}</div>
                                    </td>
                                    
                                    <td class="p-4 align-middle text-center">
                                        <input type="hidden" name="items[{{ $med->id }}][system_stock]" value="{{ $med->current_stock }}" class="system-stock">
                                        <span class="font-mono text-base font-black tabular-nums">{{ $med->current_stock }}</span>
                                    </td>

                                    <td class="p-4 align-middle text-center">
                                        <input type="number" name="items[{{ $med->id }}][physical_stock]" 
                                            value="{{ $med->current_stock }}" 
                                            class="physical-input flex h-8 w-20 text-center mx-auto rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300 font-mono tabular-nums"
                                            min="0" required>
                                    </td>

                                    <td class="p-4 align-middle text-center">
                                        <span class="diff-display font-black text-base tracking-tighter transition-colors">0</span>
                                    </td>

                                    <td class="p-4 align-middle">
                                        <span class="px-2.5 py-1 bg-neutral-100 dark:bg-neutral-700 rounded-lg text-[10px] font-black text-neutral-500 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-600 uppercase tracking-widest">
                                            {{ $med->unit }}
                                        </span>
                                    </td>

                                    <td class="p-4 align-middle">
                                        <input type="text" name="items[{{ $med->id }}][opname_notes]" 
                                            class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-neutral-500 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-600 dark:placeholder:text-neutral-400 dark:focus-visible:ring-neutral-300">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-600 flex flex-col sm:flex-row justify-end gap-3 mb-12">
                    <p class="text-xs text-neutral-400 dark:text-neutral-500 italic mr-2 self-center">Pastikan semua data input sudah sesuai dengan fisik gudang.</p>
                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 disabled:pointer-events-none disabled:opacity-50 bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90 w-full md:w-auto uppercase tracking-wider" 
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
            // 1. Fokus hanya pada input angka (Stok Fisik)
            // Gunakan selector atribut agar lebih spesifik
            const physicalInputs = document.querySelectorAll('input[type="number"].physical-input');

            // 2. Fungsi hitung yang bisa dipanggil per baris
            function updateRowDiff(inputEl) {
                const row = inputEl.closest('tr');
                if (!row) return;

                const systemStock = parseInt(row.querySelector('.system-stock').value) || 0;
                const physicalStock = parseInt(inputEl.value) || 0;
                const diff = physicalStock - systemStock;
                const display = row.querySelector('.diff-display');

                if (display) {
                    display.textContent = (diff > 0 ? '+' : '') + diff;

                    // Color Logic
                    if (diff > 0) {
                        display.className = 'diff-display text-emerald-500 font-bold';
                    } else if (diff < 0) {
                        display.className = 'diff-display text-destructive font-bold';
                    } else {
                        display.className = 'diff-display font-bold text-base text-neutral-300 dark:text-neutral-600';
                    }
                }
            }

            // 3. Loop semua input untuk pasang Event Listener DAN hitung nilai awal
            physicalInputs.forEach(input => {
                // Jalankan saat user mengetik
                input.addEventListener('input', function() {
                    updateRowDiff(this);
                });

                // JALANKAN SEKARANG (saat page load) agar selisih muncul otomatis
                updateRowDiff(input);
            });
        });
    </script>
    @endpush
</x-app-layout>