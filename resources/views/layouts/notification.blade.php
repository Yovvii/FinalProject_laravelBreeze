{{-- Notification --}}
@if (session('success') || session('error'))
<div x-data="{ 
        show: true, 
        message: '{{ session('success') ?? session('error') }}',
        type: '{{ session('success') ? 'success' : 'error' }}' 
    }" 
    x-show="show" 
    x-init="setTimeout(() => show = false, 5000)" {{-- Notifikasi akan hilang setelah 5 detik --}}
    class="fixed top-0 left-0 right-0 z-50 flex justify-center p-4">

    <div :class="{ 
            'bg-green-100 border-green-400 text-green-700': type === 'success', 
            'bg-red-100 border-red-400 text-red-700': type === 'error' 
        }" 
        class="border rounded-lg shadow-md max-w-lg w-full p-4 flex items-center justify-between">
        
        <p class="font-bold" x-text="message"></p>
        
        <button @click="show = false" class="text-gray-400 hover:text-gray-600 ml-4">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
@endif