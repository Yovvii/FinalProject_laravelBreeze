{{-- Pastikan Alpine.js sudah dimuat di layout utama Anda --}}
<div class="flex justify-between items-center border p-4 rounded-lg bg-white shadow-sm">
    {{-- KONTEN UTAMA --}}
    <div>
        <p class="font-semibold text-gray-800">{{ $title }}</p>
        <p class="text-sm text-gray-600">{{ $description }}</p>
    </div>

    {{-- KEBAB MENU (Dropdown) --}}
    <div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left">
        
        {{-- Tombol Titik Tiga --}}
        <div>
            <button type="button" @click="open = ! open" class="flex items-center text-gray-400 hover:text-gray-600 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-expanded="true" aria-haspopup="true">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
            </button>
        </div>

        {{-- Dropdown Panel --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="origin-bottom-right absolute right-0 bottom-full mb-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
             role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            
            {{-- OPSI LIHAT / EDIT --}}
            <div class="py-1" role="none">
                    @if ($isRegistered)
                    <span class="text-gray-400 block px-4 py-2 text-sm cursor-not-allowed bg-gray-50" title="Tidak dapat mereset karena sudah terdaftar di sekolah.">
                        <svg class="w-4 h-4 inline-block me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Tarik berkas terlebih dahulu
                    </span>
                @else
                    {{-- Opsi Lihat (selalu aktif dan mengarah ke form edit) --}}
                    <a href="{{ route($editRoute) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1">
                        <svg class="w-4 h-4 inline-block me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat / Edit Data
                    </a>
                @endif
            </div>

            {{-- OPSI RESET DATA --}}
            <div class="py-1" role="none">
                @if ($isRegistered)
                    {{-- Tombol Reset (Disabled) --}}
                    <span class="text-gray-400 block px-4 py-2 text-sm cursor-not-allowed bg-gray-50" title="Tidak dapat mereset karena sudah terdaftar di sekolah.">
                        <svg class="w-4 h-4 inline-block me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Tarik berkas terlebih dahulu
                    </span>
                @else
                    {{-- Tombol Reset (Aktif) --}}
                    <form method="POST" action="{{ route($resetRoute) }}" onsubmit="return confirm('PERINGATAN! Anda yakin ingin mereset data ini? Aksi ini akan menghapus semua input di bagian ini dan tidak dapat dibatalkan.');">
                        @csrf
                        <button type="submit" class="text-red-600 block w-full text-left px-4 py-2 text-sm hover:bg-red-50" role="menuitem" tabindex="-1">
                            <svg class="w-4 h-4 inline-block me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Reset Data
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>