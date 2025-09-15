 <x-app-layout>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="border border-gray-400 p-6 rounded-lg flex gap-5 items-start">
                    <div class="w-full flex-col">
                        @for ($i = 1; $i <=2; $i++)
                            <div class="px-4 rounded-2xl w-full flex items-center border-[2px] border-blue-500 mb-3">
                                <div class="rounded-full bg-blue-600 flex justify-center items-center h-[45px] w-[45px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6">
                                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                                    </svg>
                                </div>
                                <p class="m-3 text-[14px]">
                                    <span class="text-[18px] text-gray-900 font-semibold">Prestasi</span> <br>
                                    {{ Str::words('Jalur ini dikhususkan bagi calon siswa yang memiliki prestasi akademik maupun non-akademik di tingkat nasional, provinsi, atau kabupaten/kota. Prestasi non-akademik bisa berupa juara lomba olahraga, seni, atau sains.', 10) }}
                                </p>
                            </div>
                        @endfor
                    </div>

                    <div class="p-4 rounded-2xl w-full bg-blue-200 flex flex-col items-center px-4">
                        <div class="rounded-full bg-blue-600 flex justify-center items-center h-[55px] w-[55px]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-8">
                                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>
                        </div>
                        <p class="text-center mt-3"><span class="text-[18px] text-gray-900 font-semibold">Jalur Prestasi</span><br>
                            Jalur ini dikhususkan bagi calon siswa yang memiliki prestasi akademik maupun non-akademik di tingkat nasional, provinsi, atau kabupaten/kota. Prestasi non-akademik bisa berupa juara lomba olahraga, seni, atau sains.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>