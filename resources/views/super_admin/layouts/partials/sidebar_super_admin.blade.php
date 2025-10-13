<div class="hidden lg:flex min-h-screen">
    <aside class="w-64 bg-blue-900 text-white flex flex-col fixed h-screen">
        <div class="p-6 flex items-center justify-center">
            <x-application-logo class="h-8 w-auto fill-current text-white" />
        </div>

        <div class="w-full grid place-items-center">
            <div class="relative w-20">
                {{-- <img src="{{ $siswa && $siswa->foto ? asset('storage/' . $siswa->foto) : asset('storage/profile_murid/avatar_empty.jpg') }}" alt=""
                class="rounded-full"> --}}
            </div>

            <span class="mt-2 font-black">{{ Auth::user()->name }}</span>
            {{-- <span class="font-light text-sm tracking-wide">{{ Auth::user()->siswa->nisn }}</span> --}}
        </div>

        <nav class="flex-1 mt-6 px-5">
            <ul class="space-y-4">
                <li>
                    <a href="{{ route('super_admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('super_admin.dashboard') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super_admin.data_sma') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('super_admin.data_sma') || request()->routeIs('super_admin.sma.create') || request()->routeIs('super_admin.sma.edit') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.605 2.112a.75.75 0 0 1 .79 0l5.25 3.25A.75.75 0 0 1 13 6.707V12.5h.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H3V6.707a.75.75 0 0 1-.645-1.345l5.25-3.25ZM4.5 8.75a.75.75 0 0 1 1.5 0v3a.75.75 0 0 1-1.5 0v-3ZM8 8a.75.75 0 0 0-.75.75v3a.75.75 0 0 0 1.5 0v-3A.75.75 0 0 0 8 8Zm2 .75a.75.75 0 0 1 1.5 0v3a.75.75 0 0 1-1.5 0v-3ZM8 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Data Sekolah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super_admin.data_admin_sekolah') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('super_admin.data_admin_sekolah') || request()->routeIs('test_field') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Admin Sekolah</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super_admin.data_diterima') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('super_admin.data_diterima') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M8 1.75a.75.75 0 0 1 .692.462l1.41 3.393 3.664.293a.75.75 0 0 1 .428 1.317l-2.791 2.39.853 3.575a.75.75 0 0 1-1.12.814L7.998 12.08l-3.135 1.915a.75.75 0 0 1-1.12-.814l.852-3.574-2.79-2.39a.75.75 0 0 1 .427-1.318l3.663-.293 1.41-3.393A.75.75 0 0 1 8 1.75Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Data Murid Diterima</span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-blue-600 bg-blue-900">
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