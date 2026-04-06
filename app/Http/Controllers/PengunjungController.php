<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function dashboard()
    {
        return view('dashboard_pengunjung');
    }
      public function pendaftaran()
    {
        return view('pendaftaran');
    }
}