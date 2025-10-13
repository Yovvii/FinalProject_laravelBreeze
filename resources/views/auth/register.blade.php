<p class="text-black text-center font-noto_serif text-[46px]/[34px]">Selamat Datang <br>
    <span class="inline-block text-[14px] font-poppins tracking-wide text-gray-600">Silahkan masukkan nisn, nama dan tanggal lahir</span>
</p>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <!-- NISN -->
    <div class="mt-4">
        <label for="nisn" class="block text-sm font-medium text-gray-700">
            NISN
        </label>
        <input id="nisn" name="nisn" type="text"
            value="{{ old('nisn') }}"
            required
            class="mt-1 block w-full rounded-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-blue-50 text-black"/>
        @error('nisn')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Nama -->
    <div class="mt-4">
        <label for="name" class="block text-sm font-medium text-gray-700">
            Nama
        </label>
        <input id="name" name="name" type="text"
            value="{{ old('name') }}"
            required
            autofocus
            autocomplete="name"
            class="mt-1 block w-full rounded-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-blue-50 text-black"/>
        @error('name')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tanggal Lahir -->
    <div class="mt-4">
        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">
            Tanggal Lahir
        </label>
        <input id="tanggal_lahir" name="tanggal_lahir" type="date"
            value="{{ old('tanggal_lahir') }}"
            required
            class="mt-1 block w-full rounded-full shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-blue-50 text-black" />
        @error('tanggal_lahir')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <p class="text-gray-400 text-sm mt-2 dark:text-gray-500">
        Pastikan input sesuai dengan data yang anda miliki
    </p>

    <button type="submit"
        class="w-full items-center bg-gray-900 px-4 py-2 rounded-xl text-white font-poppins mt-[8%]">
        Register
    </button>

    <p class="text-black text-[14px] text-center mt-[5%]">Sudah Punya Akun?
        <a href="#" @click.prevent="currentView = 'login'" 
        class="font-extrabold">
            Log in
        </a>
    </p>

</form>