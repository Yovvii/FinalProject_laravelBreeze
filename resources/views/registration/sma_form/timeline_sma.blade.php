<x-app-layout>
    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-10">
            @if ($selectedSma)
            <p class="text-[20px] text-gray-500">Selamat Datang di <span class="font-[1000] text-black">{{ $selectedSma->nama_sma }}</span></p>
            @else
            <p class="text-[20px] text-gray-500">Selamat Datang di Alur Masuk SPMB 2026/2027</p>
            @endif
        </div>
    </div>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="border border-gray-400 p-6 rounded-lg space-y-[30px]">

                    <form method="POST" action="{{ route('pendaftaran_sma.submit') }}" enctype="multipart/form-data">
                        <div>
                            <p>Hello World!</p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>