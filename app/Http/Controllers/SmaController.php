<?php

namespace App\Http\Controllers;

use App\Models\DataSma;
use Illuminate\Http\Request;

class SmaController extends Controller
{
    public function index()
    {
        $data_sekolah_sma = DataSma::with('akreditasi')->get();
        return view('pendaftaran_sma', compact('data_sekolah_sma'));
    }
}