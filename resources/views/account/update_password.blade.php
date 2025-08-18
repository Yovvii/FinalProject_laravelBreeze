<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hi dden shadow-sm sm:rounded-lg p-12">
            <form method="POST" action="{{  route('password.update') }}">
                @csrf
                @method('PATCH')
                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="bg-orange-100 p-4 rounded-md">
                            <h2 class="text-base/7 font-semibold text-gray-900">Ganti Password</h2>
                            <p class="mt-1 text-sm/6 text-gray-600">Ubah Password Demi Keamanan Anda.</p>
                        </div>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                        <label for="current_password" class="block text-sm/6 font-medium text-gray-900">Password Lama</label>
                        <div class="mt-2">
                            <input id="current_password" type="text" name="current_password" value="{{ $tanggal_lahir_formatted }}"
                            class="block w-full rounded-md px-3 py-1.5 text-base text-gray-500 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6 bg-gray-200"/>
                            @error('current_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>

                        <div class="sm:col-span-2">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password Baru</label>
                        <div class="mt-2">
                            <input id="password" type="password" name="password" autocomplete="family-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>

                        <div class="sm:col-span-2">
                        <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Konfirmasi Password Baru</label>
                        <div class="mt-2">
                            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="family-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="mt-8 flex items-center justify-center gap-x-6">
                    {{-- <button type="button" class="text-sm/6 font-semibold text-gray-900">Batalkan</button> --}}
                    <button type="submit" 
                    class="rounded-md bg-indigo-600 px-10 py-3 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>