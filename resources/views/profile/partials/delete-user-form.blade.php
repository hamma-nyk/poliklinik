<section class="space-y-6">
    <header class="flex items-start gap-4 border-b border-red-100 dark:border-red-900/30 pb-4 mb-6">
        <div class="p-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-red-700 dark:text-red-400">
                {{ __('Hapus Akun') }}
            </h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ __("Setelah akun dihapus, semua data dan sumber daya akan dihapus secara permanen.") }}
            </p>
        </div>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="rounded-xl bg-red-600 hover:bg-red-700 px-5 py-2.5">
        {{ __('Hapus Akun Saya') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 dark:bg-slate-800">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ __("Setelah akun dihapus, semua data akan hilang permanen. Masukkan password Anda untuk konfirmasi.") }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" 
                    class="mt-1 block w-3/4 rounded-xl border-red-300 dark:border-red-700 bg-white dark:bg-slate-900 text-red-900 dark:text-red-300 placeholder-red-300 dark:placeholder-red-700 focus:border-red-500 focus:ring-red-500" 
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl mr-3 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl ml-3 bg-red-600 hover:bg-red-700">
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>