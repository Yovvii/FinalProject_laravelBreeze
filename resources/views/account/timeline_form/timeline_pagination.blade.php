<nav class="flex justify-center mt-10 mb-5 space-x-4">
    {{-- Tombol "Sebelumnya" --}}
    <button 
        type="button" 
        class="px-4 py-2 text-black bg-white border border-gray-800 rounded-2xl hover:bg-gray-900 hover:text-white hover:border-gray-500
        disabled:bg-gray-100 disabled:border-gray-400 disabled:text-gray-500"
        @if ($currentStep <= 1) disabled @endif
        onclick="window.location.href='{{ route('dashboard', ['step' => $currentStep - 1]) }}'"
    >
        < Sebelumnya
    </button>

    {{-- Tombol "Selanjutnya" --}}
    <button 
        type="submit" 
        class="px-4 py-2 text-black bg-white border border-gray-800 rounded-2xl hover:bg-gray-900 hover:text-white hover:border-gray-500
        disabled:bg-gray-100 disabled:border-gray-400 disabled:text-gray-500"
        @if ($currentStep == 4) hidden @endif
    >
        Selanjutnya >
    </button>

    @if ($currentStep == 4)
    <button 
        type="submit" 
        class="px-4 py-2 text-white bg-green-800 border border-green-800 rounded-2xl hover:bg-green-200 hover:text-green-700 hover:border-gray-500
        disabled:bg-gray-100 disabled:border-gray-400 disabled:text-gray-500">
        Submit
    </button>
    @endif
</nav>