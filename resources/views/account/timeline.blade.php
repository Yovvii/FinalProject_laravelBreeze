
<div class="max-w-7xl mx-auto sm:px-4 lg:px-6 pt-5">
    <div class="bg-white p-4 rounded-lg">
        <div class="p-3 bg-blue-100 rounded-lg ">
            Selamat datang <span class="font-semibold">{{ Auth::user()->name }}</span>
            <p class="mt-2 text-sm/6"><span class="font-bold">Perhatian! Hindari Penipuan!</span>
                Harap berhati-hati terhadap pihak yang meminta uang dengan mengatasnamakan panitia. Pastikan Anda hanya mengakses informasi dari situs web resmi ini.
                <span class="font-bold">Pelaksanaan SPMB 2026/2027 GRATIS & bebas dari segala macam bentuk percaloan !!!</span>
            </p>
            <hr class="my-4 border-gray-400"> <p class="text-xs text-gray-500">
                Panitia SPMB Kabupaten Purbalingga
            </p>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">

            {{-- Timeline Pendaftaran --}}
            @if ($currentStep == 1)
                @include('account.timeline_form.biodata')
            @elseif ($currentStep == 2)
                @include('account.timeline_form.rapor')
            @elseif ($currentStep == 3)
                @include('account.timeline_form.surat_pernyataan')                
            @elseif ($currentStep == 4)
                @include('account.timeline_form.surat_keterangan_lulus')
            @endif

            <div class="mt-4">
                @include('account.timeline_form.timeline_pagination', ['currentStep' => $currentStep])
            </div>

        </div>
    </div>
</div>