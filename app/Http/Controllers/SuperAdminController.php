<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataSma;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function createAdminForm()
    {
        // Ambil daftar sekolah yang belum memiliki admin
        $schools = DataSma::doesntHave('admin')->get();

        return view('super_admin.create_admin', compact('schools'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'sma_data_id' => [
                'required',
                'exists:sma_datas,id',
                // Pastikan sekolah yang dipilih belum memiliki admin
                Rule::unique('users')->where(fn ($query) => $query->where('role', 'admin_sekolah'))
            ],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_sekolah',
            'sma_data_id' => $request->sma_data_id,
        ]);

        return redirect()->route('super_admin.dashboard')->with('success', 'Admin sekolah berhasil dibuat.');
    }
}
