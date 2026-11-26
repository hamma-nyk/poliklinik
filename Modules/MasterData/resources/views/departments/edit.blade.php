<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold tracking-tight leading-tight">{{ __('Edit Departemen') }}</h2>
    </x-slot>

    <div class="space-y-6">
        <div class="w-full">
            <div class="rounded-xl border border-neutral-200 bg-white text-neutral-950 shadow dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-50 p-6">
                <form action="{{ route('master.departments.update', $department->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Kode Bagian</label>
                        <input type="text" name="code" value="{{ $department->code }}" class="w-full flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm dark:border-neutral-600 uppercase" required maxlength="10">
                    </div>
                    <div class="mb-6">
                        <label class="block font-bold mb-1">Nama Bagian</label>
                        <input type="text" name="name" value="{{ $department->name }}" class="w-full flex h-9 w-full rounded-md border border-neutral-200 bg-transparent px-3 py-1 text-sm shadow-sm dark:border-neutral-600" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('master.departments.index') }}" class="px-4 py-2 text-neutral-500">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-neutral-900 text-neutral-50 shadow hover:bg-neutral-900/90 h-9 px-4 py-2 dark:bg-neutral-50 dark:text-neutral-900">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>