<x-app-layout>
    <div class="pt-5">
        <div class="max-w-7xl mx-auto sm:px-8 lg:px-10 flex">
            <a href="{{ route('pendaftaran_sma') }}" class="text-[20px] text-black font-extrabold">< Kembali</a>
            @if ($selectedSma)
            <p class="text-[20px] text-gray-500 ms-[5px]">|| Selamat Datang di Halaman Pendaftaran <span class="font-[1000] text-black">{{ $selectedSma->nama_sma }}</span></p>
            @else
            <p class="text-[20px] text-gray-500">Selamat Datang di Alur Masuk SPMB 2026/2027</p>
            @endif
        </div>
    </div>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">

                <form method="POST" action="{{ route('pendaftaran.sma.save_step') }}" enctype="multipart/form-data">
                    @csrf
                                    
                    <input type="hidden" name="current_step" value="{{ $currentStep }}">
                
                    @if ($currentStep == 1)
                        @include('account.timeline_form.biodata')
                    @elseif ($currentStep == 2)
                        @include('account.timeline_form.rapor')
                    @elseif ($currentStep == 3)
                        @if ($jalurId == 1)
                            @include('registration.sma_form.sertifikat')
                        @elseif ($jalurId == 2)
                            @include('registration.sma_form.dokumen_afirmasi')
                        @else
                            @include('registration.sma_form.zonasi')
                        @endif
                    @elseif ($currentStep == 4)
                        @include('registration.sma_form.resume_sma')
                    @endif
                    
                    <div class="mt-4">
                        @include('registration.sma_form.pagination_sma', ['currentStep' => $currentStep])
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-app-layout>