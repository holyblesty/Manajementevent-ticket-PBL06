<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('pembayaran');
    }

    public function proses(Request $request)
    {
        $status = $request->status;
        $metode = $request->metode;

        return view('hasil_pembayaran', compact('status', 'metode'));
    }
}