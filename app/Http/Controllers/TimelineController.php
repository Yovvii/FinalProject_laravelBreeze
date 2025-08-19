<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $currentStep = $request->input('step', 1);

        return view('account.timeline', compact('currentStep'));
    }

    public function updateBiodata()
    {
        //
    }
}
