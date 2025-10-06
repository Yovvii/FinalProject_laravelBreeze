<form method="POST" action="{{ route('register') }}">
    @csrf
    <!-- NISN -->
    <div class="mt-4">
        <x-input-label for="nisn" :value="__('NISN')" />
        <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn')" required/>
        <x-input-error :messages="$errors->get('nisn')" class="mt-2" />
    </div>

    <!-- Nama -->
    <div>
        <x-input-label for="name" :value="__('Nama')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    
    <!-- Tanggal Lahir -->
    <div class="mt-4">
        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required/>
        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <a href="#" @click.prevent="currentView = 'login'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-5...">
            Sudah punya akun?
        </a>

        <x-primary-button class="ms-4">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>