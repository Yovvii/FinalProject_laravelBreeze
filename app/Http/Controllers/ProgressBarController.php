<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgressBarController extends Controller
{
    public function index()
    {
        return view('account.progress_bar');
    }
}
