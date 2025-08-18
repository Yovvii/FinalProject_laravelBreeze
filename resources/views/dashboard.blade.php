<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (!$isPasswordChanged)
        @include('account.update_password')
    @else
        @include('account.timeline')
    @endif

</x-app-layout>