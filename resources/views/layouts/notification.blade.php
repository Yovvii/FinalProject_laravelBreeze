{{-- Notification --}}
@if (session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)"
        class="fixed top-0 left-0 right-0 z-50 flex justify-center p-4">
    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md max-w-lg w-full p-4 flex items-center justify-between">
        <p class="text-green-600 font-bold">{{ session('success') }}</p>
        <button @click="show = false" class="text-gray-400 hover:text-gray-600">&times;</button>
    </div>
</div>
@endif