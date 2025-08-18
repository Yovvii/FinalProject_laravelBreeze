
<div class="max-w-7xl mx-auto sm:px-4 lg:px-6 pt-5">
    <div class="bg-white p-4 rounded-lg">
        <div class="p-3 bg-blue-100 rounded-lg ">
            Selamat datang <span class="font-semibold">{{ Auth::user()->name }}</span>
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
                @include('account.timeline_form.surat_keterangan_lulus')
            @elseif ($currentStep == 4)
                @include('account.timeline_form.surat_pernyataan')                
            @endif

            <div class="mt-4">
                @include('account.timeline_form.timeline_pagination', ['currentStep' => $currentStep])
            </div>

        </div>
    </div>
</div>