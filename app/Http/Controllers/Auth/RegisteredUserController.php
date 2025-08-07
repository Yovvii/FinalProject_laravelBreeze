<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
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
            'nisn' => ['required', 'numeric', 'unique:'.User::class],
            'tanggal_lahir' => ['required', 'date'],
        ]);

        $tanggal_lahir = Carbon::createFromFormat('Y-m-d', $request->tanggal_lahir)->format('dmY');

        $user = User::create([
            'name' => $request->name,
            'nisn' => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => Hash::make($tanggal_lahir),
        ]);

        event(new Registered($user));

        return redirect(route('login'))->with('status', 'registrasi-berhasil');
    }
}
