@php
    use Illuminate\Support\Facades\Auth;
    
    // Asumsi: Anda mengimpor model Siswa atau menggunakan relasi Auth::user()->siswa
    $siswa = Auth::user()->siswa ?? null; 
    
    // Tentukan rute tujuan secara kondisional
    $targetRoute = route('pendaftaran_sma'); // Default
    
    if ($siswa && $siswa->status_pendaftaran === 'completed') {
        // Jika pendaftaran selesai, arahkan ke peringkat
        $targetRoute = route('siswa.peringkat');
    }
@endphp
<div class="hidden lg:flex min-h-screen">
    <aside class="w-64 bg-blue-700 text-white flex flex-col fixed h-screen">
        <div class="p-6 flex items-center justify-center">
            <x-application-logo class="h-8 w-auto fill-current text-white" />
        </div>

        <div class="w-full grid place-items-center">
            <div class="relative w-20">
                <img src="{{ $siswa && $siswa->foto ? asset('storage/' . $siswa->foto) : asset('storage/profile_murid/avatar_empty.jpg') }}" alt=""
                class="rounded-full">
            </div>

            <span class="mt-2 font-black">{{ Auth::user()->name }}</span>
            <span class="font-light text-sm tracking-wide">{{ Auth::user()->siswa->nisn }}</span>
        </div>

        <nav class="flex-1 mt-6 px-5">
            <ul class="space-y-4">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('dashboard') || request()->routeIs('setelah.dashboard.show') ? 'bg-blue-800' : 'bg-blue-700 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M11.5 1L2 6v2h19V6m-5 4v7h3v-7M2 22h19v-3H2m8-9v7h3v-7m-9 0v7h3v-7z"/>
                        </svg>
                        <span class="ml-3">Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="{{ $targetRoute }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('pendaftaran_sma') || request()->routeIs('pendaftaran.sma.timeline') || request()->routeIs('jalur_pendaftaran') || request()->routeIs('siswa.peringkat') ? 'bg-blue-800' : 'bg-blue-700 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M13 19c0 1.1.3 2.12.81 3H6c-1.11 0-2-.89-2-2V4a2 2 0 0 1 2-2h1v7l2.5-1.5L12 9V2h6a2 2 0 0 1 2 2v9.09c-.33-.05-.66-.09-1-.09c-3.31 0-6 2.69-6 6m10 0l-3-3v2h-4v2h4v2z"/>
                        </svg>
                        <span class="ml-3">Pendaftaran SMA</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('notification.index') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('notification.index') ? 'bg-blue-800' : 'bg-blue-700 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12 5a4 4 0 0 0-8 0v2.379a1.5 1.5 0 0 1-.44 1.06L2.294 9.707a1 1 0 0 0-.293.707V11a1 1 0 0 0 1 1h2a3 3 0 1 0 6 0h2a1 1 0 0 0 1-1v-.586a1 1 0 0 0-.293-.707L12.44 8.44A1.5 1.5 0 0 1 12 7.38V5Zm-5.5 7a1.5 1.5 0 0 0 3 0h-3Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Notification</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('test_field') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('test_field') || request()->routeIs('test_field') ? 'bg-blue-800' : 'bg-blue-700 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Test Field</span>
                    </a>
                </li> --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-blue-600 bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-3">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="flex-1 overflow-y-auto">
        </div>
</div>