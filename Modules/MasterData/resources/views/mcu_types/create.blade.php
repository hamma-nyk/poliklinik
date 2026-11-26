<x-app-layout title="Tambah Tipe MCU">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight leading-tight">{{ __('Tambah Tipe MCU') }}</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Buat tipe MCU baru dan pilih diagnosa penyakit yang terkait</p>
            </div>
            <div class="hidden md:flex items-center text-sm text-neutral-500 dark:text-neutral-400">
                <a href="{{ route('master.mcu-types.index') }}" class="hover:text-neutral-900 dark:hover:text-neutral-50 transition-colors">Data MCU</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-semibold text-neutral-900 dark:text-neutral-50">Tambah</span>
            </div>
        </div>
    </x-slot>

    <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
        <form action="{{ route('master.mcu-types.store') }}" method="POST">
            @csrf
            @include('masterdata::mcu_types._form')
        </form>
    </div>
</x-app-layout>
