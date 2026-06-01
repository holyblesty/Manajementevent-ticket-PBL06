<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Tiket;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // User login
        $user = Auth::user();

        // Search event
        $search = $request->query('search');

        $eventQuery = Event::query();

        if (!empty($search)) {
            $eventQuery->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Event rekomendasi
        $recommendedEvents = $eventQuery
            ->latest()
            ->take(6)
            ->get();

        // Total jenis tiket
        $totalTickets = Tiket::count();

        // Placeholder sementara
        $totalRegistrations = 0;
        $upcomingEvents = 0;

        return view('pengunjung.dashboard', [
            'user' => $user,
            'events' => $recommendedEvents,
            'totalTickets' => $totalTickets,
            'totalRegistrations' => $totalRegistrations,
            'upcomingEvents' => $upcomingEvents,
            'search' => $search,
        ]);
    }
}