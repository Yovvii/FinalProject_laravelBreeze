<x-app-layout>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form id="registration-form" action="" method="POST">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6 group-hover:fill-blue-600 group-has-[:checked]:fill-blue-600">
                                                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <span class="text-lg text-gray-900 font-semibold block group-hover:text-blue-600">{{ $jalur->nama_jalur_pendaftaran }}</span>
                                                    <span class="text-sm text-gray-600 block group-hover:text-blue-600">{{ Str::words($jalur->deskripsi, 10) }}</span>
                                                </div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <!-- Panel Deskripsi -->
                        <div id="description-panel" class="p-4 rounded-2xl w-full bg-blue-200 flex flex-col items-center px-4">
                            <div class="rounded-full bg-blue-600 flex justify-center items-center h-[55px] w-[55px]">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-8">
                                    <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                                </svg>
                            </div>
                            <h3 id="panel-title" class="text-center mt-3 text-[18px] text-gray-900 font-semibold">{{ $jalur->nama_jalur_pendaftaran }}</h3>
                            <p id="panel-description" class="text-center text-sm text-gray-600">{{ $jalur->deskripsi }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center flex justify-center gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200">
                            Kembali
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors duration-200">
                            Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk menangani logika -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const panelTitle = document.getElementById('panel-title');
            const panelDescription = document.getElementById('panel-description');
            const hiddenInputId = document.getElementById('jalur-pendaftaran-id');
            const radioInputs = document.querySelectorAll('input[name="jalur_pendaftaran_id_radio"]');
            
            function updatePanel(element) {
                if (element && element.dataset.nama) {
                    panelTitle.textContent = element.dataset.nama;
                    panelDescription.textContent = element.dataset.deskripsi;
                    hiddenInputId.value = element.dataset.id;
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
