<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pendaftaran SMA') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="border border-gray-400 p-6 rounded-lg space-y-[30px]">
                    @for ($sekolahsma = 1; $sekolahsma <= 6; $sekolahsma++)
                        <div class="flex justify-between py-3 px-4 border-b-2 border-gray-100">
                            <div class="flex my-auto">
                                <div class="w-[50px] h-[50px] me-3 my-auto">
                                    <img class="w-full my-auto" src="{{ asset('assets/profile_sekolah_jpg/SMAN1Kejobong.png') }}" alt="">
                                </div>
                                <p class="text-[16px]/[18px] font-bold my-auto">SMAN 1 Kejobong<br>
                                <span class="bg-green-600 rounded-full px-4 py-[1px] text-white text-[10px] font-thin">Akreditasi A</span></p>
                            </div>
                            <div class="flex my-auto">
                                <p class="me-5 text-[16px] my-auto"><span class="font-bold">8.209</span> Pendaftar</p>
                                <form action="">
                                    <button class="bg-blue-600 rounded-lg px-[15px] py-[1px] text-white font-bold">DAFTAR</button>
                                </form>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

</x-app-layout>