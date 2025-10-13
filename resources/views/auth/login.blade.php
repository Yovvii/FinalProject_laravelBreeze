<p class="text-black text-center font-noto_serif text-[46px]/[34px]">Selamat Datang <br>
    <span class="inline-block text-[14px] font-poppins tracking-wide text-gray-600">Silahkan masukkan nisn dan password untuk masuk</span>
</p>
<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- NISN -->
    <div class="mt-4">
        <label for="nisn" class="block text-sm font-medium text-gray-700">
            NISN
        </label>
        <input id="nisn" type="text" name="nisn" value="{{ old('nisn') }}" class="mt-1 block w-full rounded-full shadow-sm focus:border-indigo-500 font-poppins
                focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 bg-blue-50 text-black"
            required/>

        @error('nisn')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mt-5">
        <label for="password" class="block text-sm font-medium text-gray-700">
            Password
        </label>
        <input id="password" type="password" name="password" autocomplete="current-password" class="mt-1 block w-full rounded-full shadow-sm focus:border-indigo-500 font-poppins
                focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 bg-blue-50 text-black"
            required/>

        @error('password')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

    </div>
    <p class="text-gray-400 text-sm mt-2 dark:text-gray-500">
        Tanggal Lahir sebagai password default (DDMMYYYY)
    </p>


    <!-- Remember Me -->
    <div class="mt-4 flex items-center justify-between">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded-full dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
        </label>

        @if (Route::has('password.request'))
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('Lupa Password?') }}
            </a>
        @endif
    </div>
    
    <button class="mt-5 w-full bg-gray-900 py-2 rounded-xl font-poppins">
        Log in
    </button>
    
    <p class="text-black text-[14px] text-center mt-[5%]">Belum punya akun?
        <a href="#" @click.prevent="currentView = 'register'" class="font-extrabold">
            Registrasi
        </a>
    </p>
</form>
