<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\TimelineProgress;
use Illuminate\Validation\Rules;
use App\Traits\LogsStudentActions;
use App\Models\NotificationHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    use LogsStudentActions;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'unique:'.Siswa::class],
            // 'password' => ['required', Rules\Password::defaults()],
            'tanggal_lahir' => ['required', 'date'],
        ]);

        $tanggal_lahir = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir)->format('dmY');

        // Buat akun user
        $user = User::create([
            'name' => $request->name,
            'email' => null,
            'password' => Hash::make($tanggal_lahir),
            'role' => 'siswa',
        ]);

        TimelineProgress::create([
            'user_id' => $user->id,
            'current_step' => 1,
        ]);

        //Buat data siswa
        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        NotificationHistory::create([
            'user_id' => $user->id,
            'type' => 'success',
            'message' => 'Selamat! Akun Anda berhasil dibuat. Silahkan lanjutkan ke proses Login.',
            'is_read' => false,
        ]);

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('landing_page'))->with('success', 'Pendaftaran berhasil! Silahkan login kembali.');
        return $this->logAndRedirect('landing_page', 'success', 'Pendaftaran berhasil! Silahkan login kembali.');
    }
}
