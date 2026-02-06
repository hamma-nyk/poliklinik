<x-app-layout title="Buat Penyesuaian Stok">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight dark:text-slate-100">
            {{ __('Input Adjustment Manual') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen dark:bg-slate-900">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
                
                <form action="{{ route('inventory.adjustments.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Transaksi</label>
                            <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Tipe Adjustment --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Penyesuaian</label>
                            <select name="type" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="out">Pengurangan (Barang Rusak/Hilang)</option>
                                <option value="in">Penambahan (Barang Temuan/Bonus)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Pilih Obat --}}
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Obat</label>
                        <select name="medicine_id" id="medicine_select" class="select2 w-full rounded-xl border-slate-300">
                            <option value="">-- Cari Nama Obat --</option>
                            @foreach($medicines as $med)
                                <option value="{{ $med->id }}" data-stock="{{ $med->current_stock }}" data-unit="{{ $med->unit }}">
                                    {{ $med->name }} ({{ $med->code }})
                                </option>
                            @endforeach
                        </select>
                        
                        {{-- Info Stok Saat Ini --}}
                        <div id="stock_info" class="hidden mt-3 p-3 bg-blue-50 border border-blue-100 rounded-xl flex items-center text-blue-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold">
                                Stok saat ini: <span id="current_stock_display" class="text-lg">0</span> <span id="unit_display"></span>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        {{-- Qty --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah (Qty)</label>
                            <input type="number" name="quantity" min="1" placeholder="0" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 font-bold text-lg" required>
                            <p class="text-xs text-slate-500 mt-1">Masukkan angka positif saja (misal: 5).</p>
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alasan / Catatan</label>
                            <input type="text" name="notes" placeholder="Contoh: Botol pecah, Expired..." class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('inventory.adjustments.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                            Simpan Penyesuaian
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Pastikan jQuery & Select2 sudah diload di layout --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Cari obat...",
                allowClear: true,
                width: '100%'
            });

            // Logic Tampilkan Sisa Stok
            $('#medicine_select').on('change', function() {
                var selected = $(this).find(':selected');
                var stock = selected.data('stock');
                var unit = selected.data('unit');

                if (selected.val()) {
                    $('#current_stock_display').text(stock);
                    $('#unit_display').text(unit);
                    $('#stock_info').removeClass('hidden');
                } else {
                    $('#stock_info').addClass('hidden');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>