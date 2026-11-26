@php
    $selectedSet = collect(old('diagnosis_ids', $selectedIds ?? []))->map(fn($id) => (int) $id)->all();
@endphp

<div class="space-y-6"
     x-data="{
        search: '',
        selected: {{ Js::from($selectedSet) }},
        toggle(id) {
            id = Number(id);
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(i => i !== id);
            } else {
                this.selected.push(id);
            }
        },
        selectVisible() {
            document.querySelectorAll('[data-diag-row]').forEach(el => {
                if (el.style.display !== 'none') {
                    const id = Number(el.dataset.diagId);
                    if (!this.selected.includes(id)) this.selected.push(id);
                }
            });
        },
        clearAll() {
            this.selected = [];
        }
     }">

    @if ($errors->any())
        <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-950/60 dark:text-red-200">
            <ul class="list-disc ml-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-1.5">
            <label class="text-sm font-medium leading-none">Nama Tipe / Bagian MCU <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $mcuType->name ?? '') }}" required
                   placeholder="Contoh: Paru & Pernapasan (Pulmonologi)"
                   class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300">
        </div>

        <div class="space-y-1.5">
            <label class="text-sm font-medium leading-none">Pemeriksaan yang Dianjurkan</label>
            <input type="text" name="recommended_exams" value="{{ old('recommended_exams', $mcuType->recommended_exams ?? '') }}"
                   placeholder="Contoh: Rontgen Thorax, Spirometri, Tes Sputum"
                   class="flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300">
        </div>
    </div>

    <div class="space-y-1.5">
        <label class="text-sm font-medium leading-none">Catatan / Keterangan (Opsional)</label>
        <textarea name="description" rows="2" placeholder="Catatan tambahan mengenai tipe MCU ini..."
                  class="flex w-full rounded-md border border-neutral-200 bg-transparent px-3 py-2 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300">{{ old('description', $mcuType->description ?? '') }}</textarea>
    </div>

    {{-- Mapping Diagnosa --}}
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-600 bg-neutral-50/50 dark:bg-neutral-900/40 p-4 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h4 class="text-sm font-semibold">Mapping Diagnosa Penyakit</h4>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">Pilih diagnosa dari daftar master diagnosa yang akan memicu saran MCU ini.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50">
                <span x-text="selected.length"></span>&nbsp;Diagnosa Dipilih
            </span>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center justify-between">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" x-model="search" placeholder="Filter diagnosa (kode / nama)..."
                       class="flex h-9 w-full rounded-md border border-neutral-200 bg-white dark:bg-neutral-800 px-3 py-1 pl-9 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-neutral-950 dark:border-neutral-600 dark:focus-visible:ring-neutral-300">
            </div>

            <div class="flex gap-2">
                <button type="button" @click="selectVisible()"
                        class="inline-flex items-center justify-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 h-9 text-xs font-medium hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                    Pilih Semua Tampil
                </button>
                <button type="button" @click="clearAll()"
                        class="inline-flex items-center justify-center rounded-md border border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-3 h-9 text-xs font-medium hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                    Kosongkan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-96 overflow-y-auto pr-1">
            @foreach($diagnoses as $diag)
                @php
                    $searchText = mb_strtolower(($diag->code ?? '') . ' ' . $diag->name);
                @endphp
                <label data-diag-row data-diag-id="{{ $diag->id }}"
                       x-show="search === '' || {{ Js::from($searchText) }}.includes(search.toLowerCase())"
                       :class="selected.includes({{ $diag->id }}) ? 'border-neutral-900 bg-neutral-100 dark:border-neutral-300 dark:bg-neutral-700/70' : 'border-neutral-200 bg-white dark:border-neutral-600 dark:bg-neutral-800'"
                       class="flex items-start gap-2.5 p-2.5 rounded-lg border cursor-pointer transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-700/50">
                    <input type="checkbox" name="diagnosis_ids[]" value="{{ $diag->id }}"
                           :checked="selected.includes({{ $diag->id }})"
                           @change="toggle({{ $diag->id }})"
                           class="mt-0.5 rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-800">
                    <div class="min-w-0">
                        <div class="text-xs font-medium text-neutral-900 dark:text-neutral-100 leading-snug">{{ $diag->name }}</div>
                        <div class="text-[10px] font-mono text-neutral-500 dark:text-neutral-400">{{ $diag->code ?? '-' }}</div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-end gap-2 pt-2 border-t border-neutral-200 dark:border-neutral-600">
        <a href="{{ route('master.mcu-types.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-neutral-200 bg-white shadow-sm hover:bg-neutral-100 h-9 px-4 dark:border-neutral-600 dark:bg-neutral-800 dark:hover:bg-neutral-700">Batal</a>
        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-5 dark:bg-neutral-50 dark:text-neutral-900 dark:hover:bg-neutral-50/90">
            Simpan Mapping MCU
        </button>
    </div>
</div>
