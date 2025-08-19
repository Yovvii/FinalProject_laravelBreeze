<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->fresh();
        $isPasswordChanged = !is_null($user->password_changed_at);

        $siswa = $user->siswa;

        $tanggal_lahir = $siswa->tanggal_lahir;
        $tanggal_lahir_formatted = Carbon::parse($tanggal_lahir)->format('dmY');

        $currentStep = $request->input('step', 1);

        return view('dashboard', compact('user', 'siswa', 'tanggal_lahir_formatted','isPasswordChanged', 'currentStep'));
    }
}
