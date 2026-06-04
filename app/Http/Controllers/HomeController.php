<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $jumlahPengunjung = User::count();

        $jumlahEvent = Event::count();

        $totalRegistrasi = Registration::count();

        $events = Event::latest()->get();

        return view('pengunjung.dashboard', compact(
            'jumlahPengunjung',
            'jumlahEvent',
            'totalRegistrasi',
            'events'
        ));
    }
}