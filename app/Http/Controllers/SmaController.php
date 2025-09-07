<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmaController extends Controller
{
    public function index()
    {
        return view('pendaftaran_sma');
    }
}