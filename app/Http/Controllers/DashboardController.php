<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->fresh();

        $siswa = $user->siswa;

        $isPasswordChanged = !is_null($siswa->password_changed_at);
        $tanggal_lahir = $siswa->tanggal_lahir;
        $tanggal_lahir_formatted = Carbon::parse($tanggal_lahir)->format('dmY');

        $currentStep = $user->timelineProgress->current_step ?? 1;

        return view('dashboard', compact('user', 'siswa', 'tanggal_lahir_formatted','isPasswordChanged', 'currentStep'));
    }
}
