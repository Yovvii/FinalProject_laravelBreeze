@php
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\AplicationController;
    
    // Asumsi: Anda mengimpor model Siswa atau menggunakan relasi Auth::user()->siswa
    $siswa = Auth::user()->siswa ?? null; 
    
    // Tentukan rute tujuan secara kondisional
    $targetRoute = route('pendaftaran_sma'); // Default
    
    if ($siswa && $siswa->status_pendaftaran === 'completed') {
        // Jika pendaftaran selesai, arahkan ke peringkat
        $targetRoute = route('siswa.peringkat');
    }
    $unreadCount = AplicationController::unreadCount();
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

            <a href="{{ route('profile.settings') }}" class="mt-2 font-black text-center hover:underline">
                {{ Auth::user()->name }}
            </a>
            <span class="font-light text-sm tracking-wide">{{ Auth::user()->siswa->nisn }}</span>
        </div>

        <nav class="flex-1 mt-6 px-5">
            <ul class="space-y-4">
                <li>
                    @php
                        // 🚨 KUNCI: Tentukan rute berdasarkan status has_completed_steps
                        // Pastikan variabel $siswa tersedia dan objek Siswa sudah dimuat.
                        $targetRoute = (Auth::user()->siswa && Auth::user()->siswa->has_completed_steps) 
                                        ? route('setelah.dashboard.show') 
                                        : route('dashboard');
                        
                        // Cek apakah rute saat ini cocok dengan salah satu rute yang disorot
                        $isActive = request()->routeIs('dashboard') || request()->routeIs('setelah.dashboard.show');
                    @endphp

                    <a href="{{ $targetRoute }}" 
                    class="flex items-center px-3 py-2 rounded-lg {{ $isActive ? 'bg-blue-800' : 'bg-blue-700 hover:bg-blue-600' }}">
                        
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
                    <a href="{{ route('notification.index') }}" class="flex items-center p-2 text-base font-normal rounded-lg
                    {{ request()->routeIs('notification.index') ? 'bg-blue-800' : 'bg-blue-700 hover:bg-blue-600' }}">
                        {{-- Icon Notifikasi (Ganti dengan SVG jika ada) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6 ml-1">
                            <path fill-rule="evenodd" d="M12 5a4 4 0 0 0-8 0v2.379a1.5 1.5 0 0 1-.44 1.06L2.294 9.707a1 1 0 0 0-.293.707V11a1 1 0 0 0 1 1h2a3 3 0 1 0 6 0h2a1 1 0 0 0 1-1v-.586a1 1 0 0 0-.293-.707L12.44 8.44A1.5 1.5 0 0 1 12 7.38V5Zm-5.5 7a1.5 1.5 0 0 0 3 0h-3Z" clip-rule="evenodd" />
                        </svg>

                        <span class="ml-3">Notifikasi</span>
                        
                        {{-- BADGE JUMLAH BELUM DIBACA --}}
                        @if ($unreadCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 ml-auto text-xs font-medium text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-300">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                </li>
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