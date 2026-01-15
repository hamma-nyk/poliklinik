<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800">{{ __('Input Rekam Medis Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('clinical.records.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                            <h3 class="font-bold text-slate-800 mb-4">1. Identitas & Petugas</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Pasien</label>
                                <select name="patient_id" class="w-full rounded-lg border-slate-300" required>
                                    <option value="">Pilih Pasien...</option>
                                    @foreach($patients as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Dokter Pemeriksa</label>
                                <select name="doctor_id" class="w-full rounded-lg border-slate-300" required>
                                    <option value="">Pilih Dokter...</option>
                                    @foreach($doctors as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Perawat (Opsional)</label>
                                <select name="nurse_id" class="w-full rounded-lg border-slate-300">
                                    <option value="">-</option>
                                    @foreach($nurses as $n)
                                        <option value="{{ $n->id }}">{{ $n->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                            <h3 class="font-bold text-slate-800 mb-4">2. Tanda Vital (Fisik)</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-500">Tensi (mmHg)</label>
                                    <input type="text" name="tensi" placeholder="120/80" class="w-full rounded-lg border-slate-300">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500">Suhu (°C)</label>
                                    <input type="number" step="0.1" name="suhu_tubuh" class="w-full rounded-lg border-slate-300">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500">Berat (Kg)</label>
                                    <input type="number" step="0.1" name="berat_badan" class="w-full rounded-lg border-slate-300">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-500">Tinggi (cm)</label>
                                    <input type="number" step="0.1" name="tinggi_badan" class="w-full rounded-lg border-slate-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h3 class="font-bold text-slate-800 mb-4">3. Anamnesa & Pemeriksaan</h3>
        
        <div class="mb-4">
            <label class="block text-sm font-bold text-slate-700 mb-1">Keluhan Utama (S)</label>
            <textarea name="keluhan_utama" rows="3" class="w-full rounded-lg border-slate-300" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Riwayat Penyakit</label>
                <textarea name="riwayat_penyakit" rows="2" class="w-full rounded-lg border-slate-300"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-red-500 mb-1">Riwayat Alergi</label>
                <textarea name="riwayat_alergi" rows="2" class="w-full rounded-lg border-red-200 bg-red-50"></textarea>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-xs font-bold text-slate-500 mb-1">Riwayat Psikososial</label>
            <input type="text" name="riwayat_psikososial" class="w-full rounded-lg border-slate-300" placeholder="Stress kerja, merokok, dll">
        </div>
<div class="border-t pt-4 mt-4 mb-4">
    <label class="block text-sm font-bold text-blue-800 mb-1">Diagnosa Utama (A)</label>
    
    <select id="select-diagnosa" name="diagnosa_input" placeholder="Pilih atau Ketik Penyakit Baru..." autocomplete="off">
        <option value="">Cari Diagnosa...</option>
        @foreach($diagnoses as $d)
            <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->code }})</option>
        @endforeach
    </select>
    
    <p class="text-xs text-slate-500 mt-1">
        Ketik nama penyakit. Tekan <b>Enter</b> untuk memilih/menambah.
        <br><span class="text-red-500">* Penyakit baru akan tersimpan otomatis ke Master Data saat tombol "SIMPAN REKAM MEDIS" ditekan.</span>
    </p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var diagnosaSelect = new TomSelect("#select-diagnosa",{
            create: true, // Izinkan membuat item baru
            persist: false, // Jangan simpan item sementara jika dihapus
            createOnBlur: true, // Buat item jika user klik di luar kotak
            sortField: {
                field: "text",
                direction: "asc"
            },
            // PENTING: Callback saat user mengetik item baru
            onOptionAdd: function(value, data) {
                console.log('Item baru ditambahkan:', value);
            }
        });

        // TRIK PENTING: Mencegah Form Submit saat tekan Enter di TomSelect
        // Kita tangkap event keydown pada input TomSelect
        document.querySelector('.ts-control input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Batalkan submit form
                // TomSelect otomatis akan memilih item saat Enter dilepas
            }
        });
    });
</script>
        <div class="mt-4">
            <label class="block text-sm font-bold text-slate-700 mb-1">Tindakan / Terapi Non-Obat (P)</label>
            <textarea name="tindakan" rows="2" class="w-full rounded-lg border-slate-300" placeholder="Contoh: Jahit luka 3 simpul, Edukasi diet"></textarea>
        </div>
    </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200" 
                             x-data="{ 
                                rows: [], 
                                addRow() { this.rows.push({ id: '', qty: 1, instructions: '' }) },
                                removeRow(index) { this.rows.splice(index, 1) }
                             }">
                            
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-bold text-slate-800">4. Resep Obat</h3>
                                <button type="button" @click="addRow()" class="bg-green-600 text-white px-3 py-1 rounded text-sm font-bold hover:bg-green-700">
                                    + Tambah Obat
                                </button>
                            </div>

                            <div class="grid grid-cols-12 gap-2 text-xs font-bold text-slate-500 mb-2 uppercase">
                                <div class="col-span-5">Nama Obat</div>
                                <div class="col-span-2">Qty</div>
                                <div class="col-span-4">Aturan Pakai</div>
                                <div class="col-span-1">Hapus</div>
                            </div>

                            <template x-for="(row, index) in rows" :key="index">
                                <div class="grid grid-cols-12 gap-2 mb-2 items-center">
                                    <div class="col-span-5">
                                        <select :name="'medicines['+index+'][id]'" x-model="row.id" class="w-full text-sm rounded border-slate-300 p-2">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($medicines as $med)
                                                <option value="{{ $med->id }}">{{ $med->name }} (Stok: {{ $med->current_stock }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="number" :name="'medicines['+index+'][qty]'" x-model="row.qty" class="w-full text-sm rounded border-slate-300 p-2" min="1">
                                    </div>
                                    <div class="col-span-4">
                                        <input type="text" :name="'medicines['+index+'][instructions]'" x-model="row.instructions" class="w-full text-sm rounded border-slate-300 p-2" placeholder="3x1 ssdh makan">
                                    </div>
                                    <div class="col-span-1 text-center">
                                        <button type="button" @click="removeRow(index)" class="text-red-500 hover:text-red-700 font-bold">X</button>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="rows.length === 0" class="text-center py-4 text-slate-400 text-sm italic border-dashed border-2 border-slate-200 rounded-lg">
                                Belum ada obat yang ditambahkan. Klik tombol + diatas.
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-900 shadow-lg transition">
                                SIMPAN REKAM MEDIS
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>