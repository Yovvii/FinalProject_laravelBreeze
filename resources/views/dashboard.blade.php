<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hi dden shadow-sm sm:rounded-lg p-12">

                {{-- @php
                    dd(session()->all());
                @endphp --}}

                @if (session('password_updated_success'))
                    @include('account.timeline')
                @elseif (session('first_login'))
                    @include('account.update_password')
                @else
                    {{ __("Anda berhasil login!") }}
                @endif

            </div>
        </div>
    </div>

</x-app-layout>
