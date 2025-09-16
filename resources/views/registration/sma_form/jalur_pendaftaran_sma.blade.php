<x-app-layout>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form id="registration-form" action="{{ route('pendaftaran.sma.saveJalur') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jalur_pendaftaran_id" id="jalur-pendaftaran-id">
                    
                    <div class="border border-gray-400 p-6 rounded-lg flex gap-5 items-start">
                        <div class="w-full h-[280px] flex-col">
                            @if ($jalur_pendaftaran->isEmpty())
                                <div class="text-center text-gray-500">
                                    Belum ada jalur pendaftaran yang tersedia saat ini.
                                </div>
                            @else
                                <!-- Menggunakan tombol radio untuk setiap item -->
                                <ul class="space-y-4">
                                    @foreach ($jalur_pendaftaran as $jalur)
                                        <li class="group relative flex justify-start items-center rounded-2xl w-full h-[80px] border-[2px] border-blue-500 mb-3 
                                        hover:bg-blue-200 transition-all duration-200 hover:border-none hover:shadow-lg hover:h-[85px] hover:w-[101%]
                                        has-[:checked]:bg-blue-200 has-[:checked]:border-none has-[:checked]:shadow-lg has-[:checked]:h-[85px] has-[:checked]:w-[101%]" data-id="{{ $jalur->id }}" data-nama="{{ $jalur->nama_jalur_pendaftaran }}" data-deskripsi="{{ $jalur->deskripsi }}">
                                            <input type="radio" id="jalur-{{ $jalur->id }}" name="jalur_pendaftaran_id_radio" value="{{ $jalur->id }}" class="absolute opacity-0">
                                            <label for="jalur-{{ $jalur->id }}" class="p-4 flex items-center">
                                                <div class="transition-all duration-200 rounded-full bg-blue-600 flex justify-center items-center h-[45px] w-[45px] group-hover:bg-white group-has-[:checked]:bg-white">
                                                    {!! $jalur->logo_active !!}
                                                </div>
                                                <div class="ml-4">
                                                    <span class="text-lg text-gray-900 font-semibold block group-hover:text-blue-600 group-has-[:checked]:text-blue-600">{{ $jalur->nama_jalur_pendaftaran }}</span>
                                                    <span class="text-sm text-gray-600 block group-hover:text-blue-600 group-has-[:checked]:text-blue-600">{{ Str::words($jalur->deskripsi, 10) }}</span>
                                                </div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <!-- Panel Deskripsi -->
                        <div id="description-panel" class="p-4 rounded-2xl w-full bg-blue-200 flex flex-col items-center px-4">
                            <div id="panel-logo-container" class="rounded-full bg-blue-600 flex justify-center items-center h-[55px] w-[55px]">
                                {!! $jalur->logo !!}
                            </div>
                            <h3 id="panel-title" class="text-center mt-3 text-[18px] text-gray-900 font-semibold">{{ $jalur->nama_jalur_pendaftaran }}</h3>
                            <p id="panel-description" class="text-center text-sm text-gray-600">{{ $jalur->deskripsi }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center flex justify-center gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200">
                            Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const panelTitle = document.getElementById('panel-title');
            const panelDescription = document.getElementById('panel-description');
            const hiddenInputId = document.getElementById('jalur-pendaftaran-id');
            const radioInputs = document.querySelectorAll('input[name="jalur_pendaftaran_id_radio"]');
            // const panelLogoContainer = document.getElementById('panel-logo-container');
            
            function updatePanel(element) {
                if (element && element.dataset.nama) {
                    panelTitle.textContent = element.dataset.nama;
                    panelDescription.textContent = element.dataset.deskripsi;
                    hiddenInputId.value = element.dataset.id;
                    // panelLogoContainer.innerHTML = element.dataset.logo;
                }
            }
            
            const firstRadio = radioInputs[0];
            if (firstRadio) {
                firstRadio.checked = true;
                const firstLi = firstRadio.closest('li[data-id]');
                updatePanel(firstLi);
            }

            radioInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    const selectedLi = this.closest('li[data-id]');
                    if (selectedLi) {
                        updatePanel(selectedLi);
                    }
                });
            });
        });
    </script>
</x-app-layout>
