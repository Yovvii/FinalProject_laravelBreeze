<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class PasswordController extends Controller
{
    /**
     * Update the password for the user.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate the new password length...
 
        $request->user()->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();
 
        return redirect('/profile');
    }
}
