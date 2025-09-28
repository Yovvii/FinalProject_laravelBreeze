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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                        </svg>
                        <span class="ml-3">Daftar Calon Murid</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jalur_pendaftaran.index') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('admin.jalur_pendaftaran.index') || request()->routeIs('admin.jalur_pendaftaran.show') || request()->routeIs('admin.sertifikat_murid') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                            <path d="M2.87 2.298a.75.75 0 0 0-.812 1.021L3.39 6.624a1 1 0 0 0 .928.626H8.25a.75.75 0 0 1 0 1.5H4.318a1 1 0 0 0-.927.626l-1.333 3.305a.75.75 0 0 0 .811 1.022 24.89 24.89 0 0 0 11.668-5.115.75.75 0 0 0 0-1.175A24.89 24.89 0 0 0 2.869 2.298Z" />
                        </svg>
                        <span class="ml-3">Siswa Per Jalur</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('test_field') }}" class="flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('test_field') || request()->routeIs('test_field') ? 'bg-blue-500' : 'bg-blue-900 hover:bg-blue-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-3">Test Field</span>
                    </a>
                </li> --}}
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