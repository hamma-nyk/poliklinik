<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-800">{{ __('Edit Departemen') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-neutral-200">
                <form action="{{ route('master.departments.update', $department->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Kode Bagian</label>
                        <input type="text" name="code" value="{{ $department->code }}" class="w-full rounded-lg border-neutral-300 uppercase" required maxlength="10">
                    </div>
                    <div class="mb-6">
                        <label class="block font-bold mb-1">Nama Bagian</label>
                        <input type="text" name="name" value="{{ $department->name }}" class="w-full rounded-lg border-neutral-300" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('master.departments.index') }}" class="px-4 py-2 text-neutral-500">Batal</a>
                        <button type="submit" class="bg-neutral-900 text-white px-6 py-2 rounded-lg font-bold">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>